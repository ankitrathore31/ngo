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
    Route::get('SocialActivity/ViewActivity','viewhomeactivity')->name('viewactivity');
    Route::get('/Services', 'servicepage')->name('service');
    Route::get('/About', 'aboutpage')->name('about');
    Route::get('/Event', 'eventpage')->name('event');
    Route::get('/Project', 'projectpage')->name('project');

});

Route::controller(SocialActivityController::class)->group(function(){
    Route::get('admin/activitylist','activitylist')->middleware('auth')->name('activitylist');
    Route::get('admin/addactivity','addactivity')->middleware('auth')->name('addactivity');
    Route::post('admin/saveactivity', 'saveactivity')->middleware('auth')->name('saveactivity');
    Route::get('admin/editactivity/{id}','editactivity')->middleware('auth')->name('editactivity');
    Route::post('admin/updateactivity/{id}', 'updateactivity')->middleware('auth')->name('updateactivity');
    Route::get('admin/removeactivity/{id}','removeactivity')->middleware('auth')->name('removeactivity');

});

require __DIR__.'/auth.php';
