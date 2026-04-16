<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BestsellerController extends Controller
{
    public function index(): View
    {
        $products = Product::where('is_active', true)
            ->withCount(['orders' => function ($query) {
                $query->where('status', '!=', 'cancelled');
            }])
            ->withSum('orders', 'quantity', function ($query) {
                $query->where('status', '!=', 'cancelled');
            })
            ->orderByDesc('orders_sum_quantity', 'desc')
            ->orderByDesc('orders_count', 'desc')
            ->limit(8)
            ->get();

        // Fallback: if no sales data, order by recent active
        if ($products->where('orders_sum_quantity', '>', 0)->isEmpty()) {
            $products = Product::where('is_active', true)
                ->orderByDesc('created_at')
                ->limit(8)
                ->get();
        }

        $currency = Setting::get('currency', 'PKR');
        $currencySymbol = Setting::get('currency_symbol', '₨');

        return view('bestseller', compact('products', 'currency', 'currencySymbol'));
    }
}

