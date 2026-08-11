@extends('layouts.admin')

@section('content')
<div class="mb-4">
    <h1 class="text-2xl font-bold text-gray-900">Pemeriksaan Stock Opname</h1>
    <p class="text-sm text-gray-500">Lakukan penyesuaian jumlah stok fisik barang dengan stok sistem.</p>
</div>

@if(session('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200">
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200">
        <span class="font-medium">Terjadi kesalahan input:</span>
        <ul class="mt-1.5 list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="bg-white border border-gray-200 rounded-lg shadow-sm p-5 mb-6">
    <h2 class="text-lg font-bold text-gray-900 mb-4">Input Hasil Fisik Opname</h2>
    
    <form action="{{ route('admin.stock-opnames.store') }}" method="POST">
        @csrf
        
        <input type="hidden" name="date" value="{{ date('Y-m-d') }}">
        <input type="hidden" name="status" value="completed">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Produk</label>
                <select name="items[0][product_id]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                    <option value="">-- Pilih Produk --</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }} (Stok Sistem: {{ $product->stock }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Stok Fisik (Riil)</label>
                <input type="number" name="items[0][physical_stock]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" min="0" placeholder="0" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Alasan / Penyesuaian</label>
                <input type="text" name="items[0][reason]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Kerusakan, barang hilang, dll.">
            </div>
        </div>

        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">Submit</button>
    </form>
</div>

<div class="bg-white border border-gray-200 rounded-lg shadow-sm p-5">
    <h2 class="text-lg font-bold text-gray-900 mb-4">Riwayat Stock Opname</h2>
    
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-4 py-3">Tanggal</th>
                    <th class="px-4 py-3">No. Opname</th>
                    <th class="px-4 py-3">Petugas</th>
                    <th class="px-4 py-3 text-center">Status</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($opnames as $opname)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3">{{ \Carbon\Carbon::parse($opname->date)->format('d/m/Y') }}</td>
                    <td class="px-4 py-3 font-semibold text-gray-900">{{ $opname->opname_number }}</td>
                    <td class="px-4 py-3">{{ $opname->user->name ?? '-' }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2.5 py-0.5 rounded text-xs font-semibold {{ $opname->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ strtoupper($opname->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <a href="{{ route('admin.stock-opnames.show', $opname->id) }}" class="font-medium text-blue-600 hover:underline">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-4 text-center text-gray-500">Belum ada riwayat stock opname.</td>
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