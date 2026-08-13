<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::latest()->paginate(10);
        return view('admin.suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('admin.suppliers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'nullable|email|max:255',
            'phone'   => ['required', 'string', 'max:20', 'regex:/^[0-9\+\-\s\(\)]+$/'], // Validasi ketat nomor telepon[cite: 9]
            'address' => 'nullable|string',
        ]);

        Supplier::create($request->only(['name', 'email', 'phone', 'address']));

        return redirect()->route('admin.suppliers.index')->with('success', 'Data supplier berhasil ditambahkan.');
    }

    public function edit(Supplier $supplier)
    {
        return view('admin.suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'nullable|email|max:255',
            'phone'   => ['required', 'string', 'max:20', 'regex:/^[0-9\+\-\s\(\)]+$/'], // Validasi ketat nomor telepon[cite: 9]
            'address' => 'nullable|string',
        ]);

        $supplier->update($request->only(['name', 'email', 'phone', 'address']));

        return redirect()->route('admin.suppliers.index')->with('success', 'Data supplier berhasil diperbarui.');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('admin.suppliers.index')->with('success', 'Data supplier berhasil dihapus.');
    }
}