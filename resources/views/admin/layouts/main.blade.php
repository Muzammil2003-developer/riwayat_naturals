<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Riwayat Naturals</title>
    <script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.tailwindcss.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.tailwindcss.min.js"></script>
    <style>
        .green-gradient { background: linear-gradient(135deg, #2d5a27 0%, #4a7c42 100%); }
        
        @media (max-width: 768px) {
            aside { display: none; }
            aside.mobile-open { display: block; position: fixed; z-index: 100; width: 100%; height: 100vh; overflow-y: auto; }
            main.ml-64 { margin-left: 0; }
            .mobile-menu-btn { display: block !important; }
        }
        .mobile-menu-btn { display: none; }
        
        .data-table_wrapper { 
            @apply bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden font-sans;
            font-size: 14px;
        }
        .data-table_wrapper .dataTables_wrapper { padding: 1.5rem; }
        .data-table_wrapper thead th { 
            @apply bg-gradient-to-r from-[#2d5a27] to-[#1e3d1a] text-white px-6 py-4 text-left font-semibold text-sm uppercase tracking-wider sticky top-0 z-10 shadow-sm;
            white-space: nowrap;
        }
        .data-table_wrapper tbody td { 
            @apply px-6 py-4 border-b border-gray-100 align-middle;
        }
        .data-table_wrapper tbody tr { @apply transition-colors hover:bg-emerald-50/50; }
        .data-table_wrapper tbody tr:nth-child(even) { @apply bg-gray-50/50; }
        .dataTables_wrapper .dataTables_filter input, .dataTables_wrapper .dataTables_length select { 
            @apply px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button { 
            @apply px-4 py-2 mx-1 border border-gray-300 rounded-lg bg-white hover:bg-emerald-500 hover:text-white hover:border-emerald-500 transition-all font-medium text-sm;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current { 
            @apply bg-emerald-600 text-white border-emerald-600 shadow-md;
        }
        .dataTables_wrapper .dataTables_length { margin-bottom: 8px; }
        .dataTables_wrapper .dataTables_length select { padding: 6px 10px; border: 1px solid #ddd; border-radius: 4px; }
        .dataTables_wrapper .dataTables_filter { margin-bottom: 8px; float: right; }
        .dataTables_wrapper .dataTables_filter input { padding: 6px 10px; border: 1px solid #ddd; border-radius: 4px; }
        .dataTables_wrapper .dataTables_info { padding: 10px 0; color: #666; float: left; }
        .dataTables_wrapper .dataTables_paginate { padding: 10px 0; }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 6px 12px; margin: 0 2px; border: 1px solid #ddd; border-radius: 4px; cursor: pointer;
            background: #2d5a27; color: white !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover { background: #1e3d1a; }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #1e3d1a; font-weight: bold;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            background: #ccc; cursor: not-allowed;
        }
        @media (max-width: 768px) {
            .data-table_wrapper thead th,
            .data-table_wrapper tbody td { padding: 8px 8px; font-size: 12px; }
            .dataTables_wrapper .dataTables_filter,
            .dataTables_wrapper .dataTables_length,
            .dataTables_wrapper .dataTables_info,
            .dataTables_wrapper .dataTables_paginate { float: none !important; text-align: left; }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen" style="overflow-x: hidden;">
    @auth
    <div class="flex">
        <aside class="w-64 bg-gradient-to-b from-[#2d5a27] to-[#4a7c42] min-h-screen fixed">
            <div class="p-6">
                <a href="{{ route('home') }}" class="flex items-center space-x-2 text-white mb-8">
                    <i class="fas fa-leaf text-2xl"></i>
                    <span class="text-xl font-bold">Riwayat Admin</span>
                </a>
                @php
                    $lastSeenPendingOrderId = (int) \App\Models\Setting::get('admin_seen_pending_order_id', '0');
                    $lastSeenContactId = (int) \App\Models\Setting::get('admin_seen_contact_id', '0');
                    $pendingOrdersCount = \App\Models\Order::where('status', 'pending')->where('id', '>', $lastSeenPendingOrderId)->count();
                    $unreadContactsCount = \App\Models\Contact::where('is_read', false)->where('id', '>', $lastSeenContactId)->count();
                    $adminUnreadCount = $pendingOrdersCount + $unreadContactsCount;
                @endphp
                <!-- Notification Bell -->
                <div class="relative mb-6">
                    <button id="notificationBtn" class="w-full flex items-center space-x-3 p-3 rounded-lg bg-white/10 hover:bg-white/20 transition text-left text-white/90 group">
                        <i class="fas fa-bell text-xl group-hover:animate-pulse"></i>
                        <div class="flex-1">
                            <span>Notifications</span>
                            <span id="notificationBadge" class="ml-2 bg-red-500 text-xs px-2 py-1 rounded-full {{ $adminUnreadCount > 0 ? '' : 'hidden' }}">{{ $adminUnreadCount }}</span>
                        </div>
                        <i class="fas fa-chevron-down text-sm"></i>
                    </button>
                    <div id="notificationDropdown" class="hidden absolute top-full left-0 w-80 bg-white rounded-xl shadow-2xl border mt-2 z-50 max-h-96 overflow-y-auto">
                        <div class="p-4 border-b">
                            <h3 class="font-bold text-gray-800 mb-2">Recent Notifications</h3>
                            <button id="markAllRead" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Mark all read</button>
                        </div>
                        <div id="notificationList" class="p-4 max-h-64 overflow-y-auto">
                            @if($pendingOrdersCount > 0)
                                <a href="{{ route('admin.orders.index') }}" class="notification-item block p-3 border-b hover:bg-gray-50 cursor-pointer group">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-shopping-cart text-blue-600 text-sm"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">New pending orders</p>
                                            <p class="text-xs text-gray-500 truncate">{{ $pendingOrdersCount }} waiting for review</p>
                                        </div>
                                        <div class="text-xs text-gray-400 group-hover:text-gray-600">&#8226;</div>
                                    </div>
                                </a>
                            @endif

                            @if($unreadContactsCount > 0)
                                <a href="{{ route('admin.contacts.index') }}" class="notification-item block p-3 border-b hover:bg-gray-50 cursor-pointer group">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-envelope text-orange-600 text-sm"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">New contact messages</p>
                                            <p class="text-xs text-gray-500 truncate">{{ $unreadContactsCount }} unread messages</p>
                                        </div>
                                        <div class="text-xs text-gray-400 group-hover:text-gray-600">&#8226;</div>
                                    </div>
                                </a>
                            @endif

                            @if($adminUnreadCount === 0)
                                <div class="text-center py-8 text-gray-500">
                                    <i class="fas fa-bell-slash text-2xl mb-2"></i>
                                    <p>No new notifications</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <nav class="space-y-2">
                    <a href="{{ route('admin.dashboard') }}" class="block py-3 px-4 rounded-lg text-white/80 hover:bg-white/20 transition {{ request()->routeIs('admin.dashboard') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="block py-3 px-4 rounded-lg text-white/80 hover:bg-white/20 transition {{ request()->routeIs('admin.products.*') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-box mr-2"></i> Products
                    </a>
                    <a href="{{ route('admin.packages.index') }}" class="block py-3 px-4 rounded-lg text-white/80 hover:bg-white/20 transition {{ request()->routeIs('admin.packages.*') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-gift mr-2"></i> Packages
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="block py-3 px-4 rounded-lg text-white/80 hover:bg-white/20 transition {{ request()->routeIs('admin.orders.*') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-shopping-cart mr-2"></i> Orders
                    </a>
                    <a href="{{ route('admin.contacts.index') }}" class="block py-3 px-4 rounded-lg text-white/80 hover:bg-white/20 transition {{ request()->routeIs('admin.contacts.*') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-envelope mr-2"></i> Contacts
                    </a>
                    <a href="{{ route('admin.expenses.index') }}" class="block py-3 px-4 rounded-lg text-white/80 hover:bg-white/20 transition {{ request()->routeIs('admin.expenses.*') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-chart-line mr-2"></i> Expenses
                    </a>
                    <a href="{{ route('admin.settings.index') }}" class="block py-3 px-4 rounded-lg text-white/80 hover:bg-white/20 transition {{ request()->routeIs('admin.settings.*') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-cog mr-2"></i> Settings
                    </a>
                    <form method="POST" action="{{ route('admin.logout') }}" class="block">
                        @csrf
                        <button type="submit" class="w-full text-left py-3 px-4 rounded-lg text-white/80 hover:bg-white/20 transition">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </button>
                    </form>
                </nav>
            </div>
        </aside>

        <!-- Mobile Menu Button -->
        <button onclick="toggleMobileMenu()" class="mobile-menu-btn fixed top-4 left-4 z-50 w-10 h-10 green-gradient rounded-lg text-white p-2">
            <i class="fas fa-bars"></i>
        </button>

        <main class="ml-64 flex-1 p-8">
            @yield('content')
        </main>
    </div>
    @else
    @yield('content')
    @endauth

<script>
$(document).ready(function() {
    $('.data-table').each(function() {
        if ($(this).find('tbody tr').length > 0) {
            $(this).DataTable({
                responsive: true,
                pageLength: 25,
                order: [[0, 'desc']],
                autoWidth: false,
                dom: '<"top"lf>rt<"bottom"ip><"clear">',
                language: {
                    search: '<i class="fas fa-search mr-1"></i> Search:',
                    lengthMenu: '<i class="fas fa-list mr-1"></i> _MENU_ per page',
                    info: '<i class="fas fa-info-circle mr-1"></i> _START_ to _END_ of _TOTAL_',
                    paginate: { 
                        first: '<i class="fas fa-angle-double-left"></i>', 
                        last: '<i class="fas fa-angle-double-right"></i>', 
                        next: '<i class="fas fa-angle-right"></i>', 
                        previous: '<i class="fas fa-angle-left"></i>' 
                    },
                    emptyTable: '<div class="text-center py-12"><i class="fas fa-inbox text-4xl text-gray-300 mb-4 block"></i><h3 class="text-xl font-semibold text-gray-500 mb-2">No data available</h3><p class="text-gray-400">Get started by adding your first record.</p></div>',
                    processing: '<div class="flex items-center justify-center py-4"><i class="fas fa-spinner fa-spin mr-2"></i>Loading...</div>'
                },
                drawCallback: function() {
                    $('tbody tr').hover(function() { $(this).addClass('hover:bg-gray-50'); }, function() { $(this).removeClass('hover:bg-gray-50'); });
                }
            });
        }
    });

    // Mark all read - defined before use
    const markSeenOnServer = async () => {
        try {
            await fetch('{{ route('admin.notifications.seen') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({})
            });
        } catch (e) {}
    };

    // Notification functionality
    const notificationBtn = document.getElementById('notificationBtn');
    const dropdown = document.getElementById('notificationDropdown');
    if (notificationBtn && dropdown) {
        const openDropdown = () => {
            dropdown.classList.remove('hidden');
            const badge = document.getElementById('notificationBadge');
            if (badge) {
                badge.classList.add('hidden');
                badge.textContent = '0';
            }
            markSeenOnServer();
        };

        const closeDropdown = () => {
            dropdown.classList.add('hidden');
        };

        const isOpen = () => !dropdown.classList.contains('hidden');

        notificationBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            if (isOpen()) {
                closeDropdown();
            } else {
                openDropdown();
            }
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!notificationBtn.contains(e.target) && !dropdown.contains(e.target)) {
                closeDropdown();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDropdown();
            }
        });
        
        // Mark all read
        const markAllRead = document.getElementById('markAllRead');
        const markSeenOnServer = async () => {
            try {
                await fetch('{{ route('admin.notifications.seen') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({})
                });
            } catch (error) {
                // Silent fail; UI still works without blocking.
            }
        };

        if (markAllRead) {
            markAllRead.addEventListener('click', function(e) {
                e.preventDefault();
                markSeenOnServer();
                const badge = document.getElementById('notificationBadge');
                const list = document.getElementById('notificationList');
                if (badge) {
                    badge.classList.add('hidden');
                    badge.textContent = '0';
                }
                if (list) {
                    list.innerHTML = '<div class="text-center py-8 text-green-600"><i class="fas fa-check-circle text-2xl mb-2"></i><p>All notifications marked as read</p></div>';
                }
            });
        }
}
});

// Mobile menu toggle
function toggleMobileMenu() {
    const aside = document.querySelector('aside');
    aside.classList.toggle('mobile-open');
}
</script>
 </body>
</html>
