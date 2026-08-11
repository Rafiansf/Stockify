@extends('layouts.admin')

@section('content')
<div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 rounded-lg shadow-sm mb-4">
    <div class="w-full mb-1">
        <div class="mb-4">
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl">Kategori Produk</h1>
        </div>
        <div class="sm:flex justify-between items-center">
            <span class="text-sm text-gray-500">Kelola kelompok dan pengelompokan jenis barang</span>
            <a href="{{ route('admin.categories.create') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">
                + Tambah Kategori
            </a>
        </div>
    </div>
</div>

@if(session('success'))
<div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
    {{ session('success') }}
</div>
@endif

<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3">Nama Kategori</th>
                <th scope="col" class="px-6 py-3">Slug</th>
                <th scope="col" class="px-6 py-3">Deskripsi</th>
                <th scope="col" class="px-6 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
            <tr class="bg-white border-b hover:bg-gray-50">
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ $category->name }}</td>
                <td class="px-6 py-4"><code class="text-xs bg-gray-100 px-2 py-1 rounded text-gray-600">{{ $category->slug }}</code></td>
                <td class="px-6 py-4">{{ $category->description ?? '-' }}</td>
                <td class="px-6 py-4 flex space-x-2">
                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="font-medium text-blue-600 hover:underline">Edit</a>
                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini? Semua produk terkait mungkin akan terpengaruh.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="font-medium text-red-600 hover:underline">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada data kategori.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $categories->links() }}
</div>
@endsection