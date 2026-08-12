@extends('layouts.admin')

@section('content')
<div class="p-4 bg-white dark:bg-gray-800 block sm:flex items-center justify-between border border-gray-200 dark:border-gray-700 lg:mt-1.5 rounded-lg shadow-sm mb-4">
    <div class="w-full mb-1">
        <div class="mb-4">
            <h1 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Riwayat Transaksi Stok</h1>
        </div>
        <div class="sm:flex justify-between items-center">
            <span class="text-sm text-gray-500 dark:text-gray-400">Catatan mutasi stok masuk dan stok keluar</span>
            <div class="flex space-x-2 mt-2 sm:mt-0">
                <a href="{{ route('admin.stock-transactions.create', ['type' => 'in']) }}" class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 transition">
                    + Stok Masuk
                </a>
                <a href="{{ route('admin.stock-transactions.create', ['type' => 'out']) }}" class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800 transition">
                    - Stok Keluar
                </a>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
<div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-green-900/50 dark:text-green-300 border border-green-200 dark:border-green-800" role="alert">
    {{ session('success') }}
</div>
@endif

<!-- Form Filter & Pencarian -->
<div class="p-4 mb-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
    <form method="GET" action="{{ route('admin.stock-transactions.index') }}" class="grid gap-4 md:grid-cols-5 items-end">
        
        <!-- Search Keyword -->
        <div>
            <label for="search" class="block mb-2 text-xs font-medium text-gray-700 dark:text-gray-300">Cari Produk / Catatan</label>
            <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Kode/nama produk..." class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400">
        </div>

        <!-- Filter Tipe Transaksi -->
        <div>
            <label for="type" class="block mb-2 text-xs font-medium text-gray-700 dark:text-gray-300">Tipe Transaksi</label>
            <select id="type" name="type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <option value="">Semua Tipe</option>
                <option value="in" {{ request('type') == 'in' ? 'selected' : '' }}>Stok Masuk</option>
                <option value="out" {{ request('type') == 'out' ? 'selected' : '' }}>Stok Keluar</option>
            </select>
        </div>

        <!-- Filter Tanggal Mulai -->
        <div>
            <label for="start_date" class="block mb-2 text-xs font-medium text-gray-700 dark:text-gray-300">Tanggal Mulai</label>
            <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        </div>

        <!-- Filter Tanggal Selesai -->
        <div>
            <label for="end_date" class="block mb-2 text-xs font-medium text-gray-700 dark:text-gray-300">Tanggal Selesai</label>
            <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        </div>

        <!-- Tombol Aksi -->
        <div class="flex space-x-2">
            <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition">
                Filter
            </button>
            @if(request()->hasAny(['search', 'type', 'start_date', 'end_date']))
                <a href="{{ route('admin.stock-transactions.index') }}" class="w-full text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 font-medium rounded-lg text-sm px-4 py-2.5 text-center transition">
                    Reset
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Tabel Riwayat Transaksi -->
<div class="relative overflow-x-auto shadow-md sm:rounded-lg border border-gray-200 dark:border-gray-700">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
            <tr>
                <th scope="col" class="px-6 py-3">Tanggal</th>
                <th scope="col" class="px-6 py-3">Produk</th>
                <th scope="col" class="px-6 py-3">Tipe</th>
                <th scope="col" class="px-6 py-3">Jumlah</th>
                <th scope="col" class="px-6 py-3">Supplier</th>
                <th scope="col" class="px-6 py-3">Catatan</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($transactions as $trx)
            <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($trx->date)->format('d M Y') }}</td>
                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                    {{ $trx->product->name ?? '-' }}
                    <span class="block text-xs text-gray-400 dark:text-gray-500">{{ $trx->product->code ?? '' }}</span>
                </td>
                <td class="px-6 py-4">
                    <span class="px-2.5 py-1 rounded text-xs font-semibold {{ $trx->type === 'in' ? 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300' }}">
                        {{ $trx->type === 'in' ? 'MASUK' : 'KELUAR' }}
                    </span>
                </td>
                <td class="px-6 py-4 font-bold {{ $trx->type === 'in' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                    {{ $trx->type === 'in' ? '+' : '-' }}{{ $trx->quantity }}
                </td>
                <td class="px-6 py-4 text-gray-500 dark:text-gray-300">{{ $trx->supplier->name ?? '-' }}</td>
                <td class="px-6 py-4 text-gray-500 dark:text-gray-300">{{ $trx->notes ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800">Tidak ada data transaksi stok yang sesuai filter.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $transactions->links() }}
</div>
@endsection