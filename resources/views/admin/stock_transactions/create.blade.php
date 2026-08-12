@extends('layouts.admin')

@section('content')
<div class="p-4 bg-white dark:bg-gray-800 block border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm mb-4">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">
                Catat Stok {{ $type === 'in' ? 'Masuk' : 'Keluar' }}
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Input transaksi pergerakan barang gudang.</p>
        </div>
        <a href="{{ route('admin.stock-transactions.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>
</div>

<div class="p-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm">
    <form action="{{ route('admin.stock-transactions.store') }}" method="POST">
        @csrf
        <input type="hidden" name="type" value="{{ $type }}">

        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <!-- Pilih Produk -->
            <div class="md:col-span-2">
                <label for="product_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Produk <span class="text-red-500">*</span></label>
                <select id="product_id" name="product_id" class="bg-gray-50 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white dark:bg-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                    <option value="">-- Pilih Barang --</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                            {{ $product->code }} - {{ $product->name }} (Stok Saat Ini: {{ $product->stock }})
                        </option>
                    @endforeach
                </select>
                @error('product_id')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            @if($type === 'in')
            <!-- Supplier (Khusus Stok Masuk) -->
            <div>
                <label for="supplier_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Supplier (Opsional)</label>
                <select id="supplier_id" name="supplier_id" class="bg-gray-50 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white dark:bg-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="">-- Tanpa Supplier / Umum --</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            @endif

            <!-- Jumlah -->
            <div class="{{ $type === 'out' ? 'md:col-span-1' : '' }}">
                <label for="quantity" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah (Qty) <span class="text-red-500">*</span></label>
                <input type="number" id="quantity" name="quantity" min="1" value="{{ old('quantity', 1) }}" class="bg-gray-50 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white dark:bg-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                @error('quantity')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal -->
            <div>
                <label for="date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Transaksi <span class="text-red-500">*</span></label>
                <input type="date" id="date" name="date" value="{{ old('date', date('Y-m-d')) }}" class="bg-gray-50 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white dark:bg-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                @error('date')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Catatan -->
            <div class="md:col-span-2">
                <label for="notes" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Catatan / Keterangan</label>
                <textarea id="notes" name="notes" rows="3" class="bg-gray-50 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white dark:bg-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:placeholder-gray-400" placeholder="Contoh: Pembelian stok baru / Restock / Barang rusak">{{ old('notes') }}</textarea>
            </div>
        </div>

        <div class="flex items-center space-x-3">
            <button type="submit" class="text-white {{ $type === 'in' ? 'bg-green-600 hover:bg-green-700 dark:bg-green-600 dark:hover:bg-green-700' : 'bg-red-600 hover:bg-red-700 dark:bg-red-600 dark:hover:bg-red-700' }} font-medium rounded-lg text-sm px-5 py-2.5 transition shadow-sm">
                Simpan Stok {{ $type === 'in' ? 'Masuk' : 'Keluar' }}
            </button>
            <button type="reset" class="px-5 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition shadow-sm border border-gray-200 dark:border-gray-600">
                Batal
            </button>
        </div>
    </form>
</div>
@endsection