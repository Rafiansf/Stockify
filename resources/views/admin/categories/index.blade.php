@extends('layouts.admin')

@section('content')
<div class="p-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm mb-4 sm:flex items-center justify-between">
    <div class="w-full mb-1">
        <div class="mb-2">
            <h1 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Kategori Produk</h1>
        </div>
        <div class="sm:flex justify-between items-center">
            <span class="text-sm text-gray-500 dark:text-gray-400">Kelola kelompok dan pengelompokan jenis barang</span>
            <a href="{{ route('admin.categories.create') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none transition mt-2 sm:mt-0">
                + Tambah Kategori
            </a>
        </div>
    </div>
</div>

@if(session('success'))
<div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-green-900/50 dark:text-green-300 border border-green-200 dark:border-green-800" role="alert">
    {{ session('success') }}
</div>
@endif

<div class="relative overflow-x-auto shadow-md sm:rounded-lg border border-gray-200 dark:border-gray-700">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
            <tr>
                <th scope="col" class="px-6 py-3">Nama Kategori</th>
                <th scope="col" class="px-6 py-3">Slug</th>
                <th scope="col" class="px-6 py-3">Deskripsi</th>
                <th scope="col" class="px-6 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($categories as $category)
            <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">{{ $category->name }}</td>
                <td class="px-6 py-4"><code class="text-xs bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded text-gray-600 dark:text-gray-300">{{ $category->slug }}</code></td>
                <td class="px-6 py-4 text-gray-500 dark:text-gray-300">{{ $category->description ?? '-' }}</td>
                <td class="px-6 py-4 text-center whitespace-nowrap">
                    <div class="inline-flex items-center justify-center gap-2">
                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="text-blue-700 bg-blue-50 border border-blue-200 hover:bg-blue-100 dark:bg-blue-900/40 dark:text-blue-300 dark:border-blue-800 dark:hover:bg-blue-900 font-medium rounded-lg text-xs px-3 py-1.5 transition">
                            Edit
                        </a>
                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini? Semua produk terkait mungkin akan terpengaruh.');" class="inline-flex items-center m-0 p-0">
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
                <td colspan="4" class="px-6 py-4 text-center text-gray-400 dark:text-gray-500 bg-white dark:bg-gray-800">Belum ada data kategori.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $categories->links() }}
</div>
@endsection