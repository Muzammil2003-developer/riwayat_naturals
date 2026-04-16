@extends('admin.layouts.main')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Packages</h1>
        <a href="{{ route('admin.packages.create') }}" class="green-gradient text-white px-6 py-3 rounded-lg hover:opacity-90 transition">
            <i class="fas fa-plus mr-2"></i> Add New Package
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full data-table">
            <thead class="green-gradient text-white">
                <tr>
                    <th class="px-6 py-4 text-left">Image</th>
                    <th class="px-6 py-4 text-left">Package Name</th>
                    <th class="px-6 py-4 text-left">Original Price</th>
                    <th class="px-6 py-4 text-left">Discount Price</th>
                    <th class="px-6 py-4 text-left">Status</th>
                    <th class="px-6 py-4 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($packages as $package)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            @if($package->image)
                                <img src="{{ asset('storage/' . $package->image) }}" alt="{{ $package->name }}" class="w-16 h-16 object-cover rounded-lg">
                            @else
                                <div class="w-16 h-16 bg-amber-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-gift text-amber-400 text-xl"></i>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $package->name }}</td>
                        <td class="px-6 py-4 text-gray-600 line-through">{{ $siteSettings['currency_symbol'] ?? 'Rs.' }}{{ number_format($package->original_price, 2) }}</td>
                        <td class="px-6 py-4 text-green-700 font-semibold">{{ $siteSettings['currency_symbol'] ?? 'Rs.' }}{{ number_format($package->discount_price, 2) }}</td>
                        <td class="px-6 py-4">
                            @if($package->is_active)
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">Active</span>
                            @else
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">Inactive</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.packages.edit', $package->id) }}" class="bg-blue-100 text-blue-700 px-3 py-2 rounded-lg hover:bg-blue-200 transition">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.packages.destroy', $package->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-100 text-red-700 px-3 py-2 rounded-lg hover:bg-red-200 transition">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                @if($packages->isEmpty())
                <tr style="display:none;"><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                @endif
            </tbody>
        </table>
        @if($packages->isEmpty())
        <div class="text-center py-12 text-gray-500">No packages found. Add your first package!</div>
        @endif
    </div>
</div>
@endsection

