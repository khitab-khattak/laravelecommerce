<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\User\OrderController as UserOrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/',[HomeController::class,'index'])->name('home.index');
Route::get('/contact-us',[HomeController::class,'contact'])->name('home.contact');
Route::post('/contact/store',[HomeController::class,'contact_store'])->name('home.contactStore');
Route::get('/serach',[HomeController::class,'search'])->name('home.search');




Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{product_slug}', [ShopController::class, 'product_details'])->name('shop.product-details');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add_to_cart'])->name('cart.add');
Route::put('cart/increase-quantity/{rowId}', [CartController::class, 'increase_cart_quantity'])->name('cart.qty.increase');
Route::put('cart/decrease-quantity/{rowId}', [CartController::class, 'decrease_cart_quantity'])->name('cart.qty.decrease');
Route::delete('cart/delete/{rowId}', [CartController::class, 'delete_cart_item'])->name('cart.remove');
Route::delete('cart/clear', [CartController::class, 'clear_cart'])->name('cart.clear');

Route::post('/cart/apply-coupon',[CartController::class, 'apply_coupon_code'])->name('cart.coupon.apply');
Route::delete('cart/coupon/remove', [CartController::class, 'removeCoupon'])->name('cart.coupon.remove');
Route::delete('cart/clear', [CartController::class, 'clear'])->name('cart.clear');

//wishlist
Route::post('/wishlist/add', [WishlistController::class, 'add_to_wishlist'])->name('wishlist.add');
Route::get('wishlist/', [WishlistController::class, 'index'])->name('wishlist.index');
Route::delete('wishlist/delete/{rowId}', [WishlistController::class, 'remove_wishlist_item'])->name('wishlist.remove');
Route::delete('wishlist/clear', [WishlistController::class, 'clear_wishlist'])->name('wishlist.clear');
Route::post('wishlist/move-to-cart/{rowId}', [WishlistController::class, 'move_to_cart'])->name('wishlist.movetocart');
//checkout
Route::get('/checkout',[CartController::class,'checkout'])->name('cart.checkout');
Route::post('/place-an-order',[CartController::class,'place_an_order'])->name('cart.placeorder');
Route::get('/order-confirmation',[CartController::class,'order_confirmation'])->name('cart.orderConfirmation');


Auth::routes();

// USER dashboard
Route::middleware(['auth'])->group(function () {
    Route::get('/account/dashboard', [UserController::class, 'index'])->name('user.index');
    Route::post('/account/logout', [UserController::class, 'logout'])->name('user.logout');

    //Orders
    Route::get('account/orders/list',[UserOrderController::class,'list'])->name('users.orders');
    Route::get('account/orders/details/{order_id}',[UserOrderController::class,'details'])->name('users.orders.details');
    Route::put('/account/order/cancel',[UserOrderController::class,'order_cancel'])->name('account.order.cancel');
});



// ADMIN dashboard
Route::middleware(['auth', AuthAdmin::class])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.index');
    Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
    //BRANDS
    Route::get('/admin/brands', [BrandController::class, 'brands'])->name('admin.brands');
    Route::get('/admin/add-brands', [BrandController::class, 'brand_add'])->name('admin.add-brands');
    Route::post('/admin/brand-store', [BrandController::class, 'brand_store'])->name('admin.store-brands');
    Route::get('/admin/brand-edit/{id}', [BrandController::class, 'brand_edit'])->name('admin.edit-brands');
    Route::put('/admin/brand-update/{id}', [BrandController::class, 'brand_update'])->name('admin.update-brands');
    Route::delete('/admin/brand-delete/{id}', [BrandController::class, 'brand_delete'])->name('admin.delete-brands');

    //categories
    Route::get('/admin/category/list', [CategoryController::class, 'list'])->name('admin.category');
    Route::get('/admin/category/add', [CategoryController::class, 'add'])->name('admin.add-category');
    Route::post('/admin/category/store', [CategoryController::class, 'store'])->name('admin.store-category');
    Route::get('/admin/category-edit/{id}', [CategoryController::class, 'category_edit'])->name('admin.edit-category');
    Route::put('/admin/category-update/{id}', [CategoryController::class, 'category_update'])->name('admin.update-category');
    Route::delete('/admin/category-delete/{id}', [CategoryController::class, 'category_delete'])->name('admin.delete-category');

    //products
    Route::get('/admin/product/list', [ProductController::class, 'list'])->name('admin.products');

    Route::get('/admin/product/add', [ProductController::class, 'add'])->name('admin.add-products');
    Route::post('/admin/product/store', [ProductController::class, 'store'])->name('admin.store-products');
    Route::get('/admin/product/edit/{id}', [ProductController::class, 'edit'])->name('admin.edit-products');
    Route::put('/admin/product/edit/{id}', [ProductController::class, 'update'])->name('admin.update-products');
    Route::delete('/admin/product/delete/{id}', [ProductController::class, 'delete'])->name('admin.delete-products');


    //coupons
    Route::get('admin/coupons/list', [CouponController::class, 'list'])->name('coupons.list');
    Route::get('admin/coupons/add', [CouponController::class, 'add'])->name('coupons.add');
    Route::post('admin/coupons/store', [CouponController::class, 'store'])->name('coupons.store');
    Route::get('admin/coupons/edit/{id}', [CouponController::class, 'edit'])->name('coupons.edit');
    Route::put('admin/coupons/edit/{id}', [CouponController::class, 'update'])->name('coupons.update');
    Route::delete('admin/coupons/delete/{id}', [CouponController::class, 'destroy'])->name('coupons.delete');

    //order
    Route::get('/admin/orders/list',[OrderController::class,'list'])->name('admin.orders');
    Route::get('/admin/orders/details/{id}',[OrderController::class,'details'])->name('admin.order-details');
    Route::put('admin/orders/update_status',[OrderController::class,'update_order_status'])->name('admin.order.status.update');

    //Slider
    Route::get('admin/slider/list',[SliderController::class,'list'])->name('admin.slider.list');
    Route::get('admin/slider/add',[SliderController::class,'add'])->name('admin.slider.add');
    Route::post('admin/slider/store',[SliderController::class,'store'])->name('admin.slider.store');
    Route::get('/slider/{id}/edit', [SliderController::class, 'edit'])->name('slider.edit');

    // Update slide
    Route::put('/slider/{id}/update', [SliderController::class, 'update'])->name('slider.update');
    Route::delete('/slider/{id}/delete', [SliderController::class, 'delete'])->name('admin.delete-slide');

//contacts
    Route::get('/admin/contact',[HomeController::class, 'contacts'])->name('admin.contact-show');
    Route::delete('/delete/contact/{id}',[HomeController::class, 'destroy'])->name('admin.contact-delete');

    //search
    Route::get('/admin/search',[AdminController::class,'search_product'])->name('admin.search');
});
