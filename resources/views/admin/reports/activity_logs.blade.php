@extends('layouts.admin')

@section('content')
<div class="space-y-4">
    <!-- Header -->
    <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm dark:bg-gray-800 dark:border-gray-700">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Log Aktivitas Pengguna</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">Catatan otomatis (*audit trail*) riwayat aktivitas seluruh pengguna di aplikasi.</p>
    </div>

    <!-- Form Filter -->
    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
        <form method="GET" action="{{ route('admin.reports.activity-logs') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Pengguna</label>
                <select name="user_id" class="w-full text-xs rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="">Semua Pengguna</option>
                    @foreach($users as $u)
                        <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full text-xs rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full text-xs rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="w-full py-2 bg-blue-600 text-white text-xs font-medium rounded-lg hover:bg-blue-700">Filter</button>
                <a href="{{ route('admin.reports.activity-logs') }}" class="w-full py-2 text-center bg-gray-200 text-gray-700 text-xs font-medium rounded-lg hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300">Reset</a>
            </div>
        </form>
    </div>

    <!-- Tabel Activity Log -->
    <div class="relative overflow-x-auto bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="px-4 py-3">Waktu</th>
                    <th class="px-4 py-3">Pengguna</th>
                    <th class="px-4 py-3">Deskripsi Aktivitas</th>
                    <th class="px-4 py-3">IP Address</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr class="bg-white border-b hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-4 py-3 text-xs whitespace-nowrap">{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                    <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $log->user->name ?? 'Sistem / Anonim' }}</td>
                    <td class="px-4 py-3 text-xs text-gray-800 dark:text-gray-200">{{ $log->description ?? $log->action }}</td>
                    <td class="px-4 py-3 text-xs font-mono text-gray-500">{{ $log->ip_address ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-6 text-center text-gray-500">Belum ada riwayat aktivitas pengguna.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection