@extends('layouts.admin')

@section('content')
<div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
    <!-- Header Page & Tombol Aksi -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900">Data Produk</h2>
            <p class="text-sm text-gray-500">Daftar persediaan barang, atribut, dan harga jual</p>
        </div>

        <div class="flex items-center space-x-2">
            <!-- Tombol Export CSV -->
            <a href="{{ route('admin.products.export') }}" class="text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 font-medium rounded-lg text-sm px-4 py-2 flex items-center gap-2 shadow-sm">
                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Export CSV
            </a>

            <!-- Tombol Trigger Modal Import -->
            <button type="button" onclick="document.getElementById('importModal').classList.remove('hidden')" class="text-emerald-700 bg-emerald-50 border border-emerald-200 hover:bg-emerald-100 font-medium rounded-lg text-sm px-4 py-2 flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                Import CSV
            </button>

            <!-- Tombol Tambah Produk -->
            <a href="{{ route('admin.products.create') }}" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-4 py-2 flex items-center gap-1">
                + Tambah Produk
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabel Data Produk -->
    <div class="relative overflow-x-auto rounded-lg border border-gray-200">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-4 py-3">Foto</th>
                    <th scope="col" class="px-4 py-3">Kode / Nama</th>
                    <th scope="col" class="px-4 py-3">Atribut</th>
                    <th scope="col" class="px-4 py-3">Kategori</th>
                    <th scope="col" class="px-4 py-3">Harga Beli / Jual</th>
                    <th scope="col" class="px-4 py-3">Stok</th>
                    <th scope="col" class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="px-4 py-3">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="w-10 h-10 rounded-lg object-cover" alt="{{ $product->name }}">
                        @else
                            <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center text-[10px] text-gray-400">No Image</div>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <div class="font-bold text-gray-900">{{ $product->name }}</div>
                        <div class="text-xs text-gray-400">{{ $product->code }}</div>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex flex-col gap-1">
                            <span class="text-xs text-gray-600">Ukuran: <strong class="text-gray-900">{{ $product->size ?? '-' }}</strong></span>
                            <span class="text-xs text-gray-600">Warna: <strong class="text-gray-900">{{ $product->color ?? '-' }}</strong></span>
                        </div>
                    </td>
                    <td class="px-4 py-3">{{ $product->category->name ?? '-' }}</td>
                    <td class="px-4 py-3">
                        <div class="text-gray-900 font-medium">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</div>
                        <div class="text-xs text-gray-400">Beli: Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</div>
                    </td>
                    <td class="px-4 py-3">
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $product->stock <= $product->min_stock ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                            {{ $product->stock }} Pcs
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center space-x-2">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-600 hover:underline text-xs font-semibold">Edit</a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus produk ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline text-xs font-semibold">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-400">Belum ada data produk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL IMPORT CSV -->
<div id="importModal" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 relative">
        <button type="button" onclick="document.getElementById('importModal').classList.add('hidden')" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
            ✕
        </button>
        <h3 class="text-lg font-bold text-gray-900 mb-2">Import Data Produk</h3>
        <p class="text-sm text-gray-500 mb-4">Pilih file berkas CSV sesuai format kolom untuk memperbarui atau menambahkan produk secara masal.</p>
        
        <form action="{{ route('admin.products.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block mb-2 text-sm font-medium text-gray-900">Upload File CSV</label>
                <input type="file" name="file" accept=".csv" required class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 p-2">
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('importModal').classList.add('hidden')" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">Batal</button>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700">Unggah & Import</button>
            </div>
        </form>
    </div>
</div>
@endsection