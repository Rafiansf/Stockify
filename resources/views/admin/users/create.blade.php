@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-gray-900">Tambah Pengguna Baru</h2>
        <a href="{{ route('admin.users.index') }}" class="text-sm font-medium text-gray-600 hover:underline">← Kembali</a>
    </div>

    @if ($errors->any())
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="space-y-4">
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" placeholder="Contoh: Ahmad Subagja">
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" placeholder="ahmad@stockify.test">
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900">Role / Hak Akses</label>
                <select name="role" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
    <option value="">-- Pilih Role --</option>
    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
    <option value="manager_gudang" {{ old('role') == 'manager_gudang' ? 'selected' : '' }}>Manager Gudang</option>
    <option value="staff_gudang" {{ old('role') == 'staff_gudang' ? 'selected' : '' }}>Staff Gudang</option>
</select>
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                <input type="password" name="password" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" placeholder="Minimal 8 karakter">
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-2">
            <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">Batal</a>
            <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800">Simpan Pengguna</button>
        </div>
    </form>
</div>
@endsection