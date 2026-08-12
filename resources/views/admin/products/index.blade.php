@extends('layouts.admin')

@section('content')
<div class="p-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm">
    <!-- Header Page & Tombol Aksi -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Data Produk</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Daftar persediaan barang, atribut, dan harga jual</p>
        </div>

        <div class="flex items-center flex-wrap gap-2">
            <!-- Tombol Kelola Kategori -->
            <button type="button" onclick="document.getElementById('categoryModal').classList.remove('hidden')" class="text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 font-medium rounded-lg text-sm px-4 py-2 flex items-center gap-2 shadow-sm transition">
                <svg class="w-4 h-4 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                Kelola Kategori
            </button>

            <!-- Tombol Export CSV -->
            <a href="{{ route('admin.products.export') }}" class="text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 font-medium rounded-lg text-sm px-4 py-2 flex items-center gap-2 shadow-sm transition">
                <svg class="w-4 h-4 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Export CSV
            </a>

            <!-- Tombol Trigger Modal Import -->
            <button type="button" onclick="document.getElementById('importModal').classList.remove('hidden')" class="text-emerald-700 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-900/50 border border-emerald-200 dark:border-emerald-800 hover:bg-emerald-100 dark:hover:bg-emerald-900 font-medium rounded-lg text-sm px-4 py-2 flex items-center gap-2 transition">
                <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                Import CSV
            </button>

            <!-- Tombol Tambah Produk -->
            <a href="{{ route('admin.products.create') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-4 py-2 flex items-center gap-1 transition">
                + Tambah Produk
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-green-900/50 dark:text-green-300 border border-green-200 dark:border-green-800" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabel Data Produk -->
    <div class="relative overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                <tr>
                    <th scope="col" class="px-4 py-3">Foto</th>
                    <th scope="col" class="px-4 py-3">Kode / Nama</th>
                    <th scope="col" class="px-4 py-3">Atribut</th>
                    <th scope="col" class="px-4 py-3">Kategori</th>
                    <th scope="col" class="px-4 py-3">Harga Beli / Jual</th>
                    <th scope="col" class="px-4 py-3 whitespace-nowrap">Stok</th>
                    <th scope="col" class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($products as $product)
                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                    <td class="px-4 py-3">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="w-10 h-10 rounded-lg object-cover border border-gray-200 dark:border-gray-600" alt="{{ $product->name }}">
                        @else
                            <div class="w-10 h-10 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-[10px] text-gray-400 dark:text-gray-400 border border-gray-200 dark:border-gray-600">No Image</div>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <div class="font-bold text-gray-900 dark:text-white">{{ $product->name }}</div>
                        <div class="text-xs text-gray-400 dark:text-gray-400">{{ $product->code }}</div>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex flex-col gap-1">
                            <span class="text-xs text-gray-600 dark:text-gray-300">Ukuran: <strong class="text-gray-900 dark:text-white">{{ $product->size ?? '-' }}</strong></span>
                            <span class="text-xs text-gray-600 dark:text-gray-300">Warna: <strong class="text-gray-900 dark:text-white">{{ $product->color ?? '-' }}</strong></span>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-gray-500 dark:text-gray-300">{{ $product->category->name ?? '-' }}</td>
                    <td class="px-4 py-3">
                        <div class="text-gray-900 dark:text-white font-medium">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</div>
                        <div class="text-xs text-gray-400 dark:text-gray-400">Beli: Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</div>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold inline-block {{ $product->stock <= $product->min_stock ? 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300' : 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300' }}">
                            {{ $product->stock }} Pcs
                        </span>
                    </td>
                    <!-- Kolom Aksi dengan Tombol Bergaya Modern -->
                    <td class="px-4 py-3 text-center whitespace-nowrap">
                        <div class="inline-flex items-center justify-center gap-2">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-700 bg-blue-50 border border-blue-200 hover:bg-blue-100 dark:bg-blue-900/40 dark:text-blue-300 dark:border-blue-800 dark:hover:bg-blue-900 font-medium rounded-lg text-xs px-3 py-1.5 transition">
                                Edit
                            </a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline-flex items-center m-0 p-0" onsubmit="return confirm('Hapus produk ini?')">
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
                    <td colspan="7" class="px-6 py-4 text-center text-gray-400 bg-white dark:bg-gray-800">Belum ada data produk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL KELOLA KATEGORI -->
<div id="categoryModal" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-xl w-full max-w-lg p-6 relative max-h-[90vh] flex flex-col">
        <button type="button" onclick="document.getElementById('categoryModal').classList.add('hidden')" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
            ✕
        </button>
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Kelola Kategori Produk</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Tambah atau hapus kategori barang yang tersedia.</p>
        
        <!-- Form Tambah Kategori -->
        <form action="{{ route('admin.categories.store') }}" method="POST" class="mb-4 pb-4 border-b border-gray-200 dark:border-gray-700 flex gap-2">
            @csrf
            <input type="text" name="name" placeholder="Nama Kategori Baru..." required class="flex-1 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-sm rounded-lg p-2.5">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-4 py-2.5 transition">Tambah</button>
        </form>

        <!-- Daftar Kategori Existing -->
        <div class="overflow-y-auto flex-1 pr-1">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                    <tr>
                        <th class="px-3 py-2">Nama Kategori</th>
                        <th class="px-3 py-2 text-center" style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($categories ?? [] as $cat)
                    <tr class="bg-white dark:bg-gray-800">
                        <td class="px-3 py-2 font-medium text-gray-900 dark:text-white">{{ $cat->name }}</td>
                        <td class="px-3 py-2 text-center">
                            <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 dark:text-red-400 hover:underline text-xs font-semibold">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="px-3 py-4 text-center text-gray-400">Belum ada kategori.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex justify-end pt-4 mt-2 border-t border-gray-200 dark:border-gray-700">
            <button type="button" onclick="document.getElementById('categoryModal').classList.add('hidden')" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition">Tutup</button>
        </div>
    </div>
</div>

<!-- MODAL IMPORT CSV -->
<div id="importModal" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-xl w-full max-w-md p-6 relative">
        <button type="button" onclick="document.getElementById('importModal').classList.add('hidden')" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
            ✕
        </button>
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Import Data Produk</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Pilih file berkas CSV sesuai format kolom untuk memperbarui atau menambahkan produk secara masal.</p>
        
        <form action="{{ route('admin.products.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Upload File CSV</label>
                <input type="file" name="file" accept=".csv" required class="block w-full text-sm text-gray-900 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 p-2">
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('importModal').classList.add('hidden')" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition">Batal</button>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 transition">Unggah & Import</button>
            </div>
        </form>
    </div>
</div>
@endsection