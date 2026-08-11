@extends('layouts.admin')

@section('title', 'Stock Opname')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Pemeriksaan Stock Opname</h1>
    <p class="text-sm text-gray-500 dark:text-gray-400">Lakukan pengecekan stok fisik barang dan catat penyesuaiannya.</p>
</div>

<!-- Notifikasi Sukses / Error -->
@if(session('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
        {{ session('error') }}
    </div>
@endif

<!-- FORM INPUT STOCK OPNAME -->
<div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm p-6 mb-6">
    <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Input Hasil Fisik Opname</h2>
    
    <form action="{{ route('manager.stock-opname.store') }}" method="POST">
        @csrf
        <input type="hidden" name="date" value="{{ date('Y-m-d') }}">
        <input type="hidden" name="status" value="completed">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Pilih Produk</label>
                <select name="items[0][product_id]" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                    <option value="">-- Pilih Produk --</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }} (Stok Sistem: {{ $product->stock }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jumlah Stok Fisik (Riil)</label>
                <input type="number" name="items[0][physical_stock]" min="0" required placeholder="0" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Catatan Alasan / Penyesuaian</label>
                <div class="flex gap-2">
                    <input type="text" name="items[0][reason]" placeholder="Kerusakan, barang hilang, dll." class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                    <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Submit</button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- RIWAYAT STOCK OPNAME -->
<div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-lg font-bold text-gray-900 dark:text-white">Riwayat Stock Opname</h2>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3">Produk</th>
                    <th class="px-6 py-3 text-center">Stok Sistem</th>
                    <th class="px-6 py-3 text-center">Stok Fisik</th>
                    <th class="px-6 py-3 text-center">Selisih</th>
                    <th class="px-6 py-3">Petugas</th>
                    <th class="px-6 py-3">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($opnames as $opname)
                    @foreach($opname->items as $item)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50">
                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($opname->date)->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                {{ $item->product->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-center">{{ $item->system_stock }}</td>
                            <td class="px-6 py-4 text-center font-bold text-blue-600">{{ $item->physical_stock }}</td>
                            <td class="px-6 py-4 text-center font-bold {{ $item->difference < 0 ? 'text-red-600' : ($item->difference > 0 ? 'text-green-600' : 'text-gray-500') }}">
                                {{ $item->difference > 0 ? '+' . $item->difference : $item->difference }}
                            </td>
                            <td class="px-6 py-4">{{ $opname->user->name ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $item->reason ?? '-' }}</td>
                        </tr>
                    @endforeach
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">Belum ada riwayat stock opname.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginasi -->
    <div class="p-4 border-t border-gray-200 dark:border-gray-700">
        {{ $opnames->links() }}
    </div>
</div>
@endsection