@extends('admin.layouts.main')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
        <p class="text-gray-500">Welcome to your admin panel</p>
    </div>

    <!-- New Stats: Visitors & Sales -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
            <p class="text-gray-500 text-sm">Total Visitors</p>
            <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['totalVisits']) }}</p>
        </div>
        <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
            <p class="text-gray-500 text-sm">Daily Visitors</p>
            <p class="text-3xl font-bold text-[#2d5a27]">{{ number_format($stats['dailyVisits']) }}</p>
        </div>
        <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
            <p class="text-gray-500 text-sm">Monthly Visitors</p>
            <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['monthlyVisits']) }}</p>
        </div>
        <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
            <p class="text-gray-500 text-sm">Total Bottles Sold</p>
            <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['totalBottlesSold']) }}</p>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
            <h3 class="font-bold text-gray-800 mb-2">Daily Visitors (Last 7 Days)</h3>
            <div class="relative h-40">
                <canvas id="dailyVisitorsChart"></canvas>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
            <h3 class="font-bold text-gray-800 mb-2">Orders Status</h3>
            <div class="relative h-40">
                <canvas id="ordersChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Existing Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-br from-[#2d5a27] to-[#4a7c42] rounded-2xl p-6 text-white shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-white/70 text-sm">Total Orders</p>
                    <p class="text-3xl font-bold">{{ $stats['totalOrders'] }}</p>
                </div>
                <i class="fas fa-shopping-cart text-4xl text-white/30"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl p-6 text-white shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm">Pending</p>
                    <p class="text-3xl font-bold">{{ $stats['pendingOrders'] }}</p>
                </div>
                <i class="fas fa-clock text-4xl text-white/30"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-[#22c55e] to-green-600 rounded-2xl p-6 text-white shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm">Delivered</p>
                    <p class="text-3xl font-bold">{{ $stats['deliveredOrders'] }}</p>
                </div>
                <i class="fas fa-check-circle text-4xl text-white/30"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-[#1e3d1a] to-[#2d5a27] rounded-2xl p-6 text-white shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-white/70 text-sm">Products</p>
                    <p class="text-3xl font-bold">{{ $stats['activeProducts'] }}</p>
                </div>
                <i class="fas fa-box text-4xl text-white/30"></i>
            </div>
        </div>
    </div>

    <!-- Revenue & Messages -->
    <div class="grid md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h3 class="font-bold text-gray-800 mb-2">Total Revenue</h3>
            <p class="text-3xl font-bold text-green-600">{{ $siteSettings['currency_symbol'] ?? 'Rs.' }}{{ number_format($stats['totalRevenue'], 0) }}</p>
            <p class="text-sm text-gray-500 mt-1">From confirmed orders</p>
        </div>
        
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h3 class="font-bold text-gray-800 mb-2">Messages</h3>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-3xl font-bold">{{ $stats['totalContacts'] }}</p>
                    @if($stats['unreadContacts'] > 0)
                        <p class="text-sm text-red-500">{{ $stats['unreadContacts'] }} new</p>
                    @endif
                </div>
                <i class="fas fa-envelope text-3xl text-gray-300"></i>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h3 class="font-bold text-gray-800 mb-2">Quick Stats</h3>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Confirmed:</span>
                    <span class="font-medium text-blue-600">{{ $stats['confirmedOrders'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Shipped:</span>
                    <span class="font-medium text-purple-600">{{ $stats['shippedOrders'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Cancelled:</span>
                    <span class="font-medium text-red-600">{{ $stats['cancelledOrders'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders & Contacts -->
    <div class="grid md:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="bg-gradient-to-r from-[#2d5a27] to-[#4a7c42] px-6 py-4 flex justify-between items-center">
                <h3 class="text-white font-bold">Recent Orders</h3>
                <a href="{{ route('admin.orders.index') }}" class="text-white/80 text-sm hover:text-white">View All</a>
            </div>
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Customer</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Product</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($stats['recentOrders'] as $order)
                    <tr>
                        <td class="px-4 py-3 text-sm">{{ $order->customer_name }}</td>
                        <td class="px-4 py-3 text-sm">{{ $order->product?->name ?? $order->package?->name ?? 'N/A' }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                @if($order->status == 'pending') bg-yellow-100 text-yellow-700
                                @elseif($order->status == 'confirmed') bg-blue-100 text-blue-700
                                @elseif($order->status == 'shipped') bg-purple-100 text-purple-700
                                @elseif($order->status == 'delivered') bg-green-100 text-green-700
                                @else bg-red-100 text-red-700
                                @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @if($stats['recentOrders']->isEmpty())
            <div class="text-center py-8 text-gray-500">No orders yet</div>
            @endif
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="bg-gradient-to-r from-[#2d5a27] to-[#4a7c42] px-6 py-4 flex justify-between items-center">
                <h3 class="text-white font-bold">Recent Messages</h3>
                <a href="{{ route('admin.contacts.index') }}" class="text-white/80 text-sm hover:text-white">View All</a>
            </div>
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Message</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($stats['recentContacts'] as $contact)
                    <tr>
                        <td class="px-4 py-3 text-sm">{{ $contact->name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500 truncate max-w-[150px]">{{ $contact->message }}</td>
                        <td class="px-4 py-3">
                            @if($contact->is_read)
                                <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-700">Read</span>
                            @else
                                <span class="px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-700">New</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @if($stats['recentContacts']->isEmpty())
            <div class="text-center py-8 text-gray-500">No messages yet</div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Chart.js loaded:', typeof Chart);
    console.log('dailyVisitorsChart:', document.getElementById('dailyVisitorsChart'));
    console.log('ordersChart:', document.getElementById('ordersChart'));
    
    // Daily Visitors Chart
    const dailyCtx = document.getElementById('dailyVisitorsChart');
    if (dailyCtx) {
        console.log('Creating daily visitors chart...');
        new Chart(dailyCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($stats['dailyVisitorLabels']) !!},
                datasets: [{
                    label: 'Unique Visitors',
                    data: {!! json_encode($stats['dailyVisitors']) !!},
                    borderColor: '#2d5a27',
                    backgroundColor: 'rgba(45, 90, 39, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }

    // Orders Status Chart
    const ordersCtx = document.getElementById('ordersChart');
    if (ordersCtx) {
        console.log('Creating orders chart...');
        new Chart(ordersCtx, {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Confirmed', 'Shipped', 'Delivered', 'Cancelled'],
                datasets: [{
                    data: [
                        {{ $stats['pendingOrders'] }},
                        {{ $stats['confirmedOrders'] }},
                        {{ $stats['shippedOrders'] }},
                        {{ $stats['deliveredOrders'] }},
                        {{ $stats['cancelledOrders'] }}
                    ],
                    backgroundColor: ['#f59e0b', '#3b82f6', '#8b5cf6', '#10b981', '#ef4444']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }

});
</script>
@endsection
