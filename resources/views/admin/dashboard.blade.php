@extends('admin.layouts.main')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
        <p class="text-gray-500">Welcome to your admin panel</p>
    </div>

    <!-- New Stats: Visitors & Sales -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white">
            <p class="text-white/70 text-sm">Total Visitors</p>
            <p class="text-3xl font-bold">{{ number_format($stats['totalVisits']) }}</p>
        </div>
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white">
            <p class="text-white/70 text-sm">Daily Visitors</p>
            <p class="text-3xl font-bold">{{ number_format($stats['dailyVisits']) }}</p>
        </div>
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white">
            <p class="text-white/70 text-sm">Monthly Visitors</p>
            <p class="text-3xl font-bold">{{ number_format($stats['monthlyVisits']) }}</p>
        </div>
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl p-6 text-white">
            <p class="text-white/70 text-sm">Total Bottles Sold</p>
            <p class="text-3xl font-bold">{{ number_format($stats['totalBottlesSold']) }}</p>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="font-bold text-gray-800 mb-4">Daily Visitors (Last 7 Days)</h3>
            <canvas id="dailyVisitorsChart" height="100"></canvas>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="font-bold text-gray-800 mb-4">Orders Status</h3>
            <canvas id="ordersChart" height="100"></canvas>
        </div>
    </div>

    <!-- Existing Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-br from-[#2d5a27] to-[#4a7c42] rounded-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-white/70 text-sm">Total Orders</p>
                    <p class="text-3xl font-bold">{{ $stats['totalOrders'] }}</p>
                </div>
                <i class="fas fa-shopping-cart text-4xl text-white/30"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm">Pending</p>
                    <p class="text-3xl font-bold">{{ $stats['pendingOrders'] }}</p>
                </div>
                <i class="fas fa-clock text-4xl text-white/30"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-[#22c55e] to-green-600 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm">Delivered</p>
                    <p class="text-3xl font-bold">{{ $stats['deliveredOrders'] }}</p>
                </div>
                <i class="fas fa-check-circle text-4xl text-white/30"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-[#1e3d1a] to-[#2d5a27] rounded-xl p-6 text-white">
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
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="font-bold text-gray-800 mb-2">Total Revenue</h3>
            <p class="text-3xl font-bold text-green-600">₨{{ number_format($stats['totalRevenue'], 0) }}</p>
            <p class="text-sm text-gray-500 mt-1">From confirmed orders</p>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-6">
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

        <div class="bg-white rounded-xl shadow-lg p-6">
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
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-[#2d5a27] to-[#4a7c42] px-6 py-4 flex justify-between items-center">
                <h3 class="text-white font-bold">Recent Orders</h3>
                <a href="{{ route('admin.orders.index') }}" class="text-white/80 text-sm hover:text-white">View All</a>
            </div>
            <table class="w-full data-table">
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
                        <td class="px-4 py-3 text-sm">{{ $order->product->name ?? 'N/A' }}</td>
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
                    @if($stats['recentOrders']->isEmpty())
                    <tr><td colspan="3" class="px-4 py-8 text-center text-gray-500">No orders yet</td></tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-[#2d5a27] to-[#4a7c42] px-6 py-4 flex justify-between items-center">
                <h3 class="text-white font-bold">Recent Messages</h3>
                <a href="{{ route('admin.contacts.index') }}" class="text-white/80 text-sm hover:text-white">View All</a>
            </div>
            <table class="w-full data-table">
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
                    @if($stats['recentContacts']->isEmpty())
                    <tr><td colspan="3" class="px-4 py-8 text-center text-gray-500">No messages yet</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Daily Visitors Chart
    const dailyCtx = document.getElementById('dailyVisitorsChart');
    if (dailyCtx) {
        new Chart(dailyCtx, {
            type: 'line',
            data: {
                labels: Object.keys({{ json_encode($stats['dailyVisitors'], JSON_HEX_APOS | JSON_HEX_QUOT) }}),
                datasets: [{
                    label: 'Unique Visitors',
                    data: Object.values({{ json_encode($stats['dailyVisitors'], JSON_HEX_APOS | JSON_HEX_QUOT) }}),
                    borderColor: '#2d5a27',
                    backgroundColor: 'rgba(45, 90, 39, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }

    // Orders Status Chart
    const ordersCtx = document.getElementById('ordersChart');
    if (ordersCtx) {
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
                responsive: true
            }
        });
    }

    // Notification badge/list from previous
    const unreadContacts = {{ $stats['unreadContacts'] ?? 0 }};
    const pendingOrders = {{ $stats['pendingOrders'] ?? 0 }};
    const unreadCount = unreadContacts + pendingOrders;
    const badge = document.getElementById('notificationBadge');
    const list = document.getElementById('notificationList');
    if (unreadCount > 0) {
        badge.textContent = unreadCount;
        badge.classList.remove('hidden');
    }
    let notificationsHtml = '';
    if (pendingOrders > 0) {
        notificationsHtml += '<div class="notification-item p-3 border-b hover:bg-gray-50 cursor-pointer group"><div class="flex items-center space-x-3"><div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center"><i class="fas fa-shopping-cart text-blue-600 text-sm"></i></div><div class="flex-1 min-w-0"><p class="text-sm font-medium text-gray-900 truncate">New pending order</p><p class="text-xs text-gray-500 truncate">' + pendingOrders + ' waiting</p></div><div class="text-xs text-gray-400 group-hover:text-gray-600">•</div></div></div>';
    }
    if (unreadContacts > 0) {
        notificationsHtml += '<div class="notification-item p-3 border-b hover:bg-gray-50 cursor-pointer group"><div class="flex items-center space-x-3"><div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center"><i class="fas fa-envelope text-orange-600 text-sm"></i></div><div class="flex-1 min-w-0"><p class="text-sm font-medium text-gray-900 truncate">New contact messages</p><p class="text-xs text-gray-500 truncate">' + unreadContacts + ' unread</p></div><div class="text-xs text-gray-400 group-hover:text-gray-600">•</div></div></div>';
    }
    if (!notificationsHtml) {
        notificationsHtml = '<div class="text-center py-8 text-gray-500"><i class="fas fa-bell-slash text-2xl mb-2"></i><p>No new notifications</p></div>';
    }
    if (list) {
        list.innerHTML = notificationsHtml;
    }
});
</script>
@endsection
