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
    <script src="https://cdn.datatabl   es.net/1.13.4/js/dataTables.tailwindcss.min.js"></script>
    <style>
        .green-gradient { background: linear-gradient(135deg, #2d5a27 0%, #4a7c42 100%); }
        
        @media (max-width: 768px) {
            aside { display: none; }
            aside.mobile-open { display: block; position: fixed; z-index: 100; width: 100%; height: 100vh; overflow-y: auto; }
            main.ml-64 { margin-left: 0; }
            .mobile-menu-btn { display: block !important; }
        }
        .mobile-menu-btn { display: none; }
        
        .data-table_wrapper { font-size: 14px; background: white; padding: 15px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); overflow-x: auto; }
        .data-table_wrapper table { width: 100%; }
        .data-table_wrapper thead th { background: linear-gradient(135deg, #2d5a27 0%, #4a7c42 100%); color: white; padding: 14px 12px; text-align: left; font-weight: 500; white-space: nowrap; }
        .data-table_wrapper tbody td { padding: 14px 12px; border-bottom: 1px solid #e5e5e5; white-space: nowrap; }
        .data-table_wrapper tbody tr:hover { background: #f0f9f0; }
        .dataTables_wrapper .dataTables_length { margin-bottom: 10px; }
        .dataTables_wrapper .dataTables_length select { padding: 6px 10px; border: 1px solid #ddd; border-radius: 4px; }
        .dataTables_wrapper .dataTables_filter { margin-bottom: 10px; float: right; }
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
                <!-- Notification Bell -->
                <div class="relative mb-6">
                    <button id="notificationBtn" class="w-full flex items-center space-x-3 p-3 rounded-lg bg-white/10 hover:bg-white/20 transition text-left text-white/90 group">
                        <i class="fas fa-bell text-xl group-hover:animate-pulse"></i>
                        <div class="flex-1">
                            <span>Notifications</span>
                            <span id="notificationBadge" class="ml-2 bg-red-500 text-xs px-2 py-1 rounded-full hidden">0</span>
                        </div>
                        <i class="fas fa-chevron-down text-sm"></i>
                    </button>
                    <div id="notificationDropdown" class="absolute top-full left-0 w-80 bg-white rounded-xl shadow-2xl border mt-2 opacity-0 invisible scale-95 transition-all duration-200 z-50 max-h-96 overflow-y-auto">
                        <div class="p-4 border-b">
                            <h3 class="font-bold text-gray-800 mb-2">Recent Notifications</h3>
                            <button id="markAllRead" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Mark all read</button>
                        </div>
                        <div id="notificationList" class="p-4 max-h-64 overflow-y-auto">
                            <div class="text-center py-8 text-gray-500">
                                <i class="fas fa-bell-slash text-2xl mb-2"></i>
                                <p>No new notifications</p>
                            </div>
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
    $('.data-table').DataTable({
        pageLength: 10,
        order: [[0, 'desc']],
        language: {
            search: "Search:",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_",
            paginate: { first: "First", last: "Last", next: "Next", previous: "Previous" }
        }
    });
    
    // Notification functionality
    const notificationBtn = document.getElementById('notificationBtn');
    const dropdown = document.getElementById('notificationDropdown');
    if (notificationBtn && dropdown) {
        notificationBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            dropdown.classList.toggle('opacity-100');
            dropdown.classList.toggle('invisible');
            dropdown.classList.toggle('scale-100');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!notificationBtn.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('opacity-0', 'invisible', 'scale-95');
            }
        });
        
        // Mark all read
        const markAllRead = document.getElementById('markAllRead');
        if (markAllRead) {
            markAllRead.addEventListener('click', function() {
                document.getElementById('notificationBadge').classList.add('hidden');
                document.getElementById('notificationList').innerHTML = '<div class="text-center py-8 text-green-600"><i class="fas fa-check-circle text-2xl mb-2"></i><p>All notifications marked as read</p></div>';
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
