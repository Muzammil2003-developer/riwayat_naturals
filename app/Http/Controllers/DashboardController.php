<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Contact;
use App\Models\Setting;
use App\Models\Visit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'totalOrders' => Order::count(),
            'pendingOrders' => Order::where('status', 'pending')->count(),
            'confirmedOrders' => Order::where('status', 'confirmed')->count(),
            'shippedOrders' => Order::where('status', 'shipped')->count(),
            'deliveredOrders' => Order::where('status', 'delivered')->count(),
            'cancelledOrders' => Order::where('status', 'cancelled')->count(),
            'totalProducts' => Product::count(),
            'activeProducts' => Product::where('is_active', true)->count(),
            'totalContacts' => Contact::count(),
            'unreadContacts' => Contact::where('is_read', false)->count(),
            'totalRevenue' => Order::where('status', '!=', 'cancelled')->sum('total_price'),
            'recentOrders' => Order::with('product')->latest()->take(10)->get(),
            'recentContacts' => Contact::latest()->take(5)->get(),
            'totalBottlesSold' => Order::sum('quantity'),
            'totalVisits' => Visit::count(),
            'dailyVisits' => Visit::where('created_at', '>=', now()->subDay())->count(),
            'monthlyVisits' => Visit::where('created_at', '>=', now()->subDays(30))->count(),
            'dailyVisitors' => Visit::selectRaw('DATE(created_at) as date, COUNT(DISTINCT ip_address) as count')
                ->where('created_at', '>=', now()->subDays(7))
                ->groupBy('date')
                ->orderBy('date')
                ->pluck('count')
                ->toArray(),
            'dailyVisitorLabels' => collect(range(6, 0))->map(fn($i) => now()->subDays($i)->format('M d'))->toArray(),
        ];
        return view('admin.dashboard', compact('stats'));
    }

    public function markNotificationsSeen(Request $request): JsonResponse
    {
        $latestPendingOrderId = (int) (Order::where('status', 'pending')->max('id') ?? 0);
        $latestUnreadContactId = (int) (Contact::where('is_read', false)->max('id') ?? 0);

        Setting::set('admin_seen_pending_order_id', (string) $latestPendingOrderId);
        Setting::set('admin_seen_contact_id', (string) $latestUnreadContactId);

        return response()->json([
            'success' => true,
            'seen_pending_order_id' => $latestPendingOrderId,
            'seen_contact_id' => $latestUnreadContactId,
        ]);
    }
}
