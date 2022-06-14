<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\EbookCourseController;
use App\Http\Controllers\Admin\FooterContentController;
use App\Http\Controllers\Admin\FooterController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\Admin\AdminLoginController;
use App\Models\Admin\AdminController;
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

    Route::group(['prefix' => 'category'], function ($router) {
        $router->get('/list', [CategoryController::class, 'index'])->name('category.list');
        $router->get('/create', [CategoryController::class, 'create'])->name('category.create');
        $router->post('/create', [CategoryController::class, 'store'])->name('category.store');
        $router->get('/edit/{slug}', [CategoryController::class, 'edit'])->name('category.edit');
        $router->put('/edit/{slug}', [CategoryController::class, 'update'])->name('category.update');
        $router->delete('/destroy/{slug}', [CategoryController::class, 'destroy'])->name('category.destroy');
    });
});
