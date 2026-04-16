<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Contact;
use App\Models\Visit;
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
                ->pluck('count', 'date')
                ->toArray(),
        ];
        return view('admin.dashboard', compact('stats'));
    }
}

