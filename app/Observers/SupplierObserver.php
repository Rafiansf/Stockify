<?php

namespace App\Observers;

use App\Models\Supplier;
use App\Models\ActivityLog;

class SupplierObserver
{
    /**
     * Catat log saat supplier baru ditambahkan.
     */
    public function created(Supplier $supplier): void
    {
        ActivityLog::record(
            'Tambah Supplier',
            "Menambahkan supplier baru '{$supplier->name}' (Telepon: {$supplier->phone})."
        );
    }

    /**
     * Catat log saat data supplier diperbarui.
     */
    public function updated(Supplier $supplier): void
    {
        ActivityLog::record(
            'Update Supplier',
            "Mengubah informasi data supplier '{$supplier->name}'."
        );
    }

    /**
     * Catat log saat data supplier dihapus.
     */
    public function deleted(Supplier $supplier): void
    {
        ActivityLog::record(
            'Hapus Supplier',
            "Menghapus data supplier '{$supplier->name}'."
        );
    }
}