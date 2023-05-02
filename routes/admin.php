<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\SubSubCategoryController;

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

Route::group(['prefix' => 'dashboard', 'middleware' => 'auth:admin'], function () {
    Route::resource('roles', RoleController::class);
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::group(['prefix' => 'admins'], function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/create', [AdminController::class, 'create'])->name('admin.create');
        Route::post('/create', [AdminController::class, 'store'])->name('admin.store');
        Route::delete('/{id}/delete', [AdminController::class, 'delete'])->name('admin.delete');
        Route::get('/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');
        Route::post('/{id}/update', [AdminController::class, 'update'])->name('admin.update');
    });
    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', [CategoryController::class, 'index'])->name('category.index');
        Route::get('/create', [CategoryController::class, 'create'])->name('category.create');
        Route::post('/create', [CategoryController::class, 'store'])->name('category.store');
        Route::delete('/{id}', [CategoryController::class, 'delete'])->name('category.delete');
        Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
        Route::post('/{id}/update', [CategoryController::class, 'update'])->name('category.update');

        Route::get('/subsubcategory', [SubSubCategoryController::class, 'index'])->name('category.subsub.index');
        Route::get('subsubcategory/create', [SubSubCategoryController::class, 'create'])->name('category.subsub.create');
        Route::post('subsubcategory/create', [SubSubCategoryController::class, 'store'])->name('category.subsub.store');
        Route::delete('subsubcategory/{id}', [SubSubCategoryController::class, 'delete'])->name('category.subsub.delete');
        Route::get('subsubcategory/{id}/edit', [SubSubCategoryController::class, 'edit'])->name('category.subsub.edit');
        Route::post('subsubcategory/{id}/update', [SubSubCategoryController::class, 'update'])->name('category.subsub.update');
    });
    Route::group(['prefix' => 'products'], function () {
        Route::get('/', [ProductController::class, 'index'])->name('product.index');
        Route::get('/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('/create', [ProductController::class, 'store'])->name('product.store');
        Route::delete('/{id}/delete', [ProductController::class, 'delete'])->name('product.delete');
        Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
        Route::post('/{id}/update', [ProductController::class, 'update'])->name('product.update');
    });
});

Route::get('/admin', [LoginController::class, 'showAdminLoginForm'])->name('admin.login-view');
Route::post('/admin', [LoginController::class, 'adminLogin'])->name('admin.login');
Route::get('/admin/register', [RegisterController::class, 'showAdminRegisterForm'])->name('admin.register-view');
Route::post('/admin/register', [RegisterController::class, 'createAdmin'])->name('admin.register');
