@extends('layouts.admin') {{-- Sesuaikan jika file layout Anda bernama layouts.manager --}}

@section('content')
<div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h2 class="text-xl font-bold text-gray-900">Stock Opname Gudang</h2>
            <p class="text-sm text-gray-500">Pencatatan dan penyesuaian stok fisik barang gudang.</p>
        </div>
        <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-4 py-2">
            + Tambah Stock Opname
        </button>
    </div>

    <!-- Tabel Data Stock Opname -->
    <div class="relative overflow-x-auto rounded-lg border border-gray-200">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">No</th>
                    <th scope="col" class="px-6 py-3">Tanggal</th>
                    <th scope="col" class="px-6 py-3">Nama Barang</th>
                    <th scope="col" class="px-6 py-3">Stok Sistem</th>
                    <th scope="col" class="px-6 py-3">Stok Fisik</th>
                    <th scope="col" class="px-6 py-3">Selisih</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td colspan="7" class="px-6 py-4 text-center text-gray-400">
                        Belum ada data transaksi stock opname.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection