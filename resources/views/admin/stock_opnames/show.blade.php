@extends('layouts.admin')

@section('content')
<div class="mb-4 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Detail Stock Opname</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">Informasi detail hasil pemeriksaan dan penyesuaian stok.</p>
    </div>
    <a href="{{ route('admin.stock-opnames.index') }}" class="text-white bg-gray-600 hover:bg-gray-700 font-medium rounded-lg text-sm px-4 py-2">
        Kembali
    </a>
</div>

<!-- RINGKASAN STOCK OPNAME -->
<div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm p-6 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase dark:text-gray-400">Nomor Referensi</label>
            <div class="text-lg font-bold text-gray-900 dark:text-white">{{ $opname->opname_number }}</div>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase dark:text-gray-400">Tanggal Opname</label>
            <div class="text-base font-medium text-gray-900 dark:text-white">
                {{ \Carbon\Carbon::parse($opname->date)->format('d M Y') }}
            </div>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase dark:text-gray-400">Petugas / Admin</label>
            <div class="text-base font-medium text-gray-900 dark:text-white">{{ $opname->user->name ?? '-' }}</div>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase dark:text-gray-400">Status</label>
            <div class="mt-1">
                <span class="px-2.5 py-1 text-xs font-semibold rounded-full 
                    {{ $opname->status == 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                    {{ ucfirst($opname->status) }}
                </span>
            </div>
        </div>
    </div>
</div>

<!-- TABEL ITEM BARANG OPNAME -->
<div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-lg font-bold text-gray-900 dark:text-white">Daftar Barang Opname</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="px-6 py-3">No</th>
                    <th class="px-6 py-3">Nama Produk</th>
                    <th class="px-6 py-3 text-center">Stok Sistem</th>
                    <th class="px-6 py-3 text-center">Stok Fisik</th>
                    <th class="px-6 py-3 text-center">Selisih</th>
                    <th class="px-6 py-3">Alasan / Catatan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($opname->items as $index => $item)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                            {{ $item->product->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-center">{{ $item->system_stock }}</td>
                        <td class="px-6 py-4 text-center font-bold text-blue-600">{{ $item->physical_stock }}</td>
                        <td class="px-6 py-4 text-center font-bold {{ $item->difference < 0 ? 'text-red-600' : ($item->difference > 0 ? 'text-green-600' : 'text-gray-500') }}">
                            {{ $item->difference > 0 ? '+' . $item->difference : $item->difference }}
                        </td>
                        <td class="px-6 py-4">{{ $item->reason ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada item barang dalam opname ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection