<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Admin\PostControllerAdmin;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ShoppingCartController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\LoginController;
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
Route::get('mail', [PostController::class, 'mail'])->name('mail');

Route::get('/', [PostController::class, 'index'])->name('homes');

Route::get('category', [CategoryController::class, 'index'])->name('category');

Route::get('filter/{id?}', [PostController::class, 'filter'])->name('filter');

Route::get('details/{id?}', [PostController::class, 'details'])->name('details');

Route::get('shoppingcart', [PostController::class, 'shoppingcart'])->name('shoppingcart');

Auth::routes(['verify' => true]);

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/home', [AdminController::class, 'index'])->name('home')->middleware('adminchecklogin');


    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('showLoginForm');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::post('/password-request-email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('post-password-forget');
    Route::get('/password-request', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('get-password-forget');
    Route::post('/password-request', [ResetPasswordController::class, 'reset'])->name('post-password-update');
    Route::get('/password-request/{token}', [ResetPasswordController::class, 'showResetForm'])->name('get-password-reset');


    Route::prefix('product')->name('product.')->middleware('adminchecklogin')->group(function () {
        Route::get('/create/{id?}', [PostControllerAdmin::class, 'create'])->name('create');
        Route::post('/postcreate/{id?}', [PostControllerAdmin::class, 'postcreate'])->name('postcreate');
        Route::get('/delete/{id?}', [PostControllerAdmin::class, 'delete'])->name('delete');
        Route::get('/search', [PostControllerAdmin::class, 'search'])->name('search');
    });
});

