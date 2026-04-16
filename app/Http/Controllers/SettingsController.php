<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class SettingsController extends Controller
{
    public function index(): View
    {
        $settings = [
            'site_name' => Setting::get('site_name', 'Riwayat Naturals'),
            'tagline' => Setting::get('tagline', '100% Natural Hair Care'),
            'logo' => Setting::get('logo', ''),
            'phone' => Setting::get('phone', '+1 234 567 890'),
            'email' => Setting::get('email', 'info@riwayathair.com'),
            'address' => Setting::get('address', '123 Nature Street, Garden City, GC 12345'),
            'currency' => Setting::get('currency', 'PKR'),
            'currency_symbol' => Setting::get('currency_symbol', '₨'),
        ];
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'site_name' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'logo' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'currency' => 'nullable|string|max:10',
            'currency_symbol' => 'nullable|string|max:5',
        ]);

        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        return back()->with('success', 'Settings saved successfully!');
    }
}