@extends('layouts.admin')

@section('content')
<div class="p-4 bg-white block border-b border-gray-200 rounded-lg shadow-sm mb-4">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl">Tambah Supplier Baru</h1>
            <p class="text-sm text-gray-500">Isi informasi pemasok baru secara lengkap.</p>
        </div>
        <a href="{{ route('admin.suppliers.index') }}" class="text-gray-700 bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-2 focus:outline-none">
            &larr; Kembali
        </a>
    </div>
</div>

<div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
    <form action="{{ route('admin.suppliers.store') }}" method="POST">
        @csrf
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <!-- Nama Supplier -->
            <div>
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nama Supplier / Perusahaan</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="bg-gray-50 border @error('name') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="PT. Logistik Jaya" required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- No. Telepon -->
            <div>
                <label for="phone" class="block mb-2 text-sm font-medium text-gray-900">Nomor Telepon</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone') }}" class="bg-gray-50 border @error('phone') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="081234567890" required>
                @error('phone')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email (Opsional) -->
            <div class="md:col-span-2">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Alamat Email (Opsional)</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" class="bg-gray-50 border @error('email') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="supplier@perusahaan.com">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Alamat -->
            <div class="md:col-span-2">
                <label for="address" class="block mb-2 text-sm font-medium text-gray-900">Alamat Lengkap</label>
                <textarea id="address" name="address" rows="3" class="bg-gray-50 border @error('address') border-red-500 @else border-gray-300 @enderror text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Jl. Industri No. 123, Jakarta">{{ old('address') }}</textarea>
                @error('address')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-center space-x-3">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                Simpan Supplier
            </button>
            <a href="{{ route('admin.suppliers.index') }}" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection