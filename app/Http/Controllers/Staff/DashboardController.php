<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\StockTransaction;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data transaksi masuk yang masih pending
        $incomingTasks = StockTransaction::whereIn('type', ['in', 'masuk'])
            ->where('status', 'pending')
            ->with(['product', 'user'])
            ->latest()
            ->get();

        // Ambil data transaksi keluar yang masih pending
        $outgoingTasks = StockTransaction::whereIn('type', ['out', 'keluar'])
            ->where('status', 'pending')
            ->with(['product', 'user'])
            ->latest()
            ->get();

        return view('staff.dashboard', compact('incomingTasks', 'outgoingTasks'));
    }
}