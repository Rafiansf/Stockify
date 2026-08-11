<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StockTransaction;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = StockTransaction::with(['product', 'supplier']);

        // Filter berdasarkan Tipe Transaksi (in / out)
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter berdasarkan Tanggal Mulai
        if ($request->filled('start_date')) {
            $query->whereDate('date', '>=', $request->start_date);
        }

        // Filter berdasarkan Tanggal Selesai
        if ($request->filled('end_date')) {
            $query->whereDate('date', '<=', $request->end_date);
        }

        // Pencarian Kata Kunci (Nama Produk, Kode Produk, atau Catatan)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('product', function ($pQuery) use ($search) {
                    $pQuery->where('name', 'like', "%{$search}%")
                           ->orWhere('code', 'like', "%{$search}%");
                })->orWhere('notes', 'like', "%{$search}%");
            });
        }

        // Urutkan transaksi terbaru dan pertahankan query string saat paginasi
        $transactions = $query->latest('date')->latest('id')->paginate(10)->withQueryString();

        return view('admin.stock_transactions.index', compact('transactions'));
    }

    public function create(Request $request)
    {
        $type = $request->get('type', 'in');
        $products = Product::all();
        $suppliers = Supplier::all();

        return view('admin.stock_transactions.create', compact('type', 'products', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id'  => 'required|exists:products,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'type'        => 'required|in:in,out',
            'quantity'    => 'required|integer|min:1',
            'date'        => 'required|date',
            'notes'       => 'nullable|string',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($request->type === 'out' && $product->stock < $request->quantity) {
            return back()->withInput()->withErrors(['quantity' => 'Stok produk tidak mencukupi. Stok saat ini: ' . $product->stock]);
        }

        DB::transaction(function () use ($request, $product) {
            StockTransaction::create([
                'product_id'  => $request->product_id,
                'user_id'     => auth()->id(),
                'supplier_id' => $request->type === 'in' ? $request->supplier_id : null,
                'type'        => $request->type,
                'quantity'    => $request->quantity,
                'date'        => $request->date,
                'notes'       => $request->notes,
            ]);

            if ($request->type === 'in') {
                $product->increment('stock', $request->quantity);
            } else {
                $product->decrement('stock', $request->quantity);
            }
        });

        return redirect()->route('admin.stock-transactions.index')->with('success', 'Transaksi stok berhasil dicatat.');
    }
}