<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;

// Controller Admin
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\SupplierController as AdminSupplierController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\StockTransactionController as AdminStockTransactionController;
use App\Http\Controllers\Admin\StockOpnameController as AdminStockOpnameController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;

// Controller Manager Gudang
use App\Http\Controllers\Manager\DashboardController as ManagerDashboardController;
use App\Http\Controllers\Manager\ProductController as ManagerProductController;
use App\Http\Controllers\Manager\StockTransactionController as ManagerStockTransactionController;
use App\Http\Controllers\Manager\StockOpnameController as ManagerStockOpnameController;
use App\Http\Controllers\Manager\SupplierController as ManagerSupplierController;
use App\Http\Controllers\Manager\ReportController as ManagerReportController;

// Controller Staff Gudang
use App\Http\Controllers\Staff\DashboardController as StaffDashboardController;
use App\Http\Controllers\Staff\StockConfirmationController as StaffStockConfirmationController;

// Redirect Berdasarkan Role
Route::get('/', function () {
    if (Auth::check()) {
        $role = strtolower(Auth::user()->role);
        if ($role === 'admin') return redirect()->route('admin.dashboard');
        if (in_array($role, ['manager', 'manager_gudang'])) return redirect()->route('manager.dashboard');
        if (in_array($role, ['staff', 'staff_gudang'])) return redirect()->route('staff.dashboard');
    }
    return redirect()->route('login');
});

// Autentikasi
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {    
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('products/export', [AdminProductController::class, 'export'])->name('products.export');
    Route::post('products/import', [AdminProductController::class, 'import'])->name('products.import');
    
    Route::resource('users', AdminUserController::class);
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('products', AdminProductController::class);
    Route::resource('suppliers', AdminSupplierController::class);
    
    // Penyesuaian nama resource agar sesuai layout sidebar (stock-opnames)
    Route::resource('stock-opnames', AdminStockOpnameController::class)->except(['edit', 'update']);
    Route::resource('stock-transactions', AdminStockTransactionController::class)->only(['index', 'create', 'store']);
    
    Route::get('settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [AdminSettingController::class, 'update'])->name('settings.update');
    
    Route::get('reports/stock', [AdminReportController::class, 'stock'])->name('reports.stock');
    Route::get('reports/transactions', [AdminReportController::class, 'transactions'])->name('reports.transactions');
    Route::get('reports/activity-logs', [AdminReportController::class, 'activityLogs'])->name('reports.activity-logs');
});

// Route Manager Gudang
Route::middleware(['auth', 'role:manager,manager_gudang'])->prefix('manager')->name('manager.')->group(function () {    
    Route::get('/dashboard', [ManagerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/products', [ManagerProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [ManagerProductController::class, 'show'])->name('products.show');
    
    Route::get('/transactions', [ManagerStockTransactionController::class, 'index'])->name('transactions.index');
    Route::post('/transactions', [ManagerStockTransactionController::class, 'store'])->name('transactions.store');
    
    Route::get('/stock-opname', [ManagerStockOpnameController::class, 'index'])->name('stock-opname.index');
    Route::post('/stock-opname', [ManagerStockOpnameController::class, 'store'])->name('stock-opname.store');
    
    Route::get('/suppliers', [ManagerSupplierController::class, 'index'])->name('suppliers.index');
    
    Route::get('/reports/stock', [ManagerReportController::class, 'stock'])->name('reports.stock');
    Route::get('/reports/transactions', [ManagerReportController::class, 'transactions'])->name('reports.transactions');
});

// Route Staff Gudang
Route::middleware(['auth', 'role:staff,staff_gudang'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', [StaffDashboardController::class, 'index'])->name('dashboard');
    Route::get('/confirmations', [StaffStockConfirmationController::class, 'index'])->name('confirmations.index');
    Route::put('/confirmations/{id}', [StaffStockConfirmationController::class, 'update'])->name('confirmations.update');
});