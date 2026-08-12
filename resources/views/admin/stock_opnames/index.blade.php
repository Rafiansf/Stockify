@extends('layouts.admin')

@section('content')
<div class="mb-4">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Pemeriksaan Stock Opname</h1>
    <p class="text-sm text-gray-500 dark:text-gray-400">Lakukan penyesuaian jumlah stok fisik barang dengan stok sistem.</p>
</div>

@if(session('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200 dark:bg-green-900/50 dark:border-green-800 dark:text-green-300">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200 dark:bg-red-900/50 dark:border-red-800 dark:text-red-300">
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200 dark:bg-red-900/50 dark:border-red-800 dark:text-red-300">
        <span class="font-medium">Terjadi kesalahan input:</span>
        <ul class="mt-1.5 list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- FORM INPUT STOCK OPNAME -->
<div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm p-5 mb-6">
    <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Input Hasil Fisik Opname</h2>
    
    <form action="{{ route('admin.stock-opnames.store') }}" method="POST">
        @csrf
        
        <input type="hidden" name="date" value="{{ date('Y-m-d') }}">
        <input type="hidden" name="status" value="completed">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pilih Produk</label>
                <select name="items[0][product_id]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400" required>
                    <option value="">-- Pilih Produk --</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }} (Stok Sistem: {{ $product->stock }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jumlah Stok Fisik (Riil)</label>
                <input type="number" name="items[0][physical_stock]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400" min="0" placeholder="0" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Catatan Alasan / Penyesuaian</label>
                <input type="text" name="items[0][reason]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400" placeholder="Kerusakan, barang hilang, dll.">
            </div>
        </div>

        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition">Submit</button>
    </form>
</div>

<!-- RIWAYAT STOCK OPNAME -->
<div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm p-5">
    <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Riwayat Stock Opname</h2>
    
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                <tr>
                    <th class="px-4 py-3">Tanggal</th>
                    <th class="px-4 py-3">No. Opname</th>
                    <th class="px-4 py-3">Petugas</th>
                    <th class="px-4 py-3 text-center">Status</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($opnames as $opname)
                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                    <td class="px-4 py-3 text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($opname->date)->format('d/m/Y') }}</td>
                    <td class="px-4 py-3 font-semibold text-gray-900 dark:text-white">{{ $opname->opname_number }}</td>
                    <td class="px-4 py-3 text-gray-500 dark:text-gray-300">{{ $opname->user->name ?? '-' }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2.5 py-0.5 rounded text-xs font-semibold {{ $opname->status === 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300' }}">
                            {{ strtoupper($opname->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <div class="inline-flex items-center justify-center">
                            <a href="{{ route('admin.stock-opnames.show', $opname->id) }}" class="text-blue-700 bg-blue-50 border border-blue-200 hover:bg-blue-100 dark:bg-blue-900/40 dark:text-blue-300 dark:border-blue-800 dark:hover:bg-blue-900 font-medium rounded-lg text-xs px-3 py-1.5 transition">
                                Detail
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800">Belum ada riwayat stock opname.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $opnames->links() }}
    </div>
</div>
@endsection