@extends('layouts.admin')

@section('content')
<div class="p-4 bg-white block border-b border-gray-200 rounded-lg shadow-sm mb-4">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl">Tambah Kategori Baru</h1>
            <p class="text-sm text-gray-500">Tambahkan kategori untuk mengelompokkan barang di stok gudang.</p>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="text-gray-700 bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-2 focus:outline-none">
            &larr; Kembali
        </a>
    </div>
</div>

<div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div class="space-y-6 mb-6">
            <!-- Nama Kategori -->
            <div>
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nama Kategori <span class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="bg-gray-50 border @error('name') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Contoh: Elektronik, Pakaian, Makanan" required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Deskripsi (Opsional)</label>
                <textarea id="description" name="description" rows="4" class="bg-gray-50 border @error('description') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Tulis catatan singkat mengenai kategori ini...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-center space-x-3">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                Simpan Kategori
            </button>
            <a href="{{ route('admin.categories.index') }}" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection