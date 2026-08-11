@extends('layouts.admin')

@section('title', 'Laporan Stok Barang')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Laporan Stok Barang</h1>
    </div>

    <!-- Filter Form -->
    <div class="p-4 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
        <form method="GET" action="{{ route('admin.reports.stock') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Filter Kategori -->
            <div>
                <label for="category_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kategori</label>
                <select name="category_id" id="category_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Status Stok -->
            <div>
                <label for="stock_status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status Stok</label>
                <select name="stock_status" id="stock_status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                    <option value="">Semua Status</option>
                    <option value="safe" {{ request('stock_status') === 'safe' ? 'selected' : '' }}>Aman</option>
                    <option value="low" {{ request('stock_status') === 'low' ? 'selected' : '' }}>Menipis</option>
                    <option value="empty" {{ request('stock_status') === 'empty' ? 'selected' : '' }}>Habis</option>
                </select>
            </div>

            <!-- Tombol Filter & Reset -->
            <div class="flex items-end space-x-2">
                <button type="submit" class="px-4 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300">
                    Filter
                </button>
                <a href="{{ route('admin.reports.stock') }}" class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Tabel Laporan Stok -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-gray-800 dark:border-gray-700">
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Nama Produk</th>
                        <th class="px-4 py-3">Kategori</th>
                        <th class="px-4 py-3 text-center">Stok Minimal</th>
                        <th class="px-4 py-3 text-center">Stok Fisik</th>
                        <th class="px-4 py-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $index => $product)
                        <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-4 py-3">{{ $products->firstItem() + $index }}</td>
                            <td class="px-4 py-3 font-semibold text-gray-900 dark:text-white">{{ $product->name }}</td>
                            <td class="px-4 py-3">{{ $product->category?->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-center">{{ $product->min_stock }}</td>
                            <td class="px-4 py-3 text-center font-bold text-gray-900 dark:text-white">{{ $product->stock }}</td>
                            <td class="px-4 py-3 text-center">
                                @if($product->stock <= 0)
                                    <span class="px-2.5 py-0.5 text-xs font-semibold text-red-800 bg-red-100 rounded-full dark:bg-red-900/50 dark:text-red-300">Habis</span>
                                @elseif($product->stock <= $product->min_stock)
                                    <span class="px-2.5 py-0.5 text-xs font-semibold text-amber-800 bg-amber-100 rounded-full dark:bg-amber-900/50 dark:text-amber-300">Menipis</span>
                                @else
                                    <span class="px-2.5 py-0.5 text-xs font-semibold text-green-800 bg-green-100 rounded-full dark:bg-green-900/50 dark:text-green-300">Aman</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">Tidak ada data stok produk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-200 dark:border-gray-700">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection