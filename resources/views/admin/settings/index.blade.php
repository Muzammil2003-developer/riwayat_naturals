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
                        <label class="block text-gray-700 font-medium mb-2">Logo URL</label>
                        <input type="text" name="logo" value="{{ $settings['logo'] }}" placeholder="Enter logo image URL" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500">
                        @if($settings['logo'])
                            <img src="{{ $settings['logo'] }}" alt="Logo" class="mt-2 h-16 w-auto">
                        @endif
                        <p class="text-xs text-gray-500 mt-1">Paste a logo image URL or upload to storage and paste the path</p>
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
                            <input type="text" name="currency_symbol" value="{{ $settings['currency_symbol'] }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500" placeholder="₨">
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