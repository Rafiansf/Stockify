<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'supplier'])->latest()->paginate(10);
        $categories = Category::all(); 
        
        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        $suppliers = Supplier::all(); 
        return view('admin.products.create', compact('categories', 'suppliers')); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id', 
            'purchase_price' => 'nullable|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'size' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->except('image');

        if (!empty($data['purchase_price'])) {
            $data['purchase_price'] = $data['purchase_price'] * 1000;
        }
        if (!empty($data['selling_price'])) {
            $data['selling_price'] = $data['selling_price'] * 1000;
        }

        $latestId = Product::max('id') ?? 0;
        $data['code'] = 'PRD-' . str_pad($latestId + 1, 3, '0', STR_PAD_LEFT);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($request->name);
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $suppliers = Supplier::all(); 
        return view('admin.products.edit', compact('product', 'categories', 'suppliers')); 
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id', 
            'purchase_price' => 'nullable|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'size' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->except('image');

        if (!empty($data['purchase_price'])) {
            $data['purchase_price'] = $data['purchase_price'] * 1000;
        }
        if (!empty($data['selling_price'])) {
            $data['selling_price'] = $data['selling_price'] * 1000;
        }

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($request->name);
        }

        if ($request->hasFile('image')) {
            if ($product->image && Storage::exists('public/' . $product->image)) {
                Storage::delete('public/' . $product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Data produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        if ($product->image && Storage::exists('public/' . $product->image)) {
            Storage::delete('public/' . $product->image);
        }
        $product->delete();

        return redirect()->route('admin.products.index')
                         ->with('success', 'Produk berhasil dihapus.');
    }

    public function export()
    {
        $fileName = 'data_produk_' . date('Y-m-d_H-i-s') . '.csv';
        $products = Product::with(['category', 'supplier'])->orderBy('code', 'asc')->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Kode', 'Nama Produk', 'Kategori', 'Supplier', 'Harga Beli', 'Harga Jual', 'Stok', 'Ukuran', 'Warna'];

        $callback = function() use($products, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($products as $product) {
                fputcsv($file, [
                    $product->code,
                    $product->name,
                    $product->category->name ?? '-',
                    $product->supplier->name ?? '-',
                    $product->purchase_price ?? 0,
                    $product->selling_price ?? 0,
                    $product->stock,
                    $product->size ?? '-',
                    $product->color ?? '-'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('file');
        $handle = fopen($file->getRealPath(), 'r');
        
        fgetcsv($handle);

        while (($row = fgetcsv($handle, 1000, ',')) !== false) {
            $categoryName = $row[2] ?? null;
            $categoryId = null;
            if ($categoryName && $categoryName !== '-') {
                $category = Category::firstOrCreate(
                    ['name' => $categoryName],
                    ['slug' => Str::slug($categoryName)]
                );
                $categoryId = $category->id;
            }

            $supplierName = $row[3] ?? null;
            $supplierId = null;
            if ($supplierName && $supplierName !== '-') {
                $supplier = Supplier::firstOrCreate(
                    ['name' => $supplierName],
                    ['phone' => '-']
                );
                $supplierId = $supplier->id;
            }

            $latestId = Product::max('id') ?? 0;
            $code = !empty($row[0]) && $row[0] !== '-' ? $row[0] : 'PRD-' . str_pad($latestId + 1, 3, '0', STR_PAD_LEFT);

            Product::updateOrCreate(
                ['code' => $code],
                [
                    'name' => $row[1],
                    'slug' => Str::slug($row[1]),
                    'category_id' => $categoryId ?? Category::first()->id ?? 1,
                    'supplier_id' => $supplierId,
                    'purchase_price' => $row[4] ?? 0,
                    'selling_price' => $row[5] ?? 0,
                    'stock' => $row[6] ?? 0,
                    'min_stock' => 5,
                    'size' => $row[7] !== '-' ? $row[7] : null,
                    'color' => $row[8] !== '-' ? $row[8] : null,
                ]
            );
        }

        fclose($handle);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Data produk berhasil diimport!');
    }
}