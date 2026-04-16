@extends('admin.layouts.main')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Orders</h1>
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
                    <th class="px-6 py-4 text-left">Order ID</th>
                    <th class="px-6 py-4 text-left">Product</th>
                    <th class="px-6 py-4 text-left">Customer</th>
                    <th class="px-6 py-4 text-left">Phone</th>
                    <th class="px-6 py-4 text-left">Address</th>
                    <th class="px-6 py-4 text-left">Qty</th>
                    <th class="px-6 py-4 text-left">Total</th>
                    <th class="px-6 py-4 text-left">Status</th>
                    <th class="px-6 py-4 text-left">Date</th>
                    <th class="px-6 py-4 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($orders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-gray-800 font-medium">#{{ $order->id }}</td>
                        <td class="px-6 py-4">
                            @if($order->product)
                                <div class="flex items-center space-x-2">
                                    @if($order->product->image)
                                        <img src="{{ asset('storage/' . $order->product->image) }}" alt="" class="w-10 h-10 object-cover rounded">
                                    @else
                                        <div class="w-10 h-10 bg-amber-100 rounded flex items-center justify-center">
                                            <i class="fas fa-oil-can text-amber-400"></i>
                                        </div>
                                    @endif
                                    <span class="text-gray-800">{{ $order->product->name }}</span>
                                </div>
                            @else
                                <span class="text-gray-400">Product deleted</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-800">{{ $order->customer_name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $order->customer_phone }}</td>
                        <td class="px-6 py-4 text-gray-600 text-sm">{{ $order->customer_address }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $order->quantity }}</td>
                        <td class="px-6 py-4 text-gray-800 font-bold">₨{{ number_format($order->total_price, 2) }}</td>
                        <td class="px-6 py-4">
                            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()" class="px-3 py-1 rounded-full text-sm font-medium border-0 cursor-pointer
                                    @if($order->status == 'pending') bg-yellow-100 text-yellow-700
                                    @elseif($order->status == 'confirmed') bg-blue-100 text-blue-700
                                    @elseif($order->status == 'shipped') bg-purple-100 text-purple-700
                                    @elseif($order->status == 'delivered') bg-green-100 text-green-700
                                    @elseif($order->status == 'cancelled') bg-red-100 text-red-700
                                    @endif">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </form>
                        </td>
                        <td class="px-6 py-4 text-gray-500 text-sm">{{ $order->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4">
                            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-100 text-red-700 px-3 py-2 rounded-lg hover:bg-red-200 transition">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @if($orders->isEmpty())
                    <tr>
                        <td colspan="10" class="px-6 py-8 text-center text-gray-500">
                            No orders found yet.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection