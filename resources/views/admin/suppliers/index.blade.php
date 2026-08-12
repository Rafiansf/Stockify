@extends('layouts.admin')

@section('content')
<div class="p-4 bg-white dark:bg-gray-800 block sm:flex items-center justify-between border border-gray-200 dark:border-gray-700 lg:mt-1.5 rounded-lg shadow-sm mb-4">
    <div class="w-full mb-1">
        <div class="mb-4">
            <h1 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Manajemen Supplier</h1>
        </div>
        <div class="sm:flex justify-between items-center">
            <div class="flex items-center mb-4 sm:mb-0">
                <span class="text-sm text-gray-500 dark:text-gray-400">Kelola daftar pemasok barang untuk persediaan gudang</span>
            </div>
            <a href="{{ route('admin.suppliers.create') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 transition">
                + Tambah Supplier
            </a>
        </div>
    </div>
</div>

@if(session('success'))
<div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-green-900/50 dark:text-green-300" role="alert">
    {{ session('success') }}
</div>
@endif

<div class="relative overflow-x-auto shadow-md sm:rounded-lg border border-gray-200 dark:border-gray-700">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
            <tr>
                <th scope="col" class="px-6 py-3">Nama Supplier</th>
                <th scope="col" class="px-6 py-3">No. Telepon</th>
                <th scope="col" class="px-6 py-3">Email</th>
                <th scope="col" class="px-6 py-3">Alamat</th>
                <th scope="col" class="px-6 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($suppliers as $supplier)
            <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">{{ $supplier->name }}</td>
                <td class="px-6 py-4 text-gray-500 dark:text-gray-300">{{ $supplier->phone }}</td>
                <td class="px-6 py-4 text-gray-500 dark:text-gray-300">{{ $supplier->email ?? '-' }}</td>
                <td class="px-6 py-4 text-gray-500 dark:text-gray-300">{{ $supplier->address ?? '-' }}</td>
                <td class="px-6 py-4 text-center whitespace-nowrap">
                    <div class="inline-flex items-center justify-center gap-2">
                        <a href="{{ route('admin.suppliers.edit', $supplier->id) }}" class="text-blue-700 bg-blue-50 border border-blue-200 hover:bg-blue-100 dark:bg-blue-900/40 dark:text-blue-300 dark:border-blue-800 dark:hover:bg-blue-900 font-medium rounded-lg text-xs px-3 py-1.5 transition">
                            Edit
                        </a>
                        <form action="{{ route('admin.suppliers.destroy', $supplier->id) }}" method="POST" onsubmit="return confirm('Hapus supplier ini?');" class="inline-flex items-center m-0 p-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-700 bg-red-50 border border-red-200 hover:bg-red-100 dark:bg-red-900/40 dark:text-red-300 dark:border-red-800 dark:hover:bg-red-900 font-medium rounded-lg text-xs px-3 py-1.5 transition">
                                Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800">Belum ada data supplier.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $suppliers->links() }}
</div>
@endsection