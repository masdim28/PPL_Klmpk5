<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController; 
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController; 
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 1. HALAMAN UTAMA (PUBLIC)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [HomeController::class, 'products'])->name('products.index');
Route::get('/products/{id}', [HomeController::class, 'detail'])->name('products.detail');
Route::get('/category/{slug}', [HomeController::class, 'category'])->name('category.show');

/*
|--------------------------------------------------------------------------
| 2. DASHBOARD USER & PROFILE (AUTH)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profil Pengguna
    Route::get('/profile', function () {
        return view('profile'); 
    })->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Keranjang Belanja
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');

    // Proses Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index'); 
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

    // Daftar Pesanan Pelanggan
    Route::get('/orders', function() {
        return "Halaman Daftar Pesanan User"; 
    })->name('orders.index');
});


/*
|--------------------------------------------------------------------------
| 3. PANEL ADMIN (AUTH + ADMIN ROLE)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Manajemen Produk (CRUD)
    Route::resource('products', ProductController::class);

    // --- MANAJEMEN PESANAN & TRANSAKSI ---
    
    // Menu 1: Transaksi (Status Pending)
    Route::get('/transaksi', [OrderController::class, 'transaksi'])->name('orders.transaksi');
    Route::post('/transaksi/{id}/konfirmasi', [OrderController::class, 'konfirmasiPembayaran'])->name('orders.konfirmasi');
    // TAMBAHAN: Rute Pembatalan Pesanan
    Route::delete('/transaksi/{id}/batal', [OrderController::class, 'batalkanPesanan'])->name('orders.batal');
    
    // Menu 2: Pesanan (Status Paid/Proses)
    Route::get('/pesanan', [OrderController::class, 'pesanan'])->name('orders.pesanan');
    Route::post('/pesanan/{id}/resi', [OrderController::class, 'updateResi'])->name('orders.resi');
    
    // Menu 3: Selesai (Status Completed)
    Route::get('/pesanan-selesai', [OrderController::class, 'selesai'])->name('orders.selesai');

    // Manajemen User
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
});

require __DIR__.'/auth.php';