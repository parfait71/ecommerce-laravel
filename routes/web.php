<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController;
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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', AdminProductController::class);
    Route::resource('categories', AdminCategoryController::class)->except(['show']);
    Route::resource('users', AdminUserController::class);
    Route::resource('orders', AdminOrderController::class);
});

// 🔒 Espace UTILISATEUR connecté (non-admin)
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard utilisateur
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('orders', OrderController::class);
    
    // Routes pour les factures
    Route::get('/invoice/{order}/generate', [InvoiceController::class, 'generate'])->name('invoice.generate');
    Route::get('/invoice/{order}/download', [InvoiceController::class, 'download'])->name('invoice.download');
    Route::get('/invoice/{order}/view', [InvoiceController::class, 'view'])->name('invoice.view');
});

// Auth routes (login, register, etc.)
require __DIR__.'/auth.php';

Route::middleware(['auth', 'block_admin_orders'])->group(function () {
    // Routes du panier
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    
    Route::get('/checkout', function () {
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

// Paiement Wave
Route::post('/paiement/wave', [\App\Http\Controllers\WavePaymentController::class, 'pay'])->name('paiement.wave');
Route::get('/paiement/wave/success', [\App\Http\Controllers\WavePaymentController::class, 'success'])->name('paiement.wave.success');
Route::get('/paiement/wave/error', [\App\Http\Controllers\WavePaymentController::class, 'error'])->name('paiement.wave.error');

Route::view('/about', 'about')->name('about');
Route::view('/mentions-legales', 'mentions-legales')->name('mentions-legales');
Route::view('/cgv', 'cgv')->name('cgv');
Route::view('/politique-confidentialite', 'politique-confidentialite')->name('politique-confidentialite');

// Route pour servir les images des produits
Route::get('product-image/{filename}', [\App\Http\Controllers\ProductImageController::class, 'show'])->where('filename', '.*');
