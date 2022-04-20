<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

// フロント
Route::prefix('/')->group(function () {
    Route::get('', function () {
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    });

    // 認証後
    Route::middleware(['auth:front', 'verified'])->group(function () {
        Route::get('/home', function () {
            return Inertia::render('Front/home');
        })->name('home');
    });
});

// 管理者
Route::prefix('/admin')->group(function () {
    // 認証後
    Route::middleware(['auth:admin', 'verified'])->group(function () {
        Route::get('/home', function () {
            return Inertia::render('Admin/Home');
        })->name('home');
    });
});

require __DIR__.'/front.auth.php';
require __DIR__.'/admin.auth.php';