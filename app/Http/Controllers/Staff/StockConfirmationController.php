<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockConfirmationController extends Controller
{
    public function index(Request $request)
    {
        $query = StockTransaction::with(['product', 'user']);

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $transactions = $query->latest()->paginate(10);

        return view('staff.confirmations.index', compact('transactions'));
    }

    public function update(Request $request, $id)
    {
        $transaction = StockTransaction::findOrFail($id);

        try {
            DB::transaction(function () use ($transaction) {
                $product = Product::findOrFail($transaction->product_id);
                $isIncoming = in_array(strtolower($transaction->type), ['in', 'masuk']);

                // Pastikan pencocokan status case-insensitive
                if (strtolower(trim($transaction->status)) === 'pending') {
                    if (!$isIncoming && $product->stock < $transaction->quantity) {
                        throw new \Exception("Stok tidak mencukupi! Stok saat ini: {$product->stock} Pcs, diminta: {$transaction->quantity} Pcs.");
                    }

                    if ($isIncoming) {
                        $product->increment('stock', $transaction->quantity);
                    } else {
                        $product->decrement('stock', $transaction->quantity);
                    }

                    // Menggunakan save() langsung agar terhindar dari proteksi mass assignment
                    $transaction->status = 'completed';
                    $transaction->save();
                }
            });

            return back()->with('success', 'Konfirmasi stok berhasil diperbarui.');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}