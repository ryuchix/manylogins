<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PublicController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\KeywordController;
use App\Http\Controllers\UserSearchController;
use App\Http\Controllers\SettingController;

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

    Route::post('upload', [PostController::class, 'upload'])->name('admin.upload');

    Route::resource('keywords', KeywordController::class);

    Route::post('keywords/mass-delete', [KeywordController::class, 'massDelete'])->name('keywords.mass.delete');

    Route::post('keywords/mass-update', [KeywordController::class, 'massUpdate'])->name('keywords.mass.update');

    Route::resource('user-search', UserSearchController::class);

    Route::resource('settings', SettingController::class);

});

Route::get('generate-sitemap', [SitemapController::class, 'create'])->name('create.sitemap');

Route::get('/keywords/api/{search}', [PublicController::class, 'keywordSearch'])->name('keywords');

Route::get('/{search?}', [PublicController::class, 'search'])->name('search');

Route::get('/{visit?}/{cid?}', [PublicController::class, 'visitPage'])->name('visit');



