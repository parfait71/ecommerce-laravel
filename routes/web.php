<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserAnalyticsController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

/*
|--------------------------------------------------------------------------
| Web Routes - EazyStore
|--------------------------------------------------------------------------
*/

// 🔹 Accueil public
Route::get('/', [HomeController::class, 'index'])->name('home');

// 🔹 Catalogue
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/catalogue', [ProductController::class, 'index'])->name('catalogue');
Route::resource('products', ProductController::class)->only(['show']);

// 🔐 Espace ADMIN
Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', AdminProductController::class);
    Route::resource('categories', AdminCategoryController::class)->except(['show']);
    Route::resource('users', AdminUserController::class);
    Route::resource('orders', AdminOrderController::class);
    
    // Routes pour les analytics
    Route::get('/analytics', [\App\Http\Controllers\Admin\AnalyticsController::class, 'dashboard'])->name('analytics.dashboard');
    Route::get('/analytics/export/pdf', [\App\Http\Controllers\Admin\AnalyticsController::class, 'exportPdf'])->name('analytics.export.pdf');
    Route::get('/analytics/export/excel', [\App\Http\Controllers\Admin\AnalyticsController::class, 'exportExcel'])->name('analytics.export.excel');
    
    // Routes pour les produits (images)
    Route::get('/products/{product}/images', [\App\Http\Controllers\Admin\ProductController::class, 'getImages'])->name('products.images');
    Route::delete('/products/{product}/images/{image}', [\App\Http\Controllers\Admin\ProductController::class, 'deleteProductImage'])->name('products.delete-image');
    
    // Routes pour les commandes
    Route::post('/orders/{order}/mark-as-paid', [\App\Http\Controllers\OrderController::class, 'markAsPaid'])->name('orders.mark-as-paid');
});

// 🔒 Espace UTILISATEUR connecté (non-admin)
Route::middleware(['auth', 'verified'])->group(function () {
    // 👇 Supprimé : la route 'dashboard' du user, car elle n'est pas utile
    // Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('orders', OrderController::class);
    
    // Routes pour les factures
    Route::get('/invoice/{order}/generate', [InvoiceController::class, 'generate'])->name('invoice.generate');
    Route::get('/invoice/{order}/download', [InvoiceController::class, 'download'])->name('invoice.download');
    Route::get('/invoice/{order}/view', [InvoiceController::class, 'view'])->name('invoice.view');
    
    // Routes pour les analytics utilisateur
    Route::get('/analytics', [UserAnalyticsController::class, 'dashboard'])->name('analytics.dashboard');
    Route::get('/analytics/export', [UserAnalyticsController::class, 'exportData'])->name('analytics.export');
    Route::get('/analytics/export-page', function() {
        return view('user.analytics.export');
    })->name('analytics.export-page');
});

// Auth routes (login, register, etc.)
require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {
    // Routes du panier
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    
    Route::get('/checkout', function () {
        // Empêcher les admins d'accéder au checkout
        if (auth()->user()->is_admin) {
            return redirect()->route('home')->with('error', 'Les administrateurs ne peuvent pas passer de commandes. Cette fonctionnalité est réservée aux clients.');
        }
        
        // Ici, on suppose que le panier est stocké en session ou transmis à la vue
        $cart = session('cart', []);
        return view('checkout', compact('cart'));
    })->name('checkout');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});

Route::post('/contact', [\App\Http\Controllers\ContactController::class, 'send'])->name('contact.send');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/faq', function () {
    return view('faq');
})->name('faq');

Route::get('/promotions', function () {
    return view('promotions');
})->name('promotions');

Route::get('/paiement', function () {
    return view('paiement');
})->name('paiement');

// Routes Wave Payment
Route::middleware(['auth'])->group(function () {
    Route::get('/wave/payment/{order}', [\App\Http\Controllers\WavePaymentController::class, 'showPaymentPage'])->name('wave.payment');
    Route::post('/wave/payment/initiate', [\App\Http\Controllers\WavePaymentController::class, 'initiatePayment'])->name('wave.initiate');
    Route::post('/wave/payment/callback', [\App\Http\Controllers\WavePaymentController::class, 'callback'])->name('wave.callback');
    Route::get('/wave/payment/status', [\App\Http\Controllers\WavePaymentController::class, 'checkStatus'])->name('wave.status');
});
