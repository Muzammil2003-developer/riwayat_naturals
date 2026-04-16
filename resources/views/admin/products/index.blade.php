@extends('admin.layouts.main')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Products</h1>
        <a href="{{ route('admin.products.create') }}" class="green-gradient text-white px-6 py-3 rounded-lg hover:opacity-90 transition">
            <i class="fas fa-plus mr-2"></i> Add New Product
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <table class="w-full data-table">
            <thead class="green-gradient text-white">
                <tr>
                    <th class="px-6 py-4 text-left">Image</th>
                    <th class="px-6 py-4 text-left">Name</th>
                    <th class="px-6 py-4 text-left">Price</th>
                    <th class="px-6 py-4 text-left">Status</th>
                    <th class="px-6 py-4 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($products as $product)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded-lg">
                            @else
                                <div class="w-16 h-16 bg-amber-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-oil-can text-amber-400 text-xl"></i>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $product->name }}</td>
                        <td class="px-6 py-4 text-gray-600">₨{{ number_format($product->price, 2) }}</td>
                        <td class="px-6 py-4">
                            @if($product->is_active)
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">Active</span>
                            @else
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">Inactive</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="bg-blue-100 text-blue-700 px-3 py-2 rounded-lg hover:bg-blue-200 transition">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
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
                @if($products->isEmpty())
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            No products found. Add your first product!
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection