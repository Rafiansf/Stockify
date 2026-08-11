<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    // 1. Laporan Stok Barang (Per Periode & Per Kategori)
    public function stock(Request $request)
    {
        $categories = Category::orderBy('name', 'asc')->get();
        $query = Product::with(['category', 'supplier']);

        // Filter Berdasarkan Kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter Berdasarkan Periode Tanggal Dibuat/Didaftarkan
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00', 
                $request->end_date . ' 23:59:59'
            ]);
        }

        $products = $query->latest()->get();

        return view('manager.reports.stock', compact('products', 'categories'));
    }

    // 2. Laporan Barang Masuk & Keluar (Per Periode & Jenis Transaksi)
    public function transactions(Request $request)
    {
        $query = StockTransaction::with(['product.category', 'user']);

        // Filter Tipe Transaksi (Masuk / Keluar)
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter Periode Tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00', 
                $request->end_date . ' 23:59:59'
            ]);
        }

        $transactions = $query->latest()->get();

        return view('manager.reports.transactions', compact('transactions'));
    }
}