@extends('layouts.admin')

@section('content')
<div class="mb-4">
    <h1 class="text-2xl font-bold text-gray-900">Edit Produk</h1>
    <p class="text-sm text-gray-500">Perbarui informasi detail produk.</p>
</div>

@if($errors->any())
    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200">
        <span class="font-medium">Terjadi kesalahan input:</span>
        <ul class="mt-1.5 list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Nama Produk -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk *</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
        </div>

        <!-- Kategori -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Kategori *</label>
            <select name="category_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Harga Beli & Harga Jual -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Harga Beli (Rp)</label>
                <input type="number" name="purchase_price" value="{{ old('purchase_price', $product->purchase_price) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" min="0">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Harga Jual (Rp) *</label>
                <input type="number" name="selling_price" value="{{ old('selling_price', $product->selling_price) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required min="0">
            </div>
        </div>

        <!-- Stok -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Stok *</label>
            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required min="0">
        </div>

        <!-- Ukuran & Warna -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Ukuran (Size)</label>
                <input type="text" name="size" value="{{ old('size', $product->size) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Warna</label>
                <input type="text" name="color" value="{{ old('color', $product->color) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
            </div>
        </div>

        <!-- Foto Produk -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Foto Produk</label>
            @if($product->image)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="Preview" class="w-20 h-20 object-cover rounded-lg border">
                </div>
            @endif
            <input type="file" name="image" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50">
            <span class="text-xs text-gray-500 mt-1 block">Kosongkan jika tidak ingin mengubah foto.</span>
        </div>

        <!-- Deskripsi -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Produk</label>
            <textarea name="description" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">Simpan Perubahan</button>
            <a href="{{ route('admin.products.index') }}" class="text-gray-700 bg-gray-200 hover:bg-gray-300 font-medium rounded-lg text-sm px-5 py-2.5">Batal</a>
        </div>
    </form>
</div>
@endsection