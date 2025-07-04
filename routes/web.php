<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('index');
})->name('home.index');

Auth::routes();

// USER dashboard
Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.index');
    Route::post('/user/logout', [UserController::class, 'logout'])->name('user.logout');
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
    Route::get('/admin/category/list',[CategoryController::class, 'list'])->name('admin.category');
    Route::get('/admin/category/add',[CategoryController::class, 'add'])->name('admin.add-category');
    Route::post('/admin/category/store',[CategoryController::class, 'store'])->name('admin.store-category');
    Route::get('/admin/category-edit/{id}', [CategoryController::class, 'category_edit'])->name('admin.edit-category');
    Route::put('/admin/category-update/{id}', [CategoryController::class, 'category_update'])->name('admin.update-category');
    Route::delete('/admin/category-delete/{id}', [CategoryController::class, 'category_delete'])->name('admin.delete-category');

    //products
    Route::get('/admin/product/list',[ProductController::class, 'list'])->name('admin.products');

    Route::get('/admin/product/add',[ProductController::class, 'add'])->name('admin.add-products');
    Route::post('/admin/product/store',[ProductController::class, 'store'])->name('admin.store-products');
    Route::get('/admin/product/edit/{id}',[ProductController::class, 'edit'])->name('admin.edit-products');
    Route::put('/admin/product/edit/{id}',[ProductController::class, 'update'])->name('admin.update-products');
    Route::delete('/admin/product/delete/{id}', [ProductController::class, 'delete'])->name('admin.delete-products');

});
