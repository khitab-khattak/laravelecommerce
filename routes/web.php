<?php
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
    Route::get('/admin/brands', [AdminController::class, 'brands'])->name('admin.brands');
    Route::get('/admin/add-brands', [AdminController::class, 'brand_add'])->name('admin.add-brands');
    Route::post('/admin/brand-store', [AdminController::class, 'brand_store'])->name('admin.store-brands');
    Route::get('/admin/brand-edit/{id}', [AdminController::class, 'brand_edit'])->name('admin.edit-brands');
    Route::put('/admin/brand-update/{id}', [AdminController::class, 'brand_update'])->name('admin.update-brands');
    Route::delete('/admin/brand-delete/{id}', [AdminController::class, 'brand_delete'])->name('admin.delete-brands');
});
