<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Jumlah dan Daftar Produk dengan Stok Menipis (stok <= min_stock)
        $lowStockQuery = Product::whereColumn('stock', '<=', 'min_stock');
        $lowStockCount = $lowStockQuery->count();
        $lowStockProducts = $lowStockQuery->with('category')->latest()->take(5)->get();

        // 2. Total Barang Masuk Hari Ini
        $todayIncoming = StockTransaction::whereDate('created_at', Carbon::today())
            ->whereIn('type', ['in', 'masuk'])
            ->sum('quantity');

        // 3. Total Barang Keluar Hari Ini
        $todayOutgoing = StockTransaction::whereDate('created_at', Carbon::today())
            ->whereIn('type', ['out', 'keluar'])
            ->sum('quantity');

        return view('manager.dashboard', compact(
            'lowStockCount',
            'lowStockProducts',
            'todayIncoming',
            'todayOutgoing'
        ));
    }
}