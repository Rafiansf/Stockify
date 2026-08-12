@extends('layouts.admin')

@section('content')
<div class="p-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm mb-4">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Edit Kategori</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Ubah rincian kategori {{ $category->name }}.</p>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="text-gray-700 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-2 focus:outline-none transition">
            &larr; Kembali
        </a>
    </div>
</div>

<div class="p-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm">
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="space-y-6 mb-6">
            <!-- Nama Kategori -->
            <div>
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Kategori <span class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" class="bg-gray-50 dark:bg-gray-700 border @error('name') border-red-500 @else border-gray-300 dark:border-gray-600 @enderror text-gray-900 dark:text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi (Opsional)</label>
                <textarea id="description" name="description" rows="4" class="bg-gray-50 dark:bg-gray-700 border @error('description') border-red-500 @else border-gray-300 dark:border-gray-600 @enderror text-gray-900 dark:text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-center space-x-3">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 transition">
                Perbarui Kategori
            </button>
            <button type="reset" class="text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:focus:ring-gray-600 rounded-lg border border-gray-300 dark:border-gray-600 text-sm font-medium px-5 py-2.5 transition">
                Reset
            </button>
        </div>
    </form>
</div>
@endsection