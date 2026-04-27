@extends('admin.layouts.main')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Settings</h1>
        <p class="text-gray-500">Manage your website settings</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-lg p-8">
        <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="space-y-6">
                <div class="border-b pb-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Site Information</h2>
                    
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Site Name</label>
                            <input type="text" name="site_name" value="{{ $settings['site_name'] }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Tagline</label>
                            <input type="text" name="tagline" value="{{ $settings['tagline'] }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500">
                        </div>
                    </div>

<div class="mt-4">
                        <label class="block text-gray-700 font-medium mb-2">Logo Image</label>
                        <input type="file" name="logo" accept="image/*" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500">
                        @if($settings['logo'])
                            <img src="{{ asset($settings['logo']) }}" alt="Logo" class="mt-2 h-16 w-auto">
                        @endif
                        <p class="text-xs text-gray-500 mt-1">Upload a logo image (jpg, png, gif, svg, webp)</p>
                    </div>
                    <div class="mt-4">
                        <label class="block text-gray-700 font-medium mb-2">Top Announcement Text</label>
                        <input type="text" name="announcement_text" value="{{ $settings['announcement_text'] ?? '' }}" placeholder="Rivaaj Mahal Official WhatsApp Numbers : 0327 2222189" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500">
                    </div>
                </div>

                <div class="border-b pb-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Contact Information</h2>
                    
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Phone</label>
                            <input type="text" name="phone" value="{{ $settings['phone'] }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Email</label>
                            <input type="email" name="email" value="{{ $settings['email'] }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500">
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-gray-700 font-medium mb-2">Admin Order Email</label>
                        <input type="email" name="admin_order_email" value="{{ $settings['admin_order_email'] ?? '' }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500" placeholder="orders@example.com">
                        <p class="text-xs text-gray-500 mt-1">New order notifications will be sent to this email.</p>
                    </div>
                    
                    <div class="mt-4">
                        <label class="block text-gray-700 font-medium mb-2">Address</label>
                        <textarea name="address" rows="2" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500">{{ $settings['address'] }}</textarea>
                    </div>
                </div>

                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Currency Settings</h2>
                    
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Currency Code</label>
                            <input type="text" name="currency" value="{{ $settings['currency'] }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500" placeholder="PKR">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Currency Symbol</label>
                            <input type="text" name="currency_symbol" value="{{ $settings['currency_symbol'] }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500" placeholder="Rs.">
                        </div>
                    </div>
                </div>

                <div class="border-t pt-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Social & WhatsApp</h2>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">WhatsApp Number</label>
                            <input type="text" name="whatsapp_number" value="{{ $settings['whatsapp_number'] ?? '' }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500" placeholder="923001234567">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">WhatsApp Link</label>
                            <input type="url" name="whatsapp_link" value="{{ $settings['whatsapp_link'] ?? '' }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500" placeholder="https://wa.me/923001234567">
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">TikTok URL</label>
                            <input type="url" name="tiktok_url" value="{{ $settings['tiktok_url'] ?? '' }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500" placeholder="https://www.tiktok.com/@yourpage">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Facebook URL</label>
                            <input type="url" name="facebook_url" value="{{ $settings['facebook_url'] ?? '' }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500" placeholder="https://www.facebook.com/yourpage">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">YouTube URL</label>
                            <input type="url" name="youtube_url" value="{{ $settings['youtube_url'] ?? '' }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500" placeholder="https://www.youtube.com/@yourchannel">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Instagram URL</label>
                            <input type="url" name="instagram_url" value="{{ $settings['instagram_url'] ?? '' }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500" placeholder="https://www.instagram.com/yourpage">
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full mt-8 green-gradient text-white py-3 rounded-lg font-bold hover:bg-amber-700 transition">
                <i class="fas fa-save mr-2"></i> Save Settings
            </button>
        </form>
    </div>
</div>
@endsection
