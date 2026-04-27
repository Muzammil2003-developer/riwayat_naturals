<?php

namespace App\Http\Controllers;

use App\Mail\NewOrderNotification;
use App\Models\Order;
use App\Models\Setting;
use App\Models\Product;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => 'nullable|exists:products,id|required_without:package_id',
            'package_id' => 'nullable|exists:packages,id|required_without:product_id',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $productId = $validated['product_id'] ?? null;
        $packageId = $validated['package_id'] ?? null;

        if ($productId) {
            $product = Product::findOrFail($productId);
            $validated['total_price'] = $product->price * $validated['quantity'];
            $validated['package_id'] = null;
        } else {
            $package = Package::findOrFail($packageId);
            $validated['total_price'] = $package->discount_price * $validated['quantity'];
            $validated['product_id'] = null;
        }

        $order = Order::create($validated);
        $order->load(['product', 'package']);

        $adminOrderEmail = Setting::get('admin_order_email') ?: Setting::get('email');
        if ($adminOrderEmail) {
            try {
                Mail::to($adminOrderEmail)->send(new NewOrderNotification($order));
            } catch (\Throwable $exception) {
                Log::error('Failed to send new order email notification.', [
                    'order_id' => $order->id,
                    'recipient' => $adminOrderEmail,
                    'error' => $exception->getMessage(),
                ]);
            }
        }

        return redirect()->route('home')->with('success', 'Order placed successfully! We will contact you soon.');
    }

    public function adminIndex(): View
    {
        $orders = Order::with(['product', 'package'])->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse|JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,confirmed,shipped,delivered,cancelled',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
            }
            return redirect()->back()->withErrors($validator);
        }

        $order->update(['status' => $request->status]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Order status updated!']);
        }

        return redirect()->route('admin.orders.index')->with('success', 'Order status updated!');
    }

    public function show(Request $request, Order $order): JsonResponse
    {
        $order->load(['product', 'package']);
        
        return response()->json([
            'id' => $order->id,
            'customer_name' => $order->customer_name,
            'customer_phone' => $order->customer_phone,
            'customer_address' => $order->customer_address,
            'quantity' => $order->quantity,
            'total_price' => $order->total_price,
            'status' => $order->status,
            'created_at' => $order->created_at->toIso8601String(),
            'product' => $order->product ? [
                'name' => $order->product->name
            ] : null,
            'package' => $order->package ? [
                'name' => $order->package->name
            ] : null,
        ]);
    }

    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully!');
    }
}
