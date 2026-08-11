<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Supplier;
use App\Models\Category;
use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Pengguna (Users)
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@stockify.test',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Staf Gudang',
            'email' => 'gudang@stockify.test',
            'password' => Hash::make('password'),
        ]);

        // 2. Seed Supplier
        $suppliers = [
            ['name' => 'PT Tech Indo Jaya', 'email' => 'sales@techindo.co.id', 'phone' => '081234567890', 'address' => 'Jakarta Barat'],
            ['name' => 'CV Electro Central', 'email' => 'info@electrocentral.com', 'phone' => '082198765432', 'address' => 'Surabaya'],
            ['name' => 'Distributor Gadget Nusantara', 'email' => 'contact@gadgetnusantara.id', 'phone' => '085711223344', 'address' => 'Bandung'],
            ['name' => 'PT Logistics Office Pro', 'email' => 'support@officepro.co.id', 'phone' => '083899001122', 'address' => 'Semarang'],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }

        // 3. Seed Kategori Produk
        $categories = [
            ['name' => 'Laptop & Komputer', 'slug' => 'laptop-komputer'],
            ['name' => 'Aksesoris PC', 'slug' => 'aksesoris-pc'],
            ['name' => 'Gadget & Smartphone', 'slug' => 'gadget-smartphone'],
            ['name' => 'Perlengkapan Kantor', 'slug' => 'perlengkapan-kantor'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // 4. Seed Produk
        $productsData = [
            [
                'code' => 'PRD-001',
                'name' => 'Laptop ASUS ROG Strix G15',
                'slug' => Str::slug('Laptop ASUS ROG Strix G15'),
                'category_id' => 1,
                'supplier_id' => 1,
                'purchase_price' => 18000000,
                'selling_price' => 20500000,
                'stock' => 15,
                'min_stock' => 5,
                'description' => 'Laptop Gaming High End AMD Ryzen 7',
            ],
            [
                'code' => 'PRD-002',
                'name' => 'Mouse Wireless Logitech MX Master 3S',
                'slug' => Str::slug('Mouse Wireless Logitech MX Master 3S'),
                'category_id' => 2,
                'supplier_id' => 2,
                'purchase_price' => 1200000,
                'selling_price' => 1550000,
                'stock' => 2, // Low stock!
                'min_stock' => 10,
                'description' => 'Mouse ergonomic terbaik untuk produktivitas',
            ],
            [
                'code' => 'PRD-003',
                'name' => 'Keyboard Mechanical Keychron K2',
                'slug' => Str::slug('Keyboard Mechanical Keychron K2'),
                'category_id' => 2,
                'supplier_id' => 2,
                'purchase_price' => 1100000,
                'selling_price' => 1400000,
                'stock' => 3, // Low stock!
                'min_stock' => 5,
                'description' => 'Wireless Mechanical Keyboard 75% Layout',
            ],
            [
                'code' => 'PRD-004',
                'name' => 'Monitor LG 24 Inch Full HD',
                'slug' => Str::slug('Monitor LG 24 Inch Full HD'),
                'category_id' => 1,
                'supplier_id' => 1,
                'purchase_price' => 1500000,
                'selling_price' => 1850000,
                'stock' => 25,
                'min_stock' => 8,
                'description' => 'IPS Panel 75Hz Ergonomic Base',
            ],
            [
                'code' => 'PRD-005',
                'name' => 'Samsung Galaxy Tab S9',
                'slug' => Str::slug('Samsung Galaxy Tab S9'),
                'category_id' => 3,
                'supplier_id' => 3,
                'purchase_price' => 11000000,
                'selling_price' => 12999000,
                'stock' => 1, // Low stock!
                'min_stock' => 4,
                'description' => 'Tablet flagship Amoled Dynamic 2X',
            ],
            [
                'code' => 'PRD-006',
                'name' => 'Meja Kerja Ergonomis Desk',
                'slug' => Str::slug('Meja Kerja Ergonomis Desk'),
                'category_id' => 4,
                'supplier_id' => 4,
                'purchase_price' => 2200000,
                'selling_price' => 2800000,
                'stock' => 12,
                'min_stock' => 3,
                'description' => 'Meja kantor hidrolik adjustable height',
            ],
        ];

        foreach ($productsData as $p) {
            Product::create($p);
        }

        // 5. Seed Transaksi Stok Bulanan (Distribusi Januari - Agustus 2026)
        $monthlyTransactions = [
            1 => ['in' => 120, 'out' => 45],
            2 => ['in' => 85,  'out' => 60],
            3 => ['in' => 150, 'out' => 95],
            4 => ['in' => 90,  'out' => 110],
            5 => ['in' => 200, 'out' => 130],
            6 => ['in' => 110, 'out' => 80],
            7 => ['in' => 175, 'out' => 140],
            8 => ['in' => 95,  'out' => 50],
        ];

        foreach ($monthlyTransactions as $month => $data) {
            // Transaksi Stok Masuk
            StockTransaction::create([
                'product_id' => rand(1, 6),
                'supplier_id' => rand(1, 4),
                'type' => 'in',
                'quantity' => $data['in'],
                'date' => Carbon::create(2026, $month, rand(1, 14))->format('Y-m-d'),
                'notes' => 'Pembelian stok barang rutin bulanan',
            ]);

            // Transaksi Stok Keluar
            StockTransaction::create([
                'product_id' => rand(1, 6),
                'supplier_id' => null,
                'type' => 'out',
                'quantity' => $data['out'],
                'date' => Carbon::create(2026, $month, rand(15, 28))->format('Y-m-d'),
                'notes' => 'Pengeluaran stok pesanan operasional',
            ]);
        }
    }
}