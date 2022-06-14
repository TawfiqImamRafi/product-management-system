<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Auth\Admin\AdminLoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// admin guard routes
Route::group([
    'prefix' => 'admin',
], function() {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
});

Route::group([
    'prefix' => 'admin',
    'middleware' => 'auth:admin'
], function() {
    Route::get('/change-password', [\App\Http\Controllers\Auth\Admin\AuthController::class, 'changePassword'])->name('admin.change.password');
    Route::post('/change-password', [\App\Http\Controllers\Auth\Admin\AuthController::class, 'updatePassword'])->name('admin.update.password');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
});

Route::group([
    'middleware' => 'auth:admin'
], function() {
    Route::group(['prefix' => 'category'], function ($router) {
        $router->get('/list', [CategoryController::class, 'index'])->name('category.list');
        $router->get('/create', [CategoryController::class, 'create'])->name('category.create');
        $router->post('/store', [CategoryController::class, 'store'])->name('category.store');
        $router->post('/edit', [CategoryController::class, 'edit'])->name('category.edit');
        $router->post('/update', [CategoryController::class, 'update'])->name('category.update');
        $router->post('/destroy', [CategoryController::class, 'destroy'])->name('category.destroy');
    });
    Route::group(['prefix' => 'brand'], function ($router) {
        $router->get('/list', [BrandController::class, 'index'])->name('brand.list');
        $router->get('/create', [BrandController::class, 'create'])->name('brand.create');
        $router->post('/store', [BrandController::class, 'store'])->name('brand.store');
        $router->post('/edit', [BrandController::class, 'edit'])->name('brand.edit');
        $router->post('/update', [BrandController::class, 'update'])->name('brand.update');
        $router->post('/destroy', [BrandController::class, 'destroy'])->name('brand.destroy');
    });
});
