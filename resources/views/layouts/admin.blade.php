<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - {{ $globalSetting->app_name ?? 'Stockify' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Prevent theme flash: set the class before paint -->
    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>

    <!-- CSS KHUSUS PRINT / PDF -->
    <style>
        @media print {
            nav, aside, header, .print\:hidden {
                display: none !important;
            }
            body {
                background-color: white !important;
            }
            .lg\:ml-64 {
                margin-left: 0 !important;
            }
            div[class*="pt-20"] {
                padding-top: 0 !important;
            }
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900">

@php
    $userRole = strtolower(Auth::user()?->role ?? '');
    $isAdmin = $userRole === 'admin';
    $isManager = in_array($userRole, ['manager', 'manager_gudang']);
    $isStaff = in_array($userRole, ['staff', 'staff_gudang']);

    $homeRoute = $isStaff ? 'staff.dashboard' : ($isManager ? 'manager.dashboard' : 'admin.dashboard');

    $roleLabelMap = [
        'admin' => 'Administrator',
        'manager' => 'Manajer Gudang',
        'manager_gudang' => 'Manajer Gudang',
        'staff' => 'Staff Gudang',
        'staff_gudang' => 'Staff Gudang',
    ];
    $roleLabel = $roleLabelMap[$userRole] ?? ucfirst(str_replace('_', ' ', $userRole));

    $navIcon = function (string $name) {
        $icons = [
            'home' => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />',
            'box' => '<path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />',
            'swap' => '<path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5M16.5 3L21 7.5m0 0L16.5 12M21 7.5H7.5" />',
            'clipboard-check' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />',
            'truck' => '<path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v11.177m0-11.177L12.164 4.31a2.056 2.056 0 00-1.58-.86H4.874a2.056 2.056 0 00-1.58.86L1.32 7.573a2.056 2.056 0 00-.32 1.096V14.25" />',
            'users' => '<path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />',
            'chart' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />',
            'cog' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.297 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.542-.56.94-1.11.94h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />',
            'archive' => '<path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />',
            'document' => '<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />',
            'clock' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />',
            'in' => '<path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15.75l4.5 4.5 4.5-4.5m-9-6l4.5 4.5 4.5-4.5" />',
            'out' => '<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 8.25l-4.5-4.5-4.5 4.5m9 6l-4.5 4.5-4.5-4.5" />',
            'tag' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.66.33a23.255 23.255 0 004.984-4.984c.542-.88.369-1.961-.33-2.66l-9.58-9.581A2.25 2.25 0 009.568 3z" /><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />',
        ];
        return $icons[$name] ?? '';
    };
@endphp

<!-- NAVBAR -->
<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
  <div class="px-3 py-3 lg:px-5 lg:pl-3">
    <div class="flex items-center justify-between">
      <div class="flex items-center justify-start">
        <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
            <span class="sr-only">Buka sidebar</span>
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path></svg>
        </button>
        <a href="{{ route($homeRoute) }}" class="flex items-center ms-2 lg:me-6 space-x-2">
          @if(isset($globalSetting) && $globalSetting->app_logo)
            <img src="{{ asset('storage/' . $globalSetting->app_logo) }}" class="h-8 w-auto me-2" alt="Logo {{ $globalSetting->app_name }}">
          @else
            <div class="bg-indigo-600 text-white p-1.5 rounded-lg me-2">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4V5h12v10z"></path>
              </svg>
            </div>
          @endif
          <span class="self-center text-xl font-bold sm:text-2xl whitespace-nowrap text-gray-900 dark:text-white">
            {{ $globalSetting->app_name ?? 'Stockify' }}
          </span>
        </a>
      </div>
      <div class="flex items-center gap-1.5 sm:gap-3">

        <!-- Dark mode toggle -->
        <button id="theme-toggle" type="button" class="p-2 text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
            <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
            <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd" fill-rule="evenodd"></path></svg>
            <span class="sr-only">Ganti tema</span>
        </button>

        <!-- User menu -->
        <button type="button" class="flex items-center gap-2.5 pl-1.5 pr-2.5 sm:pl-2 sm:pr-3 py-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-200 dark:focus:ring-gray-600" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom-end">
            <span class="flex items-center justify-center w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 dark:bg-indigo-900/50 dark:text-indigo-300 text-sm font-bold shrink-0">
                {{ strtoupper(substr(Auth::user()?->name ?? 'U', 0, 1)) }}
            </span>
            <span class="hidden sm:block text-left">
                <span class="block text-sm font-semibold text-gray-900 dark:text-white leading-tight">{{ Auth::user()?->name }}</span>
                <span class="block text-xs text-gray-500 dark:text-gray-400 leading-tight">{{ $roleLabel }}</span>
            </span>
            <svg class="hidden sm:block w-3 h-3 text-gray-400" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/></svg>
        </button>
        <div class="z-50 hidden my-2 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-lg border border-gray-100 dark:bg-gray-800 dark:divide-gray-600 dark:border-gray-700" id="user-dropdown">
            <div class="px-4 py-3">
                <span class="block text-sm font-semibold text-gray-900 dark:text-white">{{ Auth::user()?->name }}</span>
                <span class="block text-sm text-gray-500 truncate dark:text-gray-400">{{ Auth::user()?->email }}</span>
            </div>
            <div class="py-1">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-red-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" /></svg>
                        Keluar
                    </button>
                </form>
            </div>
        </div>
      </div>
    </div>
  </div>
</nav>

<!-- Sidebar Navigation -->
<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 lg:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
   <div class="h-full px-3 pb-4 overflow-y-auto">
      <ul class="space-y-1 font-medium">

    @php
        // Helper closure to render a nav link with icon + active state
        $navLink = function ($routeName, $routePattern, $label, $icon) use ($navIcon) {
            $active = request()->routeIs($routePattern);
            $base = 'flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors border-l-[3px]';
            $activeCls = 'bg-indigo-50 border-indigo-600 text-indigo-700 font-semibold dark:bg-indigo-900/30 dark:text-indigo-300 dark:border-indigo-400';
            $inactiveCls = 'border-transparent text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white';
            $cls = $active ? $activeCls : $inactiveCls;
            $iconCls = $active ? 'text-indigo-600 dark:text-indigo-300' : 'text-gray-400 dark:text-gray-500';
            return '<li><a href="' . route($routeName) . '" class="' . $cls . ' ' . $base . '">'
                 . '<svg class="w-5 h-5 shrink-0 ' . $iconCls . '" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">' . $navIcon($icon) . '</svg>'
                 . '<span>' . $label . '</span></a></li>';
        };
    @endphp

    {{-- MENU ADMIN --}}
    @if($isAdmin)
        {!! $navLink('admin.dashboard', 'admin.dashboard', 'Dashboard', 'home') !!}
        {!! $navLink('admin.products.index', 'admin.products*', 'Produk', 'box') !!}

        <li class="pt-2">
            <button type="button" class="flex items-center justify-between w-full px-3 py-2 text-xs font-bold tracking-wider text-gray-400 uppercase dark:text-gray-500" aria-controls="dropdown-stok-admin" data-collapse-toggle="dropdown-stok-admin">
                <span>Stok</span>
                <svg class="w-3 h-3 transition-transform" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/></svg>
            </button>
            <ul id="dropdown-stok-admin" class="space-y-1 {{ request()->routeIs('admin.stock-transactions.*', 'admin.stock-opnames.*', 'admin.categories.*') ? '' : 'hidden' }}">
                {!! $navLink('admin.categories.index', 'admin.categories*', 'Kategori', 'tag') !!}
                {!! $navLink('admin.stock-transactions.index', 'admin.stock-transactions.*', 'Transaksi Stok', 'swap') !!}
                {!! $navLink('admin.stock-opnames.index', 'admin.stock-opnames.*', 'Stock Opname', 'clipboard-check') !!}
            </ul>
        </li>

        {!! $navLink('admin.suppliers.index', 'admin.suppliers*', 'Supplier', 'truck') !!}
        {!! $navLink('admin.users.index', 'admin.users*', 'Pengguna', 'users') !!}

        <li class="pt-2">
            <button type="button" class="flex items-center justify-between w-full px-3 py-2 text-xs font-bold tracking-wider text-gray-400 uppercase dark:text-gray-500" aria-controls="dropdown-laporan-admin" data-collapse-toggle="dropdown-laporan-admin">
                <span>Laporan</span>
                <svg class="w-3 h-3 transition-transform" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/></svg>
            </button>
            <ul id="dropdown-laporan-admin" class="space-y-1 {{ request()->routeIs('admin.reports.*') ? '' : 'hidden' }}">
                {!! $navLink('admin.reports.stock', 'admin.reports.stock', 'Laporan Stok', 'archive') !!}
                {!! $navLink('admin.reports.transactions', 'admin.reports.transactions', 'Laporan Transaksi', 'document') !!}
                {!! $navLink('admin.reports.activity-logs', 'admin.reports.activity-logs', 'Log Aktivitas', 'clock') !!}
            </ul>
        </li>

        <li class="pt-2 mt-2 border-t border-gray-100 dark:border-gray-700">
            {!! $navLink('admin.settings.index', 'admin.settings*', 'Pengaturan', 'cog') !!}
        </li>

    {{-- MENU MANAJER GUDANG --}}
    @elseif($isManager)
        {!! $navLink('manager.dashboard', 'manager.dashboard', 'Dashboard Gudang', 'home') !!}
        {!! $navLink('manager.products.index', 'manager.products*', 'Daftar Produk', 'box') !!}

        <li class="pt-2">
            <button type="button" class="flex items-center justify-between w-full px-3 py-2 text-xs font-bold tracking-wider text-gray-400 uppercase dark:text-gray-500" aria-controls="dropdown-stok-manager" data-collapse-toggle="dropdown-stok-manager">
                <span>Stok</span>
                <svg class="w-3 h-3 transition-transform" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/></svg>
            </button>
            <ul id="dropdown-stok-manager" class="space-y-1 {{ request()->routeIs('manager.transactions.*', 'manager.stock-opname.*') ? '' : 'hidden' }}">
                {!! $navLink('manager.transactions.index', 'manager.transactions.*', 'Transaksi Stok', 'swap') !!}
                {!! $navLink('manager.stock-opname.index', 'manager.stock-opname.*', 'Stock Opname', 'clipboard-check') !!}
            </ul>
        </li>

        {!! $navLink('manager.suppliers.index', 'manager.suppliers*', 'Daftar Supplier', 'truck') !!}

        <li class="pt-2">
            <button type="button" class="flex items-center justify-between w-full px-3 py-2 text-xs font-bold tracking-wider text-gray-400 uppercase dark:text-gray-500" aria-controls="dropdown-laporan-manager" data-collapse-toggle="dropdown-laporan-manager">
                <span>Laporan</span>
                <svg class="w-3 h-3 transition-transform" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/></svg>
            </button>
            <ul id="dropdown-laporan-manager" class="space-y-1 {{ request()->routeIs('manager.reports.*') ? '' : 'hidden' }}">
                {!! $navLink('manager.reports.stock', 'manager.reports.stock', 'Laporan Stok', 'archive') !!}
                {!! $navLink('manager.reports.transactions', 'manager.reports.transactions', 'Laporan Transaksi', 'document') !!}
            </ul>
        </li>

    {{-- MENU STAFF GUDANG --}}
    @elseif($isStaff)
        {!! $navLink('staff.dashboard', 'staff.dashboard', 'Dashboard Tugas', 'home') !!}

        <li class="pt-2">
            <button type="button" class="flex items-center justify-between w-full px-3 py-2 text-xs font-bold tracking-wider text-gray-400 uppercase dark:text-gray-500" aria-controls="dropdown-stok-staff" data-collapse-toggle="dropdown-stok-staff">
                <span>Stok</span>
                <svg class="w-3 h-3 transition-transform" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/></svg>
            </button>
            <ul id="dropdown-stok-staff" class="space-y-1 {{ request()->routeIs('staff.confirmations.*') ? '' : 'hidden' }}">
                <li>
                    @php $activeIn = request()->routeIs('staff.confirmations.index') && request('type') == 'in'; @endphp
                    <a href="{{ route('staff.confirmations.index', ['type' => 'in']) }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm border-l-[3px] transition-colors {{ $activeIn ? 'bg-indigo-50 border-indigo-600 text-indigo-700 font-semibold dark:bg-indigo-900/30 dark:text-indigo-300 dark:border-indigo-400' : 'border-transparent text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }}">
                        <svg class="w-5 h-5 shrink-0 {{ $activeIn ? 'text-indigo-600 dark:text-indigo-300' : 'text-gray-400 dark:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">{!! $navIcon('in') !!}</svg>
                        <span>Konfirmasi Penerimaan</span>
                    </a>
                </li>
                <li>
                    @php $activeOut = request()->routeIs('staff.confirmations.index') && request('type') == 'out'; @endphp
                    <a href="{{ route('staff.confirmations.index', ['type' => 'out']) }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm border-l-[3px] transition-colors {{ $activeOut ? 'bg-indigo-50 border-indigo-600 text-indigo-700 font-semibold dark:bg-indigo-900/30 dark:text-indigo-300 dark:border-indigo-400' : 'border-transparent text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }}">
                        <svg class="w-5 h-5 shrink-0 {{ $activeOut ? 'text-indigo-600 dark:text-indigo-300' : 'text-gray-400 dark:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">{!! $navIcon('out') !!}</svg>
                        <span>Konfirmasi Pengeluaran</span>
                    </a>
                </li>
            </ul>
        </li>
    @endif

</ul>
   </div>
</aside>

    <!-- CONTENT -->
    <div class="p-4 lg:ml-64 pt-20">
       @yield('content')
    </div>

</body>
</html>