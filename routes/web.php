<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;

Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/bestseller', function() { 
    $products = \App\Models\Product::where('is_active', true)->get(); 
    $currency = \App\Models\Setting::get('currency', 'PKR');
    $currencySymbol = \App\Models\Setting::get('currency_symbol', '₨');
    return view('bestseller', compact('products', 'currency', 'currencySymbol')); 
})->name('bestseller');
Route::get('/about', function() { return view('about'); })->name('about');
Route::get('/contact', function() { return view('contact'); })->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.send');
Route::get('/link', function () {
    if (!file_exists(public_path('storage'))) {
        app('files')->link(storage_path('app/public'), public_path('storage'));
        return 'Link created!';
    }
    return 'Link already exists';
});
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/admin', function () {
    if (!\Illuminate\Support\Facades\Auth::check()) {
        return redirect()->route('admin.login');
    }
    return redirect()->route('admin.dashboard');
});

Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');

Route::middleware(\App\Http\Middleware\AdminAuthMiddleware::class)->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/products', [ProductController::class, 'adminIndex'])->name('admin.products.index');
    Route::get('/admin/products/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::post('/admin/products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/admin/products/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/admin/products/{product}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/admin/products/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy');

    Route::get('/admin/orders', [OrderController::class, 'adminIndex'])->name('admin.orders.index');
    Route::patch('/admin/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::delete('/admin/orders/{order}', [OrderController::class, 'destroy'])->name('admin.orders.destroy');

    Route::get('/admin/settings', [SettingsController::class, 'index'])->name('admin.settings.index');
    Route::post('/admin/settings', [SettingsController::class, 'update'])->name('admin.settings.update');

    Route::get('/admin/contacts', [ContactController::class, 'adminIndex'])->name('admin.contacts.index');
    Route::get('/admin/contacts/{contact}/mark', [ContactController::class, 'markAsRead'])->name('admin.contacts.mark');
    Route::delete('/admin/contacts/{contact}', [ContactController::class, 'destroy'])->name('admin.contacts.destroy');

    Route::get('/admin/expenses', [ExpenseController::class, 'index'])->name('admin.expenses.index');
    Route::post('/admin/expenses', [ExpenseController::class, 'store'])->name('admin.expenses.store');
    Route::delete('/admin/expenses/{expense}', [ExpenseController::class, 'destroy'])->name('admin.expenses.destroy');
});