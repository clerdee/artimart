<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CategoryController;
use App\Models\Category;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [ItemController::class, 'getItems'])->name('getItems');
Route::get('add-to-cart/{id}', [ItemController::class, 'addToCart'])
    ->name('addToCart')  // Add the name here
    ->middleware('auth');

Route::get('/shopping-cart', [ItemController::class, 'getCart'])->name('getCart')->middleware('auth');;

Route::post('/cart/update/{id}', [ItemController::class, 'updateCart'])->name('updateCart');
Route::get('/cart/remove/{id}', [ItemController::class, 'removeItem'])->name('removeItem');

Route::post('/checkout', [ItemController::class, 'postCheckout'])->name('checkout');

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function ()  {
    Route::get('/items/restore/{id}', [ItemController::class, 'restore'])->name('items.restore');
    Route::post('/items-import', [ItemController::class, 'import'])->name('item.import');
    Route::get('/items/{item}/edit', [ItemController::class, 'edit'])->name('items.edit');
    Route::delete('/items/{item}/delete', [ItemController::class, 'destroy'])->name('items.destroy');
    Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
    Route::post('/items', [ItemController::class, 'store'])->name('items.store');
    Route::put('/items/{item}/update', [ItemController::class, 'update'])->name('items.update');

    Route::get('/categories/create', [CategoryController::class, 'create'])->name('category.create');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('category.edit');
    Route::delete('/categories/{category}/delete', [CategoryController::class, 'destroy'])->name('category.destroy');
    Route::post('/categories/store', [CategoryController::class, 'store'])->name('category.store');
    Route::put('/categories/{category}/update', [CategoryController::class, 'update'])->name('category.update');
    Route::get('/categories/restore/{id}', [CategoryController::class, 'restore'])->name('category.restore');

    Route::get('/users', [DashboardController::class, 'getUsers'])->name('admin.users');
    Route::get('/orders', [DashboardController::class, 'getOrders'])->name('admin.orders');
    Route::get('/reviews', [DashboardController::class, 'getReviews'])->name('admin.reviews');
    Route::get('/items', [DashboardController::class, 'getItems'])->name('admin.items');
    Route::get('/categories', [DashboardController::class, 'getCategories'])->name('admin.categories');

    Route::get('/order/{id}', [OrderController::class, 'processOrder'])->name('admin.orderDetails');
    Route::post('/order/{id}', [OrderController::class, 'orderUpdate'])->name('admin.orderUpdate');

    Route::put('/users/{user}/update', [UserController::class, 'update_role'])->name('users.update');
    Route::put('/users/{user}/update_status', [UserController::class, 'update_status'])->name('users.update_status');
});

Route::get('/shop', [ItemController::class, 'getItems'])->name('shop.index');
Route::get('/items/{item}', [ItemController::class, 'show'])->name('item.show');

Route::get('/my-orders', [OrderController::class, 'myOrders'])->middleware('auth')->name('orders.my');
Route::put('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
Route::get('/orders/{order}/review', [ReviewController::class, 'addReview'])->name('orders.review');

Route::post('/reviews/store', [ReviewController::class, 'store'])->name('reviews.store');
Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
Route::get('/reviews/{id}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
Route::put('/reviews/{id}', [ReviewController::class, 'update'])->name('reviews.update');
Route::delete('/reviews/{id}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
Route::post('/reviews/restore/{id}', [ReviewController::class, 'restore'])->name('reviews.restore');


Route::get('/profile/edit', [UserController::class, 'edit'])->name('profile.edit')->middleware('auth');
Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update')->middleware('auth');
Route::put('/profile/security', [UserController::class, 'updateSecurity'])->name('profile.security')->middleware('auth');
Route::get('/logout', [UserController::class, 'logout'])->name('user.logout');

Route::get('/dashboard',[DashboardController::class, 'index'])->name('dashboard.index');
Route::get('/search',[SearchController::class, 'search'])->name('search');

Auth::routes([
    'verify' => true
]);

Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('verified');
