@extends('layouts.admin')

@section('title', 'Detail Produk')

@section('content')
<div class="space-y-6">
    <!-- Header dengan Tombol Kembali -->
    <div class="flex items-center gap-4">
        <a href="{{ route('manager.products.index') }}" class="p-2 text-gray-500 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 hover:text-gray-900 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 dark:hover:text-white">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Detail Produk</h1>
    </div>

    <!-- Informasi Detail Produk -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                
                <div>
                    <span class="block text-sm font-medium text-gray-500 dark:text-gray-400">Nama Produk</span>
                    <strong class="block mt-1 text-lg text-gray-900 dark:text-white">{{ $product->name }}</strong>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500 dark:text-gray-400">Kode Barcode / SKU</span>
                    <strong class="block mt-1 text-lg font-mono text-gray-900 dark:text-white">{{ $product->code ?? '-' }}</strong>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500 dark:text-gray-400">Kategori</span>
                    <strong class="block mt-1 text-base text-gray-900 dark:text-white">{{ $product->category?->name ?? 'Tanpa Kategori' }}</strong>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500 dark:text-gray-400">Supplier Utama</span>
                    <strong class="block mt-1 text-base text-gray-900 dark:text-white">{{ $product->supplier?->name ?? '-' }}</strong>
                </div>

                <div class="p-4 bg-gray-50 rounded-lg dark:bg-gray-700">
                    <span class="block text-sm font-medium text-gray-500 dark:text-gray-300">Stok Tersedia</span>
                    <div class="flex items-end gap-2 mt-1">
                        <strong class="text-3xl text-gray-900 dark:text-white">{{ number_format($product->stock) }}</strong>
                        <span class="text-sm font-medium text-gray-500 mb-1">Pcs</span>
                    </div>
                </div>

                <div class="p-4 bg-gray-50 rounded-lg dark:bg-gray-700">
                    <span class="block text-sm font-medium text-gray-500 dark:text-gray-300">Batas Minimum Stok</span>
                    <div class="flex items-end gap-2 mt-1">
                        <strong class="text-3xl {{ $product->stock <= $product->min_stock ? 'text-red-600 dark:text-red-400' : 'text-gray-900 dark:text-white' }}">
                            {{ number_format($product->min_stock) }}
                        </strong>
                        <span class="text-sm font-medium text-gray-500 mb-1">Pcs</span>
                    </div>
                </div>
            </div>
            
            <!-- Deskripsi -->
            @if($product->description)
            <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                <span class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Deskripsi Keterangan</span>
                <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $product->description }}</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection