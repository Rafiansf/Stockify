<?php

namespace App\Observers;

use App\Models\StockTransaction;
use App\Models\ActivityLog;

class StockTransactionObserver
{
    /**
     * Catat log saat terjadi mutasi stok baru (Masuk/Keluar).
     */
    public function created(StockTransaction $transaction): void
    {
        $productName = $transaction->product->name ?? 'Produk';
        $typeLabel   = $transaction->type === 'in' ? 'Stok Masuk' : 'Stok Keluar';
        $sign        = $transaction->type === 'in' ? '+' : '-';

        ActivityLog::record(
            "Transaksi {$typeLabel}",
            "Mencatat mutasi {$typeLabel} sejumlah {$sign}{$transaction->quantity} unit untuk produk '{$productName}'."
        );
    }

    /**
     * Catat log saat transaksi stok dihapus.
     */
    public function deleted(StockTransaction $transaction): void
    {
        $productName = $transaction->product->name ?? 'Produk';
        $typeLabel   = $transaction->type === 'in' ? 'Stok Masuk' : 'Stok Keluar';

        ActivityLog::record(
            'Pembatalan Transaksi',
            "Menghapus/membatalkan riwayat transaksi {$typeLabel} ({$transaction->quantity} unit) pada produk '{$productName}'."
        );
    }
}