<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        
        .dataTables_wrapper {
            padding: 1.25rem;
            font-size: 14px;
        }
        table.dataTable {
            border-collapse: separate !important;
            border-spacing: 0;
            width: 100% !important;
        }
        table.dataTable thead th {
            background: linear-gradient(135deg, #2d5a27 0%, #1e3d1a 100%);
            color: #fff !important;
            font-size: 12px;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            border-bottom: none !important;
            padding: 14px 16px !important;
            white-space: nowrap;
        }
        table.dataTable tbody td {
            padding: 14px 16px !important;
            border-bottom: 1px solid #eef2f7 !important;
            vertical-align: middle;
        }
        table.dataTable tbody tr {
            transition: background-color 220ms ease;
        }
        table.dataTable tbody tr:hover {
            background: #f3faf6 !important;
        }
        .dt-toolbar {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 14px;
        }
        .dt-toolbar-left,
        .dt-toolbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }
        .dt-report-actions {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .dt-report-btn {
            border: 1px solid #d1d5db;
            background: #fff;
            color: #1f2937;
            border-radius: 10px;
            padding: 7px 12px;
            font-size: 12px;
            font-weight: 600;
            line-height: 1.2;
            transition: all 180ms ease;
        }
        .dt-report-btn:hover {
            border-color: #2d5a27;
            color: #2d5a27;
            background: #f3faf6;
        }
        .dataTables_wrapper .dataTables_length label,
        .dataTables_wrapper .dataTables_filter label,
        .dataTables_wrapper .dataTables_info {
            color: #4b5563;
            font-size: 14px;
        }
        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #d1d5db;
            border-radius: 10px;
            padding: 7px 10px;
            background: #fff;
            min-height: 38px;
        }
        .dataTables_wrapper .dataTables_filter input:focus,
        .dataTables_wrapper .dataTables_length select:focus {
            outline: none;
            border-color: #2d5a27;
            box-shadow: 0 0 0 3px rgba(45, 90, 39, 0.15);
        }
        .dt-footer {
            margin-top: 14px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }
        .dataTables_wrapper .dataTables_paginate {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding-top: 0;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            margin: 0 !important;
            border: 1px solid #d1d5db !important;
            border-radius: 10px !important;
            background: #fff !important;
            color: #1f2937 !important;
            padding: 6px 11px !important;
            min-width: 36px;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #f3faf6 !important;
            border-color: #2d5a27 !important;
            color: #2d5a27 !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #1f5a2e !important;
            border-color: #1f5a2e !important;
            color: #fff !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            opacity: 0.45;
            cursor: not-allowed !important;
        }
        @media (max-width: 768px) {
            .dataTables_wrapper {
                padding: 0.75rem;
            }
            table.dataTable thead th,
            table.dataTable tbody td {
                padding: 10px !important;
                font-size: 12px;
            }
            .dt-toolbar,
            .dt-footer {
                flex-direction: column;
                align-items: flex-start;
            }
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
    const csvSafe = (value) => {
        const clean = String(value ?? '').replace(/\s+/g, ' ').trim();
        return `"${clean.replace(/"/g, '""')}"`;
    };

    const textFromHtml = (htmlOrText) => {
        const temp = document.createElement('div');
        temp.innerHTML = htmlOrText ?? '';
        return (temp.textContent || temp.innerText || '').replace(/\s+/g, ' ').trim();
    };

    const getReportFileName = () => {
        const pageHeading = document.querySelector('h1');
        const heading = pageHeading ? pageHeading.textContent.trim().toLowerCase().replace(/\s+/g, '-') : 'report';
        const now = new Date();
        const y = now.getFullYear();
        const m = String(now.getMonth() + 1).padStart(2, '0');
        const d = String(now.getDate()).padStart(2, '0');
        return `${heading}-${y}${m}${d}`;
    };

    const extractRowsForExport = (tableElement, dt) => {
        const headerCells = Array.from(tableElement.querySelectorAll('thead th'));
        const includedIndexes = [];
        const headerLabels = [];

        headerCells.forEach((th, index) => {
            const label = (th.textContent || '').replace(/\s+/g, ' ').trim();
            if (label.toLowerCase() !== 'actions') {
                includedIndexes.push(index);
                headerLabels.push(label);
            }
        });

        const rows = [];
        dt.rows({ search: 'applied', order: 'applied' }).every(function () {
            const rowNode = this.node();
            const cells = rowNode ? Array.from(rowNode.querySelectorAll('td')) : [];
            const rowData = includedIndexes.map((idx) => {
                const cell = cells[idx];
                return cell ? (cell.textContent || '').replace(/\s+/g, ' ').trim() : '';
            });
            rows.push(rowData);
        });

        return { headerLabels, rows };
    };

    const downloadCsvReport = (tableElement, dt) => {
        const { headerLabels, rows } = extractRowsForExport(tableElement, dt);
        const csvLines = [
            headerLabels.map(csvSafe).join(','),
            ...rows.map((row) => row.map(csvSafe).join(','))
        ];
        const blob = new Blob([csvLines.join('\n')], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = `${getReportFileName()}.csv`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    };

    const printReport = (tableElement, dt) => {
        const { headerLabels, rows } = extractRowsForExport(tableElement, dt);
        const printWindow = window.open('', '_blank', 'width=1100,height=700');
        if (!printWindow) return;

        const headerHtml = headerLabels.map((h) => `<th>${h}</th>`).join('');
        const bodyHtml = rows.map((row) => `<tr>${row.map((cell) => `<td>${cell || '-'}</td>`).join('')}</tr>`).join('');

        printWindow.document.write(`
            <html>
                <head>
                    <title>Report</title>
                    <style>
                        body { font-family: Arial, sans-serif; padding: 24px; color: #111827; }
                        h2 { margin: 0 0 8px; }
                        p { margin: 0 0 16px; color: #4b5563; font-size: 13px; }
                        table { width: 100%; border-collapse: collapse; }
                        th, td { border: 1px solid #d1d5db; padding: 10px; text-align: left; font-size: 13px; }
                        th { background: #eef5ef; }
                    </style>
                </head>
                <body>
                    <h2>${(document.querySelector('h1')?.textContent || 'Report').trim()}</h2>
                    <p>Generated on ${new Date().toLocaleString()}</p>
                    <table>
                        <thead><tr>${headerHtml}</tr></thead>
                        <tbody>${bodyHtml || '<tr><td colspan="' + headerLabels.length + '">No records</td></tr>'}</tbody>
                    </table>
                </body>
            </html>
        `);

        printWindow.document.close();
        printWindow.focus();
        printWindow.print();
    };

    const mountReportActions = (tableElement, dt) => {
        const wrapper = $(tableElement).closest('.dataTables_wrapper');
        if (!wrapper.length || wrapper.find('.dt-report-actions').length) return;

        const csvBtn = $('<button type="button" class="dt-report-btn"><i class="fas fa-file-csv mr-1"></i>Download CSV</button>');
        const printBtn = $('<button type="button" class="dt-report-btn"><i class="fas fa-print mr-1"></i>Print</button>');
        const group = $('<div class="dt-report-actions"></div>').append(csvBtn, printBtn);

        wrapper.find('.dt-toolbar-left').append(group);

        csvBtn.on('click', () => downloadCsvReport(tableElement, dt));
        printBtn.on('click', () => printReport(tableElement, dt));
    };

    $('.data-table').each(function() {
        const dt = $(this).DataTable({
            responsive: true,
            pageLength: 25,
            order: [[0, 'desc']],
            autoWidth: false,
            dom: '<"dt-toolbar"<"dt-toolbar-left"l><"dt-toolbar-right"f>>rt<"dt-footer"ip>',
            columnDefs: [
                { orderable: false, targets: -1 }
            ],
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
        mountReportActions(this, dt);
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
