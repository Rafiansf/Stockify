<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

// Import Model
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Setting;
use App\Models\StockTransaction;

// Import Observer
use App\Observers\ProductObserver;
use App\Observers\SupplierObserver;
use App\Observers\StockTransactionObserver;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Registrasi Observer Otomatis
        Product::observe(ProductObserver::class);
        Supplier::observe(SupplierObserver::class);
        StockTransaction::observe(StockTransactionObserver::class);
        
        if (Schema::hasTable('settings')) {
            $globalSetting = Setting::first();
            View::share('globalSetting', $globalSetting);
        }

    }
}