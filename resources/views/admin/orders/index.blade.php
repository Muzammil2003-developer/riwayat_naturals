@extends('admin.layouts.main')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Orders</h1>
            <p class="text-gray-500 mt-1">Manage customer purchases and update delivery status.</p>
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-4 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Total Orders</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $orders->count() }}</p>
                </div>
                <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-gray-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl p-4 border border-yellow-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-yellow-600 uppercase tracking-wide">Pending</p>
                    <p class="text-2xl font-bold text-yellow-800 mt-1">{{ $orders->where('status', 'pending')->count() }}</p>
                </div>
                <div class="w-10 h-10 bg-yellow-200 rounded-full flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 border border-blue-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-blue-600 uppercase tracking-wide">Confirmed</p>
                    <p class="text-2xl font-bold text-blue-800 mt-1">{{ $orders->where('status', 'confirmed')->count() }}</p>
                </div>
                <div class="w-10 h-10 bg-blue-200 rounded-full flex items-center justify-center">
                    <i class="fas fa-check-circle text-blue-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 border border-green-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-green-600 uppercase tracking-wide">Delivered</p>
                    <p class="text-2xl font-bold text-green-800 mt-1">{{ $orders->where('status', 'delivered')->count() }}</p>
                </div>
                <div class="w-10 h-10 bg-green-200 rounded-full flex items-center justify-center">
                    <i class="fas fa-check-double text-green-600"></i>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b bg-gray-50/70">
            <p class="text-sm text-gray-600">Tip: Use search to quickly find orders by customer name, phone, or address.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full data-table">
                <thead class="green-gradient text-white">
                    <tr>
                        <th class="px-6 py-4 text-left">SR#</th>
                        <th class="px-6 py-4 text-left">Item</th>
                        <th class="px-6 py-4 text-left">Customer</th>
                        <th class="px-6 py-4 text-left">WhatsApp</th>
                        <th class="px-6 py-4 text-left">Address</th>
                        <th class="px-6 py-4 text-left">Qty</th>
                        <th class="px-6 py-4 text-left">Total</th>
                        <th class="px-6 py-4 text-left">Status</th>
                        <th class="px-6 py-4 text-left">Date</th>
                        <th class="px-6 py-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($orders as $index => $order)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-gray-800 font-medium">{{ $index + 1 }}</td>
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
                                @elseif($order->package)
                                    <div class="flex items-center space-x-2">
                                        @if($order->package->image)
                                            <img src="{{ asset('storage/' . $order->package->image) }}" alt="" class="w-10 h-10 object-cover rounded">
                                        @else
                                            <div class="w-10 h-10 bg-emerald-100 rounded flex items-center justify-center">
                                                <i class="fas fa-gift text-emerald-500"></i>
                                            </div>
                                        @endif
                                        <span class="text-gray-800">{{ $order->package->name }} <span class="text-xs text-emerald-600 font-semibold">(Package)</span></span>
                                    </div>
                                @else
                                    <span class="text-gray-400">Item deleted</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-800">{{ $order->customer_name }}</td>
                            <td class="px-6 py-4 cursor-pointer text-green-600 hover:text-green-800 hover:underline font-medium transition-colors" onclick="openWhatsApp('{{ $order->customer_phone }}')" title="Open WhatsApp">{{ $order->customer_phone }}</td>
                            <td class="px-6 py-4 text-gray-600 text-sm">{{ $order->customer_address }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $order->quantity }}</td>
                            <td class="px-6 py-4 text-gray-800 font-bold">{{ $siteSettings['currency_symbol'] ?? 'Rs.' }}{{ number_format($order->total_price, 2) }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium ring-1 ring-inset
                                    @if($order->status == 'pending') bg-yellow-50 text-yellow-800 ring-yellow-200
                                    @elseif($order->status == 'confirmed') bg-blue-50 text-blue-800 ring-blue-200
                                    @elseif($order->status == 'shipped') bg-purple-50 text-purple-800 ring-purple-200
                                    @elseif($order->status == 'delivered') bg-green-50 text-green-800 ring-green-200
                                    @elseif($order->status == 'cancelled') bg-red-50 text-red-800 ring-red-200
                                    @endif">
                                    <i class="fas fa-circle mr-1 text-xs"></i>
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500 text-sm">{{ $order->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4">
                                <select onchange="updateStatus({{ $order->id }}, this.value, this)" data-status="{{ $order->status }}" class="text-sm border border-gray-300 rounded-lg px-3 py-1.5 bg-white focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none cursor-pointer
                                    @if($order->status == 'pending') text-yellow-700 border-yellow-300
                                    @elseif($order->status == 'confirmed') text-blue-700 border-blue-300
                                    @elseif($order->status == 'shipped') text-purple-700 border-purple-300
                                    @elseif($order->status == 'delivered') text-green-700 border-green-300
                                    @elseif($order->status == 'cancelled') text-red-700 border-red-300
                                    @endif">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                <button onclick="viewOrder({{ $index + 1 }}, {{ $order->id }})" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded transition ml-1" title="View">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="inline ml-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-red-600 hover:bg-red-50 rounded transition" title="Delete" onclick="return confirm('Delete order?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @if($orders->isEmpty())
                    <tr style="display:none;"><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                    @endif
                    </tbody>
                    </table>
                    @if($orders->isEmpty())
                    <div class="text-center py-12 text-gray-500">No orders found yet.</div>
                    @endif
                </div>
            </div>
        </div>
@endsection

<script>
function openWhatsApp(phone) {
    const cleanPhone = phone.replace(/\D/g, '');
    if (cleanPhone.length < 10) {
        alert('Invalid phone number');
        return;
    }
    const waUrl = `https://wa.me/92${cleanPhone}`;
    window.open(waUrl, '_blank', 'noopener,noreferrer');
}

function updateStatus(id, status, btn) {
    const originalValue = btn.dataset.original || btn.value;
    if (status === originalValue) return;
    
    btn.disabled = true;
    fetch('/admin/orders/' + id + '/status', {
        method: 'PATCH',
        body: JSON.stringify({ status: status }),
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error: ' + (data.message || 'Unknown error'));
            btn.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to update status');
        btn.disabled = false;
    });
}

document.querySelectorAll('select[data-status]').forEach(select => {
    select.dataset.original = select.value;
});

function viewOrder(sr, orderId) {
    fetch('/admin/orders/' + orderId, {
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(order => {
        document.getElementById('viewOrderId').textContent = sr;
        document.getElementById('viewCustomerName').textContent = order.customer_name;
        const phoneValue = order.customer_phone ?? '';
        const phoneContainer = document.getElementById('viewCustomerPhone');
        phoneContainer.innerHTML = '';
        const phoneSpan = document.createElement('span');
        phoneSpan.className = 'cursor-pointer text-green-600 hover:text-green-800 font-medium flex items-center gap-1';
        phoneSpan.title = 'WhatsApp';
        phoneSpan.onclick = () => openWhatsApp(phoneValue);
        phoneSpan.innerHTML = '<i class="fab fa-whatsapp text-sm" style="color: #25d366;"></i>';
        phoneSpan.appendChild(document.createTextNode(phoneValue));
        phoneContainer.appendChild(phoneSpan);
        document.getElementById('viewCustomerAddress').textContent = order.customer_address;
        document.getElementById('viewProduct').textContent = order.product ? order.product.name : (order.package ? order.package.name : 'N/A');
        document.getElementById('viewQuantity').textContent = order.quantity;
        document.getElementById('viewTotal').textContent = '{{ $siteSettings["currency_symbol"] ?? "Rs." }}' + parseFloat(order.total_price).toFixed(2);
        document.getElementById('viewStatus').textContent = order.status.charAt(0).toUpperCase() + order.status.slice(1);
        document.getElementById('viewDate').textContent = new Date(order.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
        
        const modal = document.getElementById('orderModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to load order details');
    });
}

function closeModal() {
    const modal = document.getElementById('orderModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>

<div id="orderModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50" onclick="closeModal()">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 overflow-hidden" onclick="event.stopPropagation()">
        <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-4">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-bold text-white">Order Details</h3>
                <button onclick="closeModal()" class="text-white/80 hover:text-white">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <p class="text-white/70 text-sm mt-1">Order SR# <span id="viewOrderId" class="font-semibold"></span></p>
        </div>
        <div class="p-6 space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-gray-500 uppercase">Customer</p>
                    <p id="viewCustomerName" class="text-gray-800 font-medium"></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase">Phone</p>
                    <p id="viewCustomerPhone" class="text-gray-800 font-medium"></p>
                </div>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase">Address</p>
                <p id="viewCustomerAddress" class="text-gray-800"></p>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-gray-500 uppercase">Product</p>
                    <p id="viewProduct" class="text-gray-800 font-medium"></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase">Quantity</p>
                    <p id="viewQuantity" class="text-gray-800 font-medium"></p>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-gray-500 uppercase">Total Price</p>
                    <p id="viewTotal" class="text-gray-800 font-bold text-lg"></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase">Status</p>
                    <p id="viewStatus" class="text-gray-800 font-medium"></p>
                </div>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase">Order Date</p>
                <p id="viewDate" class="text-gray-800"></p>
            </div>
        </div>
    </div>
</div>
