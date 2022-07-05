<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PublicController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\KeywordController;
use App\Http\Controllers\UserSearchController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\RelatedSearchController;
use App\Http\Controllers\KeywordApi;

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

Route::get('run-cron', function() {
    KeywordApi::serpKeywordsCommands(5);
})->name('run.cron');

Route::get('run-related-cron', function() {
    KeywordApi::serpRelatedKeywordsCommands(10);
})->name('run.cron');

require __DIR__.'/auth.php';

Route::prefix('admin')->middleware(['auth'])->group(function () {

    Route::get('/', [PublicController::class, 'admin'])->name('admin');

    Route::resource('users', UserController::class);

    Route::resource('posts', PostController::class);

    Route::post('upload', [PostController::class, 'upload'])->name('admin.upload');

    Route::resource('keywords', KeywordController::class);

    Route::post('keywords/mass-delete', [KeywordController::class, 'massDelete'])->name('keywords.mass.delete');

    Route::post('keywords/mass-update', [KeywordController::class, 'massUpdate'])->name('keywords.mass.update');

    Route::resource('related', RelatedSearchController::class);

    Route::get('related/search-keyword/{id}', [RelatedSearchController::class, 'searchRelatedKeyword'])->name('related.search-keyword');

    Route::post('related/mass-delete', [RelatedSearchController::class, 'massDelete'])->name('related.mass.delete');

    Route::post('related/mass-update', [RelatedSearchController::class, 'massUpdate'])->name('related.mass.update');

    Route::resource('user-search', UserSearchController::class);

    Route::post('user-search/mass-update', [UserSearchController::class, 'massUpdate'])->name('user_search.mass.update');

    Route::resource('settings', SettingController::class);

});

Route::get('generate-sitemap', [SitemapController::class, 'create'])->name('create.sitemap');

Route::get('phptest', function() {
    return view('test');
});

Route::post('contact-us', [PublicController::class, 'contactUs'])->name('contact');
Route::get('contact-us', [PublicController::class, 'viewContactUs'])->name('view.contact');

Route::get('privacy-policy', [PublicController::class, 'privacyPolicy'])->name('privacy');

Route::get('guides', [PostController::class, 'blogLists'])->name('blog.lists');
Route::get('guides/{blog}', [PostController::class, 'showBlog'])->name('show.blog');

Route::get('/keywords/api/{search}', [PublicController::class, 'keywordSearch'])->name('keywords');

Route::get('/{search?}', [PublicController::class, 'search'])->name('search');
Route::post('search', [PublicController::class, 'processSearch'])->name('search.post');

Route::get('/{visit?}/{cid?}', [PublicController::class, 'visitPage'])->name('visit');



