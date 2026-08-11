@extends('layouts.admin')

@section('title', 'Daftar Supplier')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Daftar Supplier</h1>
    </div>

    <!-- Kotak Pencarian -->
    <div class="p-4 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
        <form action="{{ route('manager.suppliers.index') }}" method="GET" class="flex items-center gap-3">
            <div class="relative flex-1 max-w-md">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" class="block w-full p-2.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Cari nama, telepon, atau email supplier...">
            </div>
            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">Cari</button>
            @if(request('search'))
                <a href="{{ route('manager.suppliers.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300">Reset</a>
            @endif
        </form>
    </div>

    <!-- Tabel Supplier -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-gray-800 dark:border-gray-700">
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-4 py-3">Nama Supplier</th>
                        <th scope="col" class="px-4 py-3">Telepon</th>
                        <th scope="col" class="px-4 py-3">Email</th>
                        <th scope="col" class="px-4 py-3">Alamat</th>
                        <th scope="col" class="px-4 py-3 text-center">Jumlah Produk</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suppliers as $supplier)
                        <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-4 py-3 font-semibold text-gray-900 dark:text-white">
                                {{ $supplier->name }}
                            </td>
                            <td class="px-4 py-3 font-mono text-xs">
                                {{ $supplier->phone ?? '-' }}
                            </td>
                            <td class="px-4 py-3">
                                {{ $supplier->email ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-xs text-gray-500">
                                {{ $supplier->address ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="px-2.5 py-1 text-xs font-semibold text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900/50 dark:text-blue-300">
                                    {{ $supplier->products_count ?? 0 }} Produk
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                                Tidak ada data supplier ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-200 dark:border-gray-700">
            {{ $suppliers->links() }}
        </div>
    </div>
</div>
@endsection