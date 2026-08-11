<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StockOpname;
use App\Models\StockOpnameItem;
use App\Models\Product;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StockOpnameController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $opnames = StockOpname::with(['user', 'items.product'])->latest()->paginate(10);

        return view('admin.stock_opnames.index', compact('products', 'opnames'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'status' => 'required|string',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.physical_stock' => 'required|integer|min:0',
            'items.*.reason' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $dateCode = date('Ymd', strtotime($request->date));
            $lastOpname = StockOpname::whereDate('date', $request->date)->latest()->first();
            $lastNumber = $lastOpname ? (int) substr($lastOpname->opname_number, -3) : 0;
            $opnameNumber = 'SOP-' . $dateCode . '-' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

            $stockOpname = StockOpname::create([
                'opname_number' => $opnameNumber,
                'date' => $request->date,
                'user_id' => Auth::id(),
                'status' => $request->status,
            ]);

            foreach ($request->items as $itemData) {
                $product = Product::findOrFail($itemData['product_id']);
                $systemStock = $product->stock;
                $physicalStock = (int) $itemData['physical_stock'];
                $difference = $physicalStock - $systemStock;

                StockOpnameItem::create([
                    'stock_opname_id' => $stockOpname->id,
                    'product_id' => $product->id,
                    'system_stock' => $systemStock,
                    'physical_stock' => $physicalStock,
                    'difference' => $difference,
                    'reason' => $itemData['reason'] ?? null,
                ]);

                if ($request->status === 'completed') {
                    $product->update([
                        'stock' => $physicalStock
                    ]);
                }
            }

            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'Stock Opname',
                'description' => 'Melakukan stock opname dengan nomor ' . $opnameNumber,
            ]);

            DB::commit();

            return redirect()->route('admin.stock-opnames.index')
                             ->with('success', 'Data Stock Opname berhasil disimpan dan stok produk telah diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $opname = StockOpname::with(['user', 'items.product'])->findOrFail($id);
        return view('admin.stock_opnames.show', compact('opname'));
    }
}