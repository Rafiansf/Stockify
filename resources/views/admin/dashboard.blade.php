@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Dashboard Ringkasan Inventaris</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Pantau performa stok barang dan riwayat mutasi gudang {{ $globalSetting->app_name ?? 'Stockify' }} secara real-time.</p>
        </div>
        <span class="w-fit px-3 py-1 text-xs font-semibold text-indigo-700 bg-indigo-100 rounded-full dark:bg-indigo-900/40 dark:text-indigo-300">
            Akses Admin
        </span>
    </div>

    <!-- Grid Statistic Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Produk -->
        <div class="p-5 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700 flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Total Produk</span>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($totalProducts) }}</h3>
            </div>
            <div class="p-3 bg-blue-50 text-blue-600 rounded-full dark:bg-blue-900/40 dark:text-blue-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" /></svg>
            </div>
        </div>

        <!-- Stok Menipis -->
        <div class="p-5 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700 flex items-center justify-between {{ $lowStockCount > 0 ? 'ring-1 ring-red-100 dark:ring-red-900/40' : '' }}">
            <div>
                <span class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Peringatan Stok</span>
                <h3 class="text-2xl font-bold {{ $lowStockCount > 0 ? 'text-red-600 dark:text-red-400' : 'text-gray-900 dark:text-white' }} mt-1">{{ number_format($lowStockCount) }}</h3>
            </div>
            <div class="p-3 bg-red-50 text-red-600 rounded-full dark:bg-red-900/40 dark:text-red-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>
            </div>
        </div>

        <!-- Total Mutasi Stok -->
        <div class="p-5 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700 flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Total Mutasi Stok</span>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($totalTransactions) }}</h3>
            </div>
            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-full dark:bg-emerald-900/40 dark:text-emerald-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5M16.5 3L21 7.5m0 0L16.5 12M21 7.5H7.5" /></svg>
            </div>
        </div>

        <!-- Total Supplier -->
        <div class="p-5 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700 flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Total Supplier</span>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($totalSuppliers) }}</h3>
            </div>
            <div class="p-3 bg-purple-50 text-purple-600 rounded-full dark:bg-purple-900/40 dark:text-purple-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v11.177m0-11.177L12.164 4.31a2.056 2.056 0 00-1.58-.86H4.874a2.056 2.056 0 00-1.58.86L1.32 7.573a2.056 2.056 0 00-.32 1.096V14.25" /></svg>
            </div>
        </div>
    </div>

    <!-- Widget Chart.js Tren Mutasi Stok -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 dark:bg-gray-800 dark:border-gray-700">
        <div class="flex items-center justify-between mb-4 border-b border-gray-100 dark:border-gray-700 pb-3">
            <div>
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">Grafik Tren Transaksi Stok Bulanan</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400">Perbandingan pergerakan stok masuk vs. stok keluar (Tahun {{ $currentYear }})</p>
            </div>
        </div>
        <div class="relative w-full h-80">
            <canvas id="stockTrendChart"></canvas>
        </div>
    </div>

    <!-- Layout Dua Kolom Ringkasan -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Widget Peringatan Stok Menipis -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700 overflow-hidden">
            <div class="flex items-center justify-between p-4 border-b border-gray-100 dark:border-gray-700">
                <h2 class="text-base font-bold text-gray-900 dark:text-white flex items-center">
                    <span class="w-2.5 h-2.5 bg-red-500 rounded-full mr-2"></span> Stok Menipis / Habis
                </h2>
                <a href="{{ route('admin.products.index') }}" class="text-xs font-semibold text-indigo-600 hover:underline dark:text-indigo-400">Lihat Semua</a>
            </div>
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700/60 dark:text-gray-400">
                        <tr>
                            <th class="px-4 py-2.5">Produk</th>
                            <th class="px-4 py-2.5">Kategori</th>
                            <th class="px-4 py-2.5 text-center">Stok</th>
                            <th class="px-4 py-2.5 text-center">Min. Stok</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($lowStockProducts as $product)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40">
                            <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $product->name }}</td>
                            <td class="px-4 py-3">{{ $product->category->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-center font-bold text-red-600 dark:text-red-400">{{ $product->stock }}</td>
                            <td class="px-4 py-3 text-center">{{ $product->min_stock }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    Semua stok produk berada di batas aman.
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Widget Aktivitas Pengguna Terbaru -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700 overflow-hidden">
            <div class="flex items-center justify-between p-4 border-b border-gray-100 dark:border-gray-700">
                <h2 class="text-base font-bold text-gray-900 dark:text-white flex items-center">
                    <span class="w-2.5 h-2.5 bg-purple-500 rounded-full mr-2"></span> Aktivitas Pengguna Terbaru
                </h2>
                <a href="{{ route('admin.reports.activity-logs') }}" class="text-xs font-semibold text-indigo-600 hover:underline dark:text-indigo-400">Lihat Semua</a>
            </div>
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700/60 dark:text-gray-400">
                        <tr>
                            <th class="px-4 py-2.5">Pengguna</th>
                            <th class="px-4 py-2.5">Aksi</th>
                            <th class="px-4 py-2.5 text-right">Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($recentActivities as $activity)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40">
                            <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $activity->user->name ?? 'Sistem' }}</td>
                            <td class="px-4 py-3">
                                <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $activity->action }}</span>
                                @if($activity->description)
                                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate max-w-xs">{{ $activity->description }}</p>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right whitespace-nowrap text-xs text-gray-500 dark:text-gray-400">
                                {{ $activity->created_at->diffForHumans() }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">Belum ada catatan aktivitas pengguna.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Load Chart.js CDN & Inisialisasi Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById('stockTrendChart').getContext('2d');
        const isDark = document.documentElement.classList.contains('dark');
        const gridColor = isDark ? 'rgba(255,255,255,0.08)' : 'rgba(0,0,0,0.06)';
        const tickColor = isDark ? '#9CA3AF' : '#6B7280';

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($chartMonths),
                datasets: [
                    {
                        label: 'Stok Masuk (+)',
                        data: @json($stockInMonthly),
                        backgroundColor: 'rgba(16, 185, 129, 0.8)',
                        borderColor: 'rgb(16, 185, 129)',
                        borderWidth: 1.5,
                        borderRadius: 4
                    },
                    {
                        label: 'Stok Keluar (-)',
                        data: @json($stockOutMonthly),
                        backgroundColor: 'rgba(239, 68, 68, 0.8)',
                        borderColor: 'rgb(239, 68, 68)',
                        borderWidth: 1.5,
                        borderRadius: 4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: { color: tickColor }
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    x: {
                        grid: { color: gridColor },
                        ticks: { color: tickColor }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: gridColor },
                        ticks: { precision: 0, color: tickColor }
                    }
                }
            }
        });
    });
</script>
@endsection
