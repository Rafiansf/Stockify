@extends('layouts.admin')

@section('content')
<div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Pengaturan</h2>

    @if(session('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-green-900/50 dark:text-green-300" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Nama Aplikasi -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Aplikasi / Perusahaan</label>
                <input type="text" name="app_name" value="{{ old('app_name', $setting->app_name ?? '') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
            </div>

            <!-- Email Kontak -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email Resmi Gudang</label>
                <input type="email" name="email" value="{{ old('email', $setting->email ?? '') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>

            <!-- Nomor Telepon -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomor Telepon / WhatsApp</label>
                <input type="text" name="phone" value="{{ old('phone', $setting->phone ?? '') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>

            <!-- Footer Text -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Teks Hak Cipta (Footer)</label>
                <input type="text" name="footer_text" value="{{ old('footer_text', $setting->footer_text ?? '') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>

            <!-- Alamat Gudang -->
            <div class="md:col-span-2">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat Lengkap Gudang</label>
                <textarea name="address" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ old('address', $setting->address ?? '') }}</textarea>
            </div>

            <!-- Logo Aplikasi -->
            <div class="md:col-span-2">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Logo Aplikasi</label>
                <div class="flex items-center space-x-6">
                    <div class="shrink-0">
                        @if(!empty($setting->app_logo))
                            <img class="h-16 w-16 object-contain rounded-lg border p-1 dark:border-gray-600 bg-gray-50 dark:bg-gray-700" src="{{ asset('storage/' . $setting->app_logo) }}" alt="Logo Aplikasi">
                        @else
                            <div class="h-16 w-16 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-400 dark:text-gray-400 text-xs">No Logo</div>
                        @endif
                    </div>
                    <input type="file" name="app_logo" class="block w-full text-sm text-gray-900 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-l-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 dark:file:bg-gray-600 dark:file:text-blue-300 hover:file:bg-blue-100">
                </div>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Format: PNG, JPG, SVG, WebP. Maksimal 2MB.</p>
            </div>
        </div>

        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition">Simpan Perubahan</button>
    </form>
</div>
@endsection