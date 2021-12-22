<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;

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

Route::get('/', function () {
    return view('welcome');
});
Route::group(['namespace' => 'App\Http\Controllers'], function () {
    /**
     * Home Routes
     */
    Route::get('/', [HomeController::class, 'index'])->name('home.index');

    Route::group(['middleware' => ['guest']], function () {
        /**
         * Register Routes
         */
        Route::get('/register', [RegisterController::class, 'show'])->name('register.show');
        Route::post('/register', [RegisterController::class, 'register'])->name('register.perform');

        /**
         * Login Routes
         */
        Route::get('/login', [LoginController::class, 'show'])->name('login.show');
        Route::post('/login', [LoginController::class, 'login'])->name('login.perform');
    });

    Route::group(['middleware' => ['auth']], function () {
        /**
         * Logout Routes
         */
        Route::get('/logout', [LogoutController::class, 'perform'])->name('logout.perform');


        Route::group(['prefix' => 'user'], function () {
            Route::get('/', [UserController::class, 'index'])->name('users.index');
            Route::get('/create', [UserController::class, 'create'])->name('users.create');
            Route::post('/create', [UserController::class, 'store'])->name('users.store');
            Route::get('/{user}/show', [UserController::class, 'show'])->name('users.show');
            Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
            Route::patch('/{user}/update', [UserController::class, 'update'])->name('users.update');
            Route::delete('/{user}/delete', [UserController::class, 'destroy'])->name('users.destroy');
        });
        /**
         * User Routes
         */
        Route::group(['prefix' => 'post'], function () {
            Route::get('/', [PostController::class, 'index'])->name('posts.index');
            Route::get('/create', [PostController::class, 'create'])->name('posts.create');
            Route::post('/create', [PostController::class, 'store'])->name('posts.store');
            Route::get('/{post}/show', [PostController::class, 'show'])->name('posts.show');
            Route::get('/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
            Route::patch('/{post}/update', [PostController::class, 'update'])->name('posts.update');
            Route::delete('/{post}/delete', [PostController::class, 'destroy'])->name('posts.destroy');
        });
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
    });
});
