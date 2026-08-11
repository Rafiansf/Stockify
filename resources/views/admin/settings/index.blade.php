@extends('layouts.admin')

@section('content')
<div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
    <h2 class="text-xl font-bold text-gray-900 mb-4">Pengaturan</h2>

    @if(session('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Nama Aplikasi -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900">Nama Aplikasi / Perusahaan</label>
                <input type="text" name="app_name" value="{{ old('app_name', $setting->app_name ?? '') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
            </div>

            <!-- Email Kontak -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900">Email Resmi Gudang</label>
                <input type="email" name="email" value="{{ old('email', $setting->email ?? '') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>

            <!-- Nomor Telepon -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900">Nomor Telepon / WhatsApp</label>
                <input type="text" name="phone" value="{{ old('phone', $setting->phone ?? '') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>

            <!-- Footer Text -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900">Teks Hak Cipta (Footer)</label>
                <input type="text" name="footer_text" value="{{ old('footer_text', $setting->footer_text ?? '') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>

            <!-- Alamat Gudang -->
            <div class="md:col-span-2">
                <label class="block mb-2 text-sm font-medium text-gray-900">Alamat Lengkap Gudang</label>
                <textarea name="address" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">{{ old('address', $setting->address ?? '') }}</textarea>
            </div>

            <!-- Logo Aplikasi -->
            <div class="md:col-span-2">
                <label class="block mb-2 text-sm font-medium text-gray-900">Logo Aplikasi</label>
                <div class="flex items-center space-x-6">
                    <div class="shrink-0">
                        @if(!empty($setting->app_logo))
                            <img class="h-16 w-16 object-contain rounded-lg border p-1" src="{{ asset('storage/' . $setting->app_logo) }}" alt="Logo Aplikasi">
                        @else
                            <div class="h-16 w-16 rounded-lg border bg-gray-100 flex items-center justify-center text-gray-400 text-xs">No Logo</div>
                        @endif
                    </div>
                    <input type="file" name="app_logo" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                </div>
                <p class="mt-1 text-xs text-gray-500">Format: PNG, JPG, SVG, WebP. Maksimal 2MB.</p>
            </div>
        </div>

        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan Perubahan</button>
    </form>
</div>
@endsection