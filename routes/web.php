<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialActivityController;
use App\Http\Controllers\HomeControlller;

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
    return view('home.welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/admin', function () {
    return view('admin.AdminDashboard');
})->middleware(['auth'])->name('AdminDashboard');


Route::controller(HomeControlller::class)->group(function(){
    Route::get('/welcome','home')->name('welcome');
    Route::get('/SocialActivity','activitypage')->name('activity');
});

Route::controller(SocialActivityController::class)->group(function(){
    Route::get('/activitylist','activitylist')->middleware('auth')->name('activitylist');
    Route::get('/addactivity','addactivity')->middleware('auth')->name('addactivity');
    Route::post('admin/saveactivity', 'saveactivity')->middleware('auth')->name('saveactivity');
    
});

require __DIR__.'/auth.php';
