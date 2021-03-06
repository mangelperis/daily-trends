<?php

use App\Http\Controllers\FeedController;
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

Route::get('/', function () {
    return redirect('/feeds');
});


Route::resource('feeds', FeedController::class)->except(['show']);

Route::get('feeds/reload', [FeedController::class, 'reloadFeeds'])->name('feeds.reload');
