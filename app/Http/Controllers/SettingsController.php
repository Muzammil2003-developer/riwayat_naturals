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
            'announcement_text' => Setting::get('announcement_text', 'Rivaaj Mahal Official WhatsApp Numbers : 0327 2222189'),
            'phone' => Setting::get('phone', '+1 234 567 890'),
            'email' => Setting::get('email', 'info@riwayathair.com'),
            'admin_order_email' => Setting::get('admin_order_email', 'info@riwayathair.com'),
            'address' => Setting::get('address', '123 Nature Street, Garden City, GC 12345'),
            'currency' => Setting::get('currency', 'PKR'),
            'currency_symbol' => Setting::get('currency_symbol', 'Rs.'),
            'whatsapp_number' => Setting::get('whatsapp_number', ''),
            'whatsapp_link' => Setting::get('whatsapp_link', ''),
            'tiktok_url' => Setting::get('tiktok_url', ''),
            'facebook_url' => Setting::get('facebook_url', ''),
            'youtube_url' => Setting::get('youtube_url', ''),
            'instagram_url' => Setting::get('instagram_url', ''),
        ];

        return view('admin.settings.index', compact('settings'));
    }

public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'site_name' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'announcement_text' => 'nullable|string|max:255',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'admin_order_email' => 'nullable|email',
            'address' => 'nullable|string',
            'currency' => 'nullable|string|max:10',
            'currency_symbol' => 'nullable|string|max:10',
            'whatsapp_number' => 'nullable|string|max:30',
            'whatsapp_link' => 'nullable|url|max:255',
            'tiktok_url' => 'nullable|url|max:255',
            'facebook_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
        ]);

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $filename = 'logo.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('storage'), $filename);
            Setting::set('logo', 'storage/' . $filename);
        }

        unset($data['logo']);

        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        return back()->with('success', 'Settings saved successfully!');
    }
}
