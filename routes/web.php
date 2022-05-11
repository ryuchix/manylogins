<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PublicController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;

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

Route::get('/', [PublicController::class, 'home'])->name('home');

require __DIR__.'/auth.php';

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/', [UserController::class, 'admin'])->name('admin');

    Route::resource('users', UserController::class);
    Route::resource('posts', PostController::class);
});

Route::get('/keywords/api/{search}', [PublicController::class, 'keywordSearch'])->name('keywords');
Route::get('/{search?}', [PublicController::class, 'search'])->name('search');
Route::get('/{visit?}/{cid?}', [PublicController::class, 'visitPage'])->name('visit');

