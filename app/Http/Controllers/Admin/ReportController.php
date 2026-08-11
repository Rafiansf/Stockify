<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StockTransaction;
use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Laporan Stok Barang (Per Kategori & Status Stok)
     */
    public function stock(Request $request)
    {
        $categories = Category::orderBy('name')->get();
        $query = Product::with(['category', 'supplier']);

        // Filter Kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter Status Stok (Aman, Menipis, Habis)
        if ($request->filled('stock_status')) {
            if ($request->stock_status === 'low') {
                $query->whereColumn('stock', '<=', 'min_stock')->where('stock', '>', 0);
            } elseif ($request->stock_status === 'empty') {
                $query->where('stock', 0);
            } elseif ($request->stock_status === 'safe') {
                $query->whereColumn('stock', '>', 'min_stock');
            }
        }

        $products = $query->paginate(15)->withQueryString();

        return view('admin.reports.stock', compact('products', 'categories'));
    }

    /**
     * Laporan Transaksi Stok (Masuk, Keluar, Penyesuaian)
     */
    public function transactions(Request $request)
    {
        $categories = Category::orderBy('name')->get();
        $query = StockTransaction::with(['product.category', 'user']);

        // Filter Rentang Tanggal berdasarkan kolom 'date'
        if ($request->filled('start_date')) {
            $query->whereDate('date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('date', '<=', $request->end_date);
        }

        // Filter Tipe Transaksi
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter Kategori Produk
        if ($request->filled('category_id')) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('category_id', $request->category_id);
            });
        }

        $totalIn = (clone $query)->where('type', 'in')->sum('quantity');
        $totalOut = (clone $query)->where('type', 'out')->sum('quantity');
        $totalAdjustment = (clone $query)->where('type', 'adjustment')->sum('quantity');

        $transactions = $query->latest('date')->latest('id')->paginate(15)->withQueryString();

        return view('admin.reports.transactions', compact('transactions', 'categories', 'totalIn', 'totalOut', 'totalAdjustment'));
    }

    /**
     * Laporan Activity Log Pengguna
     */
    public function activityLogs(Request $request)
    {
        $users = User::orderBy('name')->get();
        $query = ActivityLog::with('user');

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $logs = $query->latest()->paginate(20)->withQueryString();

        return view('admin.reports.activity_logs', compact('logs', 'users'));
    }
}