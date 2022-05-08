<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PublicController;

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

Route::get('/keywords/api/{search}', [PublicController::class, 'keywordSearch'])->name('keywords');

Route::get('/{search?}', [PublicController::class, 'search'])->name('search');
Route::get('/{visit?}/{cid?}', [PublicController::class, 'visitPage'])->name('visit');
