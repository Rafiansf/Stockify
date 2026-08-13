@extends('layouts.admin')

@section('content')
<div class="p-4 bg-white dark:bg-gray-800 block border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm mb-4">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Tambah Supplier Baru</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Isi informasi pemasok baru secara lengkap.</p>
        </div>
        <a href="{{ route('admin.suppliers.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>
</div>

<div class="p-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm">
    <form action="{{ route('admin.suppliers.store') }}" method="POST">
        @csrf
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <!-- Nama Supplier -->
            <div>
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Supplier / Perusahaan</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="bg-gray-50 border @error('name') border-red-500 @else border-gray-300 dark:border-gray-600 @enderror text-gray-900 dark:text-white dark:bg-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:placeholder-gray-400" placeholder="PT. Logistik Jaya" required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- No. Telepon (Ditambahkan pattern & title) -->
            <div>
                <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomor Telepon</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone') }}" pattern="[0-9\+\-\s\(\)]+" title="Nomor telepon hanya boleh berisi angka dan simbol (+, -, spasi)" class="bg-gray-50 border @error('phone') border-red-500 @else border-gray-300 dark:border-gray-600 @enderror text-gray-900 dark:text-white dark:bg-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:placeholder-gray-400" placeholder="081234567890" required>
                @error('phone')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email (Opsional) -->
            <div class="md:col-span-2">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat Email (Opsional)</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" class="bg-gray-50 border @error('email') border-red-500 @else border-gray-300 dark:border-gray-600 @enderror text-gray-900 dark:text-white dark:bg-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:placeholder-gray-400" placeholder="supplier@perusahaan.com">
                @error('email')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Alamat -->
            <div class="md:col-span-2">
                <label for="address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat Lengkap</label>
                <textarea id="address" name="address" rows="3" class="bg-gray-50 border @error('address') border-red-500 @else border-gray-300 dark:border-gray-600 @enderror text-gray-900 dark:text-white dark:bg-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:placeholder-gray-400" placeholder="Jl. Industri No. 123, Jakarta">{{ old('address') }}</textarea>
                @error('address')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-center space-x-3">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition shadow-sm">
                Tambah Supplier
            </button>
            <button type="reset" class="px-5 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition shadow-sm border border-gray-200 dark:border-gray-600">
                Reset
            </button>
        </div>
    </form>
</div>
@endsection