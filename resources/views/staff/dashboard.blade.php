@extends('layouts.admin')

@section('title', 'Dashboard Tugas Staff')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Daftar Tugas Staff Gudang</h1>
        <span class="px-3 py-1 text-xs font-medium text-purple-800 bg-purple-100 rounded-full dark:bg-purple-900 dark:text-purple-300">
            Akses Staff Gudang
        </span>
    </div>

    <!-- Alert Notifikasi -->
    @if(session('success'))
        <div class="p-4 text-sm text-green-800 bg-green-100 rounded-lg dark:bg-green-900/50 dark:text-green-300">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 text-sm text-red-800 bg-red-100 rounded-lg dark:bg-red-900/50 dark:text-red-300">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Task Barang Masuk -->
        <div class="p-5 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">Barang Masuk Perlu Diperiksa</h2>
                <span class="px-2.5 py-0.5 text-xs font-semibold bg-emerald-100 text-emerald-800 rounded-full dark:bg-emerald-900/50 dark:text-emerald-300">
                    {{ $incomingTasks->count() }} Tugas
                </span>
            </div>
            <div class="space-y-3">
                @forelse($incomingTasks as $task)
                    <div class="p-4 bg-gray-50 rounded-lg border border-gray-100 dark:bg-gray-700 dark:border-gray-600 flex items-center justify-between">
                        <div>
                            <p class="font-bold text-gray-900 dark:text-white">{{ $task->product?->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                Jumlah: <span class="font-semibold text-emerald-600">+{{ $task->quantity }} Pcs</span>
                            </p>
                            <p class="text-xs text-gray-400 italic">Catatan: {{ $task->notes ?? '-' }}</p>
                        </div>
                        <form action="{{ route('staff.confirmations.update', $task->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="px-3 py-1.5 text-xs font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700">
                                Konfirmasi
                            </button>
                        </form>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 text-center py-6">Tidak ada barang masuk yang perlu diperiksa saat ini.</p>
                @endforelse
            </div>
        </div>

        <!-- Task Barang Keluar -->
        <div class="p-5 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">Barang Keluar Perlu Disiapkan</h2>
                <span class="px-2.5 py-0.5 text-xs font-semibold bg-blue-100 text-blue-800 rounded-full dark:bg-blue-900/50 dark:text-blue-300">
                    {{ $outgoingTasks->count() }} Tugas
                </span>
            </div>
            <div class="space-y-3">
                @forelse($outgoingTasks as $task)
                    <div class="p-4 bg-gray-50 rounded-lg border border-gray-100 dark:bg-gray-700 dark:border-gray-600 flex items-center justify-between">
                        <div>
                            <p class="font-bold text-gray-900 dark:text-white">{{ $task->product?->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                Jumlah: <span class="font-semibold text-blue-600">-{{ $task->quantity }} Pcs</span>
                            </p>
                            <p class="text-xs text-gray-400 italic">Catatan: {{ $task->notes ?? '-' }}</p>
                        </div>
                        <form action="{{ route('staff.confirmations.update', $task->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="px-3 py-1.5 text-xs font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                                Siapkan
                            </button>
                        </form>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 text-center py-6">Tidak ada barang keluar yang perlu disiapkan saat ini.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection