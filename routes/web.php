<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\TrainerServiceController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\GymController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ForumController;







Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    // Redirect logged-in users to home page if they are a 'user'
    Route::get('/redirect', function () {
        if (auth()->user()->role === 'user') {
            return redirect()->route('home');
        }
        return redirect()->route('dashboard');
    })->name('user.redirect');

    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');  

    // Edit Product Route
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');

    Route::get('/seller/dashboard', [SellerController::class, 'index'])->name('seller.dashboard');

});

Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');


Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::middleware('auth')->group(function () {
    // Cart Routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add/{productId}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/remove/{cartItem}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::put('/cart/update/{cartItem}', [CartController::class, 'updateQuantity'])->name('cart.update');

    // Checkout Routes
    Route::post('/checkout', [CheckoutController::class, 'createCheckoutSession'])->name('checkout.session');
    Route::get('/checkout/success/{order_id}', [CheckoutController::class, 'success'])->name('checkout.success');

    // Orders Routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});

// // Trainer Routes
// Route::middleware('auth')->group(function () {
//     Route::get('/trainers', [TrainerController::class, 'index']);
//     Route::get('/trainers/{id}', [TrainerController::class, 'show']);
//     Route::post('/trainers', [TrainerController::class, 'store']);
//     Route::get('/trainer/dashboard', [TrainerController::class, 'dashboard']);

//     // Trainer Services
//     Route::post('/trainer/services', [TrainerServiceController::class, 'store']);
//     Route::delete('/trainer/services/{id}', [TrainerServiceController::class, 'destroy']);

//     // Bookings
//     Route::post('/bookings', [BookingController::class, 'store']);
//     Route::get('/bookings', [BookingController::class, 'index']);
// });

Route::middleware(['auth'])->group(function () {
    // Wishlist Routes
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');

    // Trainer dashboard route with role check
    Route::get('/trainer/dashboard', [TrainerController::class, 'dashboard'])->name('trainer.dashboard');
    // Route to show the form to create a trainer profile
    Route::get('/trainers/create', [TrainerController::class, 'create'])->name('trainer.create');
    Route::post('/trainers', [TrainerController::class, 'store'])->name('trainer.store');
    
    // Correct route for service creation
    Route::post('/trainer/services', [TrainerServiceController::class, 'store'])->name('trainer.services.store');

    // Profile editing routes
    Route::get('/trainer/edit', [TrainerController::class, 'edit'])->name('trainer.edit');
    Route::put('/trainer/update', [TrainerController::class, 'update'])->name('trainer.update');
    Route::delete('/trainer', [TrainerController::class, 'destroy'])->name('trainer.destroy');

    // Trainer Services Routes
    Route::get('/trainer/services/{service}', [TrainerServiceController::class, 'show'])->name('trainer.services.show');
    Route::get('/trainer/services/{service}/edit', [TrainerServiceController::class, 'edit'])->name('trainer.services.edit');
    Route::put('/trainer/services/{service}', [TrainerServiceController::class, 'update'])->name('trainer.services.update');
    Route::delete('/trainer/services/{service}', [TrainerServiceController::class, 'destroy'])->name('trainer.services.destroy');
});

// Public routes for viewing trainer services
Route::get('/services', [ServicesController::class, 'index'])->name('services.index');
Route::get('/services/{service}', [ServicesController::class, 'show'])->name('services.show');
Route::middleware('auth')->group(function () {
    Route::get('/trainers/{trainer}', [TrainerController::class, 'showProfile'])->name('trainers.profile');
});

// Booking routes
Route::middleware(['auth'])->group(function () {
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/payment-complete', [BookingController::class, 'handlePaymentComplete'])->name('bookings.payment-complete');
    Route::get('/book/service/{service_id}', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
});

// Trainer booking management routes
Route::middleware(['auth'])->group(function () {
    Route::get('/trainer/bookings', [BookingController::class, 'trainerBookings'])->name('trainer.bookings');
    Route::post('/trainer/bookings/{booking}/accept', [BookingController::class, 'acceptBooking'])->name('trainer.bookings.accept');
    Route::post('/trainer/bookings/{booking}/decline', [BookingController::class, 'declineBooking'])->name('trainer.bookings.decline');
    Route::delete('/trainer/bookings/clear-cancelled', [BookingController::class, 'clearCancelledBookings'])->name('trainer.bookings.clear-cancelled');
});

Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// Gym routes
Route::get('/gyms/nearby', [GymController::class, 'index'])->name('gyms.nearby');
Route::get('/nearby-gyms', [GymController::class, 'nearbyGyms'])->name('gyms.nearby.data');

// Product Reviews
Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

// Forum Routes
Route::prefix('forum')->name('forum.')->group(function () {
    Route::get('/', [ForumController::class, 'index'])->name('index');
    Route::get('/create', [ForumController::class, 'create'])->name('create')->middleware('auth');
    Route::post('/store', [ForumController::class, 'store'])->name('store')->middleware('auth');
    Route::get('/{id}', [ForumController::class, 'show'])->name('show');
    Route::post('/{postId}/comment', [ForumController::class, 'addComment'])->name('comment')->middleware('auth');
    Route::post('/{postId}/like', [ForumController::class, 'toggleLike'])->name('like')->middleware('auth');
    Route::delete('/{id}', [ForumController::class, 'destroy'])->name('destroy')->middleware('auth');
});

require __DIR__.'/auth.php';
