<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class OrderController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $validated['total_price'] = $product->price * $validated['quantity'];

        Order::create($validated);

        return redirect()->route('home')->with('success', 'Order placed successfully! We will contact you soon.');
    }

    public function adminIndex(): View
    {
        $orders = Order::with('product')->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,shipped,delivered,cancelled',
        ]);

        $order->update($validated);

        return redirect()->route('admin.orders.index')->with('success', 'Order status updated!');
    }

    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully!');
    }
}
