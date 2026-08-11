@extends('layouts.admin')

@section('content')
<div class="space-y-4">
    <!-- Header & Tombol Cetak -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-4 rounded-lg border border-gray-200 shadow-sm dark:bg-gray-800 dark:border-gray-700">
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Laporan Transaksi Stok</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Rekapitulasi riwayat barang masuk, keluar, dan penyesuaian stok gudang.</p>
        </div>
        <button onclick="window.print()" class="px-4 py-2 bg-gray-800 text-white text-sm font-medium rounded-lg hover:bg-gray-700 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak / PDF
        </button>
    </div>

    <!-- Ringkasan Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="p-4 bg-green-50 border border-green-200 rounded-lg dark:bg-gray-800 dark:border-green-800">
            <span class="text-sm text-green-600 font-semibold dark:text-green-400">Total Barang Masuk</span>
            <p class="text-2xl font-bold text-green-800 dark:text-green-300">+{{ number_format($totalIn) }} Pcs</p>
        </div>
        <div class="p-4 bg-red-50 border border-red-200 rounded-lg dark:bg-gray-800 dark:border-red-800">
            <span class="text-sm text-red-600 font-semibold dark:text-red-400">Total Barang Keluar</span>
            <p class="text-2xl font-bold text-red-800 dark:text-red-300">-{{ number_format($totalOut) }} Pcs</p>
        </div>
        <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg dark:bg-gray-800 dark:border-blue-800">
            <span class="text-sm text-blue-600 font-semibold dark:text-blue-400">Total Penyesuaian (Adjustment)</span>
            <p class="text-2xl font-bold text-blue-800 dark:text-blue-300">{{ number_format($totalAdjustment) }} Pcs</p>
        </div>
    </div>

    <!-- Form Filter -->
    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
        <form method="GET" action="{{ route('admin.reports.transactions') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full text-xs rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full text-xs rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Tipe Transaksi</label>
                <select name="type" class="w-full text-xs rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="">Semua Tipe</option>
                    <option value="in" {{ request('type') == 'in' ? 'selected' : '' }}>Masuk (In)</option>
                    <option value="out" {{ request('type') == 'out' ? 'selected' : '' }}>Keluar (Out)</option>
                    <option value="adjustment" {{ request('type') == 'adjustment' ? 'selected' : '' }}>Penyesuaian (Adjustment)</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Kategori Produk</label>
                <select name="category_id" class="w-full text-xs rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="w-full py-2 bg-blue-600 text-white text-xs font-medium rounded-lg hover:bg-blue-700">Filter</button>
                <a href="{{ route('admin.reports.transactions') }}" class="w-full py-2 text-center bg-gray-200 text-gray-700 text-xs font-medium rounded-lg hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300">Reset</a>
            </div>
        </form>
    </div>

    <!-- Tabel Data Transaksi -->
    <div class="relative overflow-x-auto bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="px-4 py-3">Waktu</th>
                    <th class="px-4 py-3">Kode & Produk</th>
                    <th class="px-4 py-3">Kategori</th>
                    <th class="px-4 py-3">Tipe</th>
                    <th class="px-4 py-3 text-right">Jumlah</th>
                    <th class="px-4 py-3">Operator</th>
                    <th class="px-4 py-3">Catatan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $trx)
                <tr class="bg-white border-b hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-4 py-3 text-xs">{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                        {{ $trx->product->code ?? '-' }} - {{ $trx->product->name ?? 'Produk Dihapus' }}
                    </td>
                    <td class="px-4 py-3 text-xs">{{ $trx->product->category->name ?? '-' }}</td>
                    <td class="px-4 py-3">
                        @if($trx->type == 'in')
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">MASUK</span>
                        @elseif($trx->type == 'out')
                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">KELUAR</span>
                        @else
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">ADJUSTMENT</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-right font-bold {{ $trx->type == 'in' ? 'text-green-600' : ($trx->type == 'out' ? 'text-red-600' : 'text-blue-600') }}">
                        {{ $trx->type == 'in' ? '+' : ($trx->type == 'out' ? '-' : '') }}{{ $trx->quantity }}
                    </td>
                    <td class="px-4 py-3 text-xs">{{ $trx->user->name ?? 'Sistem' }}</td>
                    <td class="px-4 py-3 text-xs text-gray-500">{{ $trx->notes ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-6 text-center text-gray-500">Tidak ada data transaksi yang ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">
            {{ $transactions->links() }}
        </div>
    </div>
</div>
@endsection