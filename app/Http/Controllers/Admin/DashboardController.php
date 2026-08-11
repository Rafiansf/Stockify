<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\Supplier;
use App\Models\ActivityLog; // <-- Ditambahkan
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Metric Utama
        $totalProducts = Product::count();
        $lowStockCount = Product::whereColumn('stock', '<=', 'min_stock')->count();
        $totalTransactions = StockTransaction::count();
        $totalSuppliers = Supplier::count();

        // Daftar Produk yang Mencapai Minimum Stok
        $lowStockProducts = Product::with('category')
            ->whereColumn('stock', '<=', 'min_stock')
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();

        // 5 Transaksi Stok Terbaru
        $recentTransactions = StockTransaction::with(['product', 'supplier'])
            ->latest('date')
            ->latest('id')
            ->take(5)
            ->get();

        // 5 Aktivitas Pengguna Terbaru
        $recentActivities = ActivityLog::with('user')
            ->latest()
            ->take(5)
            ->get();

        // --- AGREGASI DATA UNTUK CHART.JS ---
        $currentYear = date('Y');
        
        $monthlyTransactions = StockTransaction::select(
                DB::raw('MONTH(date) as month'),
                'type',
                DB::raw('SUM(quantity) as total_qty')
            )
            ->whereYear('date', $currentYear)
            ->groupBy('month', 'type')
            ->get();

        $chartMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $stockInMonthly = array_fill(0, 12, 0);
        $stockOutMonthly = array_fill(0, 12, 0);

        foreach ($monthlyTransactions as $trx) {
            $monthIndex = $trx->month - 1;
            if ($trx->type === 'in') {
                $stockInMonthly[$monthIndex] = (int) $trx->total_qty;
            } else {
                $stockOutMonthly[$monthIndex] = (int) $trx->total_qty;
            }
        }

        return view('admin.dashboard', compact(
            'totalProducts',
            'lowStockCount',
            'totalTransactions',
            'totalSuppliers',
            'lowStockProducts',
            'recentTransactions',
            'recentActivities', // <-- Ditambahkan
            'chartMonths',
            'stockInMonthly',
            'stockOutMonthly',
            'currentYear'
        ));
    }
}