@extends('layouts.admin')

@section('title', 'Laporan Stok Barang')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Laporan Stok Barang</h1>
        <button onclick="window.print()" class="px-4 py-2 text-sm font-medium text-white bg-slate-800 rounded-lg hover:bg-slate-900">
            Cetak / PDF
        </button>
    </div>

    <!-- Filter Form -->
    <div class="p-5 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
        <form action="{{ route('manager.reports.stock') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kategori</label>
                <select name="category_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="">-- Semua Kategori --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="w-full px-4 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                    Filter
                </button>
                @if(request()->anyFilled(['category_id', 'start_date', 'end_date']))
                    <a href="{{ route('manager.reports.stock') }}" class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tabel Laporan -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-gray-800 dark:border-gray-700">
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-4 py-3">Kode</th>
                        <th class="px-4 py-3">Nama Produk</th>
                        <th class="px-4 py-3">Kategori</th>
                        <th class="px-4 py-3">Supplier</th>
                        <th class="px-4 py-3 text-center">Stok</th>
                        <th class="px-4 py-3 text-center">Status Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-4 py-3 font-mono text-xs">{{ $product->code ?? '-' }}</td>
                            <td class="px-4 py-3 font-semibold text-gray-900 dark:text-white">{{ $product->name }}</td>
                            <td class="px-4 py-3">{{ $product->category?->name ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $product->supplier?->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-center font-bold text-gray-900 dark:text-white">{{ $product->stock }} Pcs</td>
                            <td class="px-4 py-3 text-center">
                                @if($product->stock <= 0)
                                    <span class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full dark:bg-red-900/50 dark:text-red-300">Habis</span>
                                @elseif($product->stock <= $product->min_stock)
                                    <span class="px-2 py-1 text-xs font-semibold text-amber-800 bg-amber-100 rounded-full dark:bg-amber-900/50 dark:text-amber-300">Menipis</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full dark:bg-green-900/50 dark:text-green-300">Aman</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">Tidak ada data stok sesuai kriteria filter.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection