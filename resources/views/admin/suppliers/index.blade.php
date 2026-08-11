@extends('layouts.admin')

@section('content')
<div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 rounded-lg shadow-sm mb-4">
    <div class="w-full mb-1">
        <div class="mb-4">
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl">Manajemen Supplier</h1>
        </div>
        <div class="sm:flex justify-between items-center">
            <div class="flex items-center mb-4 sm:mb-0">
                <span class="text-sm text-gray-500">Kelola daftar pemasok barang untuk persediaan gudang</span>
            </div>
            <a href="{{ route('admin.suppliers.create') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">
                + Tambah Supplier
            </a>
        </div>
    </div>
</div>

@if(session('success'))
<div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
    {{ session('success') }}
</div>
@endif

<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3">Nama Supplier</th>
                <th scope="col" class="px-6 py-3">No. Telepon</th>
                <th scope="col" class="px-6 py-3">Email</th>
                <th scope="col" class="px-6 py-3">Alamat</th>
                <th scope="col" class="px-6 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($suppliers as $supplier)
            <tr class="bg-white border-b hover:bg-gray-50">
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ $supplier->name }}</td>
                <td class="px-6 py-4">{{ $supplier->phone }}</td>
                <td class="px-6 py-4">{{ $supplier->email ?? '-' }}</td>
                <td class="px-6 py-4">{{ $supplier->address ?? '-' }}</td>
                <td class="px-6 py-4 flex space-x-2">
                    <a href="{{ route('admin.suppliers.edit', $supplier->id) }}" class="font-medium text-blue-600 hover:underline">Edit</a>
                    <form action="{{ route('admin.suppliers.destroy', $supplier->id) }}" method="POST" onsubmit="return confirm('Hapus supplier ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="font-medium text-red-600 hover:underline">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada data supplier.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $suppliers->links() }}
</div>
@endsection