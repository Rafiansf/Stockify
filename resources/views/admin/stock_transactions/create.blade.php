@extends('layouts.admin')

@section('content')
<div class="p-4 bg-white block border-b border-gray-200 rounded-lg shadow-sm mb-4">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl">
                Catat Stok {{ $type === 'in' ? 'Masuk' : 'Keluar' }}
            </h1>
            <p class="text-sm text-gray-500">Input transaksi pergerakan barang gudang.</p>
        </div>
        <a href="{{ route('admin.stock-transactions.index') }}" class="text-gray-700 bg-gray-100 hover:bg-gray-200 font-medium rounded-lg text-sm px-4 py-2">
            &larr; Kembali
        </a>
    </div>
</div>

<div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
    <form action="{{ route('admin.stock-transactions.store') }}" method="POST">
        @csrf
        <input type="hidden" name="type" value="{{ $type }}">

        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <!-- Pilih Produk -->
            <div class="md:col-span-2">
                <label for="product_id" class="block mb-2 text-sm font-medium text-gray-900">Pilih Produk <span class="text-red-500">*</span></label>
                <select id="product_id" name="product_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                    <option value="">-- Pilih Barang --</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                            {{ $product->code }} - {{ $product->name }} (Stok Saat Ini: {{ $product->stock }})
                        </option>
                    @endforeach
                </select>
                @error('product_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            @if($type === 'in')
            <!-- Supplier (Khusus Stok Masuk) -->
            <div>
                <label for="supplier_id" class="block mb-2 text-sm font-medium text-gray-900">Supplier (Opsional)</label>
                <select id="supplier_id" name="supplier_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
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
                <label for="quantity" class="block mb-2 text-sm font-medium text-gray-900">Jumlah (Qty) <span class="text-red-500">*</span></label>
                <input type="number" id="quantity" name="quantity" min="1" value="{{ old('quantity', 1) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                @error('quantity')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal -->
            <div>
                <label for="date" class="block mb-2 text-sm font-medium text-gray-900">Tanggal Transaksi <span class="text-red-500">*</span></label>
                <input type="date" id="date" name="date" value="{{ old('date', date('Y-m-d')) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                @error('date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Catatan -->
            <div class="md:col-span-2">
                <label for="notes" class="block mb-2 text-sm font-medium text-gray-900">Catatan / Keterangan</label>
                <textarea id="notes" name="notes" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Contoh: Pembelian stok baru / Restock / Barang rusak">{{ old('notes') }}</textarea>
            </div>
        </div>

        <button type="submit" class="text-white {{ $type === 'in' ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700' }} font-medium rounded-lg text-sm px-5 py-2.5">
            Simpan Transaksi Stok {{ $type === 'in' ? 'Masuk' : 'Keluar' }}
        </button>
    </form>
</div>
@endsection