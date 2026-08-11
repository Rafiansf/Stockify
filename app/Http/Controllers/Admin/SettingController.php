<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::firstOrCreate([], [
            'app_name' => 'Stockify',
            'footer_text' => 'Stockify Inventory Management System © ' . date('Y'),
        ]);

        return view('admin.settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        // Menggunakan firstOrCreate agar aman jika dipanggil sebelum index()
        $setting = Setting::firstOrCreate([], [
            'app_name' => 'Stockify',
            'footer_text' => 'Stockify Inventory Management System © ' . date('Y'),
        ]);

        $request->validate([
            'app_name'    => 'required|string|max:255',
            'app_logo'    => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
            'address'     => 'nullable|string',
            'phone'       => 'nullable|string|max:50',
            'email'       => 'nullable|email|max:255',
            'footer_text' => 'nullable|string|max:255',
        ]);

        $data = $request->only(['app_name', 'address', 'phone', 'email', 'footer_text']);

        // Upload Logo Baru jika ada
        if ($request->hasFile('app_logo')) {
            if ($setting->app_logo && Storage::disk('public')->exists($setting->app_logo)) {
                Storage::disk('public')->delete($setting->app_logo);
            }
            $data['app_logo'] = $request->file('app_logo')->store('settings', 'public');
        }

        $setting->update($data);

        return redirect()->back()->with('success', 'Pengaturan aplikasi berhasil diperbarui.');
    }
}