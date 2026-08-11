<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockTransactionController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::orderBy('name', 'asc')->get();
        
        $query = StockTransaction::with(['product', 'user']);

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $transactions = $query->latest()->paginate(10);

        return view('manager.transactions.index', compact('transactions', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type'       => 'required|in:in,out,masuk,keluar',
            'quantity'   => 'required|integer|min:1',
            'notes'      => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request) {
            $product = Product::findOrFail($request->product_id);

            // Tentukan tipe transaksi
            $isIncoming = in_array($request->type, ['in', 'masuk']);

            // Cek jika barang keluar melebihi stok yang ada
            if (!$isIncoming && $product->stock < $request->quantity) {
                throw new \Exception("Stok tidak mencukupi. Stok saat ini: {$product->stock} Pcs");
            }

            // Update stok produk
            if ($isIncoming) {
                $product->increment('stock', $request->quantity);
            } else {
                $product->decrement('stock', $request->quantity);
            }

            // Catat riwayat transaksi
            StockTransaction::create([
                'product_id' => $product->id,
                'user_id'    => auth()->id(),
                'type'       => $isIncoming ? 'in' : 'out',
                'quantity'   => $request->quantity,
                'notes'      => $request->notes,
            ]);
        });

        return back()->with('success', 'Transaksi stok berhasil dicatat.');
    }
}