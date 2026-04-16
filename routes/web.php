<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\BestsellerController;

function canRunMaintenanceCommand(): bool
{
    if (auth()->check() && auth()->user()->is_admin) {
        return true;
    }

    $token = request()->query('token');
    $expectedToken = env('MAINTENANCE_TOKEN');

    return !empty($expectedToken) && hash_equals($expectedToken, (string) $token);
}

Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/bestseller', [BestsellerController::class, 'index'])->name('bestseller');
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

Route::get('/migrate', function () {
    if (!canRunMaintenanceCommand()) {
        return 'Unauthorized';
    }
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        return 'Migration completed: ' . \Illuminate\Support\Facades\Artisan::output();
    } catch (\Exception $e) {
        return 'Migration failed: ' . $e->getMessage();
    }
});

Route::get('/seed', function () {
    if (!canRunMaintenanceCommand()) {
        return 'Unauthorized';
    }
    try {
        \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
        return 'Seeding completed: ' . \Illuminate\Support\Facades\Artisan::output();
    } catch (\Exception $e) {
        return 'Seeding failed: ' . $e->getMessage();
    }
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
    Route::post('/admin/notifications/seen', [DashboardController::class, 'markNotificationsSeen'])->name('admin.notifications.seen');
    Route::get('/admin/products', [ProductController::class, 'adminIndex'])->name('admin.products.index');
    Route::get('/admin/products/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::post('/admin/products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/admin/products/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/admin/products/{product}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/admin/products/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
    Route::patch('/admin/products/{product}/toggle', [ProductController::class, 'toggleActive'])->name('admin.products.toggle');

    Route::get('/admin/packages', [PackageController::class, 'adminIndex'])->name('admin.packages.index');
    Route::get('/admin/packages/create', [PackageController::class, 'create'])->name('admin.packages.create');
    Route::post('/admin/packages', [PackageController::class, 'store'])->name('admin.packages.store');
    Route::get('/admin/packages/{package}/edit', [PackageController::class, 'edit'])->name('admin.packages.edit');
    Route::put('/admin/packages/{package}', [PackageController::class, 'update'])->name('admin.packages.update');
    Route::delete('/admin/packages/{package}', [PackageController::class, 'destroy'])->name('admin.packages.destroy');
    Route::patch('/admin/packages/{package}/toggle', [PackageController::class, 'toggleActive'])->name('admin.packages.toggle');

    Route::get('/admin/orders', [OrderController::class, 'adminIndex'])->name('admin.orders.index');
    Route::get('/admin/orders/{order}', [OrderController::class, 'show'])->name('admin.orders.show');
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
