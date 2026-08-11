<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'supplier']);

        // Fitur Pencarian Sederhana
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
        }

        $products = $query->latest()->paginate(10);

        return view('manager.products.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::with(['category', 'supplier'])->findOrFail($id);
        
        return view('manager.products.show', compact('product'));
    }
}