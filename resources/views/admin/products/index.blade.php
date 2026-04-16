@extends('admin.layouts.main')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Products</h1>
        <a href="{{ route('admin.products.create') }}" class="bg-gradient-to-r from-[#2d5a27] to-[#1e3d1a] text-white px-6 py-3 rounded-xl hover:shadow-lg hover:-translate-y-0.5 transition-all font-semibold">
            <i class="fas fa-plus mr-2"></i> Add New Product
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full data-table" id="products-table">
            <thead>
                <tr>
                    <th class="px-6 py-4 text-left">Image</th>
                    <th class="px-6 py-4 text-left">Name</th>
                    <th class="px-6 py-4 text-left">Price</th>
                    <th class="px-6 py-4 text-left">Status</th>
                    <th class="px-6 py-4 text-left">Created</th>
                    <th class="px-6 py-4 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr class="hover:bg-emerald-50/30 transition">
                        <td class="px-6 py-4">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded-lg shadow-sm ring-1 ring-gray-200 hover:ring-emerald-300 hover:scale-105 transition-all">
                            @else
                                <div class="w-12 h-12 bg-gradient-to-br from-amber-400 to-amber-500 rounded-lg flex items-center justify-center shadow-sm ring-1 ring-gray-200">
                                    <i class="fas fa-oil-can text-white text-lg"></i>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div>
                                <div class="font-semibold text-gray-900">{{ $product->name }}</div>
                                <div class="text-sm text-gray-500">{{ Str::limit($product->description, 60) }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-2xl font-bold text-emerald-600">₨{{ number_format($product->price, 0) }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" {{ $product->is_active ? 'checked' : '' }} class="sr-only peer" onchange="toggleActive({{ $product->id }}, this.checked)">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                            </label>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $product->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="p-2 text-blue-500 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete product?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
function toggleActive(id, active) {
    fetch(`/admin/products/${id}/toggle`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ active: active })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Optional toast
            console.log(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        location.reload(); // Fallback
    });
}
</script>
@endsection
