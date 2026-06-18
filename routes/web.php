<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Middleware\MaintenanceMode;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\SettingsController;



// ==================== SEMUA RUTE DIBUNGKUS DENGAN MIDDLEWARE MAINTENANCE ====================
Route::middleware(MaintenanceMode::class)->group(function () {

    // ==================== PUBLIC ROUTES ====================
    Route::get('/', [ShipmentController::class, 'index'])->name('home');
    Route::get('/about', fn() => view('about'))->name('about');
    Route::get('/customer-service', fn() => view('customer-service'))->name('customer-service');
    Route::post('/customer-service', [App\Http\Controllers\CustomerServiceController::class, 'send'])
        ->name('customer-service.send')
        ->middleware('throttle:5,10');
    Route::get('/terms', fn() => view('terms'))->name('terms');
    Route::get('/faq', fn() => view('faq'))->name('faq');
    Route::get('/calculator', [ShipmentController::class, 'calculator'])->name('calculator');
    Route::post('/calculate-rate', [ShipmentController::class, 'calculateRate'])->name('calculator.calculate');
    Route::get('/book', [ShipmentController::class, 'book'])->middleware('auth')->name('book');
    Route::post('/shipment', [ShipmentController::class, 'store'])->name('shipment.store');
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.authenticate');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'store'])->name('register.store');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/tracking', [TrackingController::class, 'index'])->name('tracking.index');
    Route::post('/tracking', [TrackingController::class, 'track'])->name('tracking.track');
    Route::get('/test-permission', function () {

        if (auth()->user()->hasPermission('access admin panel')) {
            return 'Anda punya akses admin panel';
        }
        return 'Tidak punya akses';
    })->middleware('auth');

    // ==================== ADMIN ROUTES ====================
    Route::prefix('admin')->middleware(['auth', 'permission:access admin panel'])->group(function () {

        // Rute yang dapat diakses oleh admin, dev, owner
        Route::get('/orders', [OrderController::class, 'index'])->name('orders');
        Route::post('/orders/bulk-delete', [OrderController::class, 'bulkDelete'])->name('orders.bulk-delete');
        Route::post('/orders/update', [OrderController::class, 'update'])->name('orders.update');
        Route::post('/orders/mark-delivered', [OrderController::class, 'markDelivered'])->name('orders.mark-delivered');
        Route::post('/orders/{id}/delete', [OrderController::class, 'destroy'])->name('orders.delete');
        Route::post('/orders/calculate-price', [OrderController::class, 'calculatePrice'])->name('orders.calculate-price');
        Route::post('/orders/available-services', [OrderController::class, 'getAvailableServices'])->name('orders.available-services');

        // Invoices
        Route::get('/invoices', [InvoiceController::class, 'index'])->name('admin.invoices.index');
        Route::post('/invoices/mark-paid/{hashid}', [InvoiceController::class, 'markInvoicePaid'])->name('invoices.mark-paid');
        Route::get('/invoices/delete/{hashid}', [InvoiceController::class, 'deleteInvoice'])->name('invoices.delete');
        Route::get('/create-invoice', [InvoiceController::class, 'createInvoice'])->name('create-invoice');
        Route::get('/invoice-edit/{hashid}', [InvoiceController::class, 'editInvoice'])->name('invoice.edit');
        Route::put('/invoices/update/{hashid}', [InvoiceController::class, 'updateInvoice'])->name('invoice.update');
        Route::post('/invoices/store', [InvoiceController::class, 'storeInvoice'])->name('invoices.store');

        Route::get('/ranking', [AdminController::class, 'ranking'])->name('admin.ranking');

        // Rates (lihat saja boleh semua admin, tetapi edit/delete/reset hanya dev)
        Route::get('/rates', [RateController::class, 'index'])->name('admin.rates');
        Route::post('/rates/update-rate', [RateController::class, 'update'])->name('admin.rates.update');

        // ============================================================
        // LAPORAN & PENGELUARAN — sekarang menggunakan ReportController
        // ============================================================
        Route::get('/reports', [ReportController::class, 'reports'])->name('admin.reports');
        Route::get('/reports/export', [ReportController::class, 'exportReport'])->name('admin.reports.export');

        Route::get('/expenses', [ReportController::class, 'expenses'])->name('admin.expenses');
        Route::post('/expenses/save', [ReportController::class, 'saveExpense'])->name('admin.expenses.save');
        Route::get('/expenses/delete/{id}', [ReportController::class, 'deleteExpense'])->name('admin.expenses.delete');
        Route::get('/expenses/export', [ReportController::class, 'exportExpenses'])->name('admin.expenses.export');

        // ==================== RUTE KHUSUS DEVELOPER (middleware 'dev') ====================
        // Hanya role 'dev' (dan 'owner' jika Anda tambahkan di middleware) yang bisa akses
        Route::middleware(['dev'])->group(function () {
            // Manajemen negara
            Route::post('/rates/add-country', [RateController::class, 'addCountry'])->name('admin.rates.add-country');
            Route::post('/rates/update-country', [RateController::class, 'updateCountry'])->name('admin.rates.update-country');
            Route::post('/rates/delete-country', [RateController::class, 'deleteCountry'])->name('admin.rates.delete-country');
            Route::get('/rates/reset', [RateController::class, 'reset'])->name('admin.rates.reset');

            // Settings (seluruh manajemen setting hanya dev)
            Route::get('/settings', [SettingsController::class, 'index'])->name('admin.settings');
            Route::post('/settings/save', [SettingsController::class, 'save'])->name('admin.settings.save');
            Route::post('/settings/maintenance', [SettingsController::class, 'toggleMaintenance'])->name('admin.maintenance.toggle');
            Route::post('/settings/clear-cache', [SettingsController::class, 'clearCache'])->name('admin.settings.clear-cache');
            Route::post('/settings/reset', [SettingsController::class, 'resetSettings'])->name('admin.settings.reset');

            // Members (seluruh manajemen member hanya dev)
            Route::get('/members', [MemberController::class, 'index'])->name('d-e-v.members');
            Route::post('/members/save', [MemberController::class, 'save'])->name('admin.members.save');
            Route::get('/members/delete/{id}', [MemberController::class, 'delete'])->name('admin.members.delete');
            Route::post('/members/bulk-delete', [MemberController::class, 'bulkDelete'])->name('admin.members.bulk-delete');
            Route::get('/members/edit/{id}', [MemberController::class, 'edit'])->name('admin.members.edit');
        });
    });

    // AJAX endpoint (boleh diakses asal login, tapi pastikan di controller ada pengecekan permission)
    Route::get('/ajax/shipments-by-customer', [InvoiceController::class, 'ajaxShipmentsByCustomer'])->name('ajax.shipments.by.customer');

    // Rute untuk user yang sudah login (customer)
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('my.dashboard');
        Route::delete('/shipment/{id}', [UserDashboardController::class, 'destroyShipment'])->name('shipment.destroy');
        Route::get('/invoices', [UserDashboardController::class, 'invoices'])->name('invoices');
        Route::get('/invoice/{hashid}', [InvoiceController::class, 'show'])->name('invoice.detail');
    });
}); // ── AKHIR DARI GROUP MAINTENANCE MIDDLEWARE ──