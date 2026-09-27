<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileTransactionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\LegalPageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CreateCustomController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Product Routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

// Category Routes
Route::get('/collections', [CategoryController::class, 'index'])->name('collections.index');
Route::get('/collections/{slug}', [CategoryController::class, 'show'])->name('collections.show');

// Design Routes disabled/hidden
Route::redirect('/designs', '/', 302);
Route::redirect('/designs/{slug}', '/', 302);
Route::match(['get', 'post'], '/designs/inquiry', fn () => abort(404));

// Payment Routes
Route::post('/payment/checkout', [PaymentController::class, 'checkout'])->name('payment.checkout')->middleware('auth');
Route::post('/payment/notification', [PaymentController::class, 'notification'])->name('payment.notification');
Route::get('/payment/status/{orderId}', [PaymentController::class, 'status'])->name('payment.status')->middleware('auth');
Route::post('/payment/sync-status', [PaymentController::class, 'syncStatus'])->name('payment.sync-status')->middleware('auth');

// Cart Routes
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add')->middleware('auth');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::patch('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/count', [CartController::class, 'getCount'])->name('cart.count');
Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout')->middleware('auth');

// Checkout Routes
Route::middleware('auth')->group(function () {
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/pending', [CheckoutController::class, 'pending'])->name('checkout.pending');
});

// Profile Transactions
Route::get('/profile/transactions', [ProfileTransactionController::class, 'index'])->name('profile.transactions')->middleware('auth');
Route::get('/profile/transactions/{order}', [ProfileTransactionController::class, 'show'])->name('profile.transactions.show')->middleware('auth');
Route::post('/profile/transactions/{order}/rating', [ProfileTransactionController::class, 'storeRating'])->name('profile.transactions.rating.store')->middleware('auth');

// Address Routes
Route::middleware('auth')->group(function () {
    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::put('/addresses/{address}', [AddressController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{address}', [AddressController::class, 'destroy'])->name('addresses.destroy');
    Route::post('/addresses/{address}/set-default', [AddressController::class, 'setDefault'])->name('addresses.setDefault');
    Route::get('/addresses', [AddressController::class, 'index'])->name('addresses.index');
});

Route::get('/dashboard', function () {
    return view('welcome');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Create Custom Design Routes
Route::get('/create-custom', [CreateCustomController::class, 'selectType'])->name('create-custom.type');
Route::get('/create-custom/finish', [CreateCustomController::class, 'selectFinish'])->name('create-custom.finish');
Route::get('/create-custom/chain-style', [CreateCustomController::class, 'selectChainStyle'])->name('create-custom.chain-style');
Route::get('/create-custom/chain-size', [CreateCustomController::class, 'selectChainSize'])->name('create-custom.chain-size');
Route::get('/create-custom/charm', [CreateCustomController::class, 'selectCharm'])->name('create-custom.charm');
Route::post('/create-custom/store', [CreateCustomController::class, 'store'])->name('create-custom.store');
Route::get('/checkout/custom-design/{inquiry_id}', [CreateCustomController::class, 'checkoutDesign'])->name('checkout.custom-design')->middleware('auth');
Route::post('/checkout/custom-design/{inquiry_id}/pay', [CreateCustomController::class, 'processCustomDesignPayment'])->name('checkout.custom-design-pay')->middleware('auth');

// Debug route for checking images
Route::get('/debug/images', function () {
    abort_unless(app()->environment('local'), 404);

    $jewelry = \App\Models\CustomizableJewelry::where('type', 'necklace')->first();
    
    if (!$jewelry || !$jewelry->image) {
        return response()->json(['error' => 'No image found']);
    }

    return response()->json([
        'type' => $jewelry->type,
        'label' => $jewelry->label,
        'image_field' => $jewelry->image,
        'asset_url' => asset('storage/' . $jewelry->image),
        'file_path' => storage_path('app/public/' . $jewelry->image),
        'file_exists' => file_exists(storage_path('app/public/' . $jewelry->image)),
    ]);
});

require __DIR__.'/auth.php';

// Legal Pages - MUST BE LAST (catch-all route)
Route::get('/{legalPage}', [LegalPageController::class, 'show'])->name('pages.legal');
