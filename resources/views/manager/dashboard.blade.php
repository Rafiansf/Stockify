@extends('layouts.admin')

@section('title', 'Dashboard Manajer Gudang')

@section('content')
<div class="space-y-6">
    <!-- Header Halaman -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Dashboard Manajer Gudang</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Ringkasan pergerakan stok dan status gudang hari ini.</p>
        </div>
        <span class="w-fit px-3 py-1 text-xs font-semibold text-indigo-700 bg-indigo-100 rounded-full dark:bg-indigo-900/40 dark:text-indigo-300">
            Akses Manajer
        </span>
    </div>

    <!-- Ringkasan Statistik (3 Card Utama) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Card 1: Stok Menipis -->
        <div class="p-5 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700 flex items-center justify-between {{ $lowStockCount > 0 ? 'ring-1 ring-amber-100 dark:ring-amber-900/40' : '' }}">
            <div>
                <span class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Stok Menipis</span>
                <h3 class="text-2xl font-bold text-amber-600 dark:text-amber-400 mt-1">{{ number_format($lowStockCount) }} <span class="text-base font-medium text-gray-500 dark:text-gray-400">Item</span></h3>
            </div>
            <div class="p-3 bg-amber-50 text-amber-600 rounded-full dark:bg-amber-900/40 dark:text-amber-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>
            </div>
        </div>

        <!-- Card 2: Barang Masuk Hari Ini -->
        <div class="p-5 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700 flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Barang Masuk Hari Ini</span>
                <h3 class="text-2xl font-bold text-emerald-600 dark:text-emerald-400 mt-1">+{{ number_format($todayIncoming) }} <span class="text-base font-medium text-gray-500 dark:text-gray-400">Pcs</span></h3>
            </div>
            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-full dark:bg-emerald-900/40 dark:text-emerald-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15.75l4.5 4.5 4.5-4.5m-9-6l4.5 4.5 4.5-4.5" /></svg>
            </div>
        </div>

        <!-- Card 3: Barang Keluar Hari Ini -->
        <div class="p-5 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700 flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Barang Keluar Hari Ini</span>
                <h3 class="text-2xl font-bold text-blue-600 dark:text-blue-400 mt-1">-{{ number_format($todayOutgoing) }} <span class="text-base font-medium text-gray-500 dark:text-gray-400">Pcs</span></h3>
            </div>
            <div class="p-3 bg-blue-50 text-blue-600 rounded-full dark:bg-blue-900/40 dark:text-blue-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 8.25l-4.5-4.5-4.5 4.5m9 6l-4.5 4.5-4.5-4.5" /></svg>
            </div>
        </div>
    </div>

    <!-- Tabel Daftar Produk Mencapai Batas Minimum -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700 overflow-hidden">
        <div class="p-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
            <h2 class="text-base font-bold text-gray-900 dark:text-white">
                Daftar Barang Mencapai Batas Minimum
            </h2>
            <a href="{{ route('manager.products.index') }}" class="text-xs font-semibold text-indigo-600 hover:underline dark:text-indigo-400">Lihat Semua Produk</a>
        </div>

        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700/60 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-4 py-2.5">Kode</th>
                        <th scope="col" class="px-4 py-2.5">Nama Produk</th>
                        <th scope="col" class="px-4 py-2.5">Kategori</th>
                        <th scope="col" class="px-4 py-2.5 text-center">Sisa Stok</th>
                        <th scope="col" class="px-4 py-2.5 text-center">Min. Stok</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($lowStockProducts as $product)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40">
                            <td class="px-4 py-3 font-mono text-xs text-gray-500 dark:text-gray-400">{{ $product->code ?? '-' }}</td>
                            <td class="px-4 py-3 font-semibold text-gray-900 dark:text-white">{{ $product->name }}</td>
                            <td class="px-4 py-3">{{ $product->category?->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-center font-bold text-red-600 dark:text-red-400">
                                {{ $product->stock }} Pcs
                            </td>
                            <td class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">
                                {{ $product->min_stock }} Pcs
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    Tidak ada produk yang mengalami stok menipis saat ini.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
