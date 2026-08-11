<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\ActivityLog;

class ProductObserver
{
    /**
     * Catat log saat produk baru dibuat.
     */
    public function created(Product $product): void
    {
        ActivityLog::record(
            'Tambah Produk',
            "Menambahkan produk baru '{$product->name}' (Kode: {$product->code}) dengan stok awal {$product->stock} unit."
        );
    }

    /**
     * Catat log saat data produk diperbarui.
     */
    public function updated(Product $product): void
    {
        // Hanya catat jika ada perubahan pada kolom tertentu selain timestamps
        $changes = array_keys($product->getChanges());
        $ignored = ['updated_at', 'created_at'];
        $filteredChanges = array_diff($changes, $ignored);

        if (!empty($filteredChanges)) {
            $changedFields = implode(', ', $filteredChanges);
            ActivityLog::record(
                'Update Produk',
                "Mengubah data produk '{$product->name}' (Perubahan pada field: {$changedFields})."
            );
        }
    }

    /**
     * Catat log saat produk dihapus.
     */
    public function deleted(Product $product): void
    {
        ActivityLog::record(
            'Hapus Produk',
            "Menghapus produk '{$product->name}' (Kode: {$product->code}) dari database."
        );
    }
}