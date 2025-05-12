<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialActivityController;
use App\Http\Controllers\HomeControlller;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NgoController;
use App\Http\Controllers\PaymentController;

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




// *=========================== Home Controllers ======================================= *//



Route::get('/', function () {
    return view('home.welcome');
});



Route::controller(HomeControlller::class)->group(function () {
    Route::get('/welcome', 'home')->name('welcome');
    Route::get('/SocialActivity', 'activitypage')->name('activity');
    Route::get('SocialActivity/ViewReport/{id}','viewreport')->name('viewreport');
    Route::get('/Services', 'servicepage')->name('service');
    Route::get('/About', 'aboutpage')->name('about');
    Route::get('/Event', 'eventpage')->name('event');
    Route::get('/Project', 'projectpage')->name('project');
    Route::get('/News', 'newspage')->name('news');
    Route::get('/Certificates', 'certificatepage')->name('certificate');
    Route::get('/Acheivement', 'rewardpage')->name('reward');
    Route::get('/Donation', 'donatepage')->name('donate-page');
    Route::get('/Contact', 'contact')->name('contact');
    Route::get('/education-donate', 'helpeducationcart')->name('help-education');
    Route::get('/food-donate', 'helpfood')->name('help-food');
    Route::get('/clothe-donate', 'helpclothe')->name('help-clothe');
    Route::get('/environment-donate', 'helpenvironment')->name('help-environment');
    Route::get('/Pay', 'pay')->name('pay');
});

Route::controller(PaymentController::class)->group(function () {
    Route::post('/donate',  'savedonor')->name('donate');
    Route::get('/payment-success/{id}', 'success')->name('payment.success');
    Route::get('/checkout',  'checkout')->name('checkout');
});


// *=========================== Admin Controllers ======================================= *//

Route::get('/admin', function () {
    return view('admin.AdminDashboard');
})->middleware(['auth'])->name('admin');


Route::controller(AdminController::class)->group(function () {
    Route::get('admin', 'ngolist')->middleware('auth')->name('ngolist');
    Route::get('add-ngo', 'addngo')->middleware('auth')->name('add-ngo');
    Route::get('admin/session', 'sessionlist')->middleware('auth')->name('session-list');
    Route::get('admin/add-session', 'addsession')->middleware('auth')->name('add-session');
    Route::post('admin/save-session', 'savesession')->middleware('auth')->name('save-session');
    Route::get('admin/edit-session/{id}', 'editsession')->middleware('auth')->name('edit-session');
    Route::put('admin/update-session/{id}', 'updatesession')->middleware('auth')->name('update-session');
    Route::get('admin/delete-session/{id}', 'deletesession')->middleware('auth')->name('delete-session');
});



// *=========================== Ngo Controllers ======================================= *//

Route::get('/ngo', function () {
    return view('ngo.dashboard');
})->middleware(['auth'])->name('ngo');


Route::controller(NgoController::class)->group(function(){
    Route::post('save-ngo', 'savengo')->middleware('auth')->name('save-ngo');
    Route::get('edit-ngo/{id}', 'editngo')->middleware('auth')->name('edit-ngo');
    Route::post('update-ngo/{id}', 'updatengo')->middleware('auth')->name('update-ngo');
    Route::post('toggle-status/{id}','toggleStatus')->middleware('auth')->name('ngo.toggleStatus');
    Route::delete('delete-ngo/{id}', 'deletengo')->middleware('auth')->name('delete-ngo');
    Route::get('admin/view-ngo/{id}', 'viewngo')->middleware('auth')->name('view-ngo');
});

Route::controller(SocialActivityController::class)->group(function () {
    Route::get('ngo/activitylist', 'activitylist')->middleware('auth')->name('activitylist');
    Route::get('ngo/addactivity', 'addactivity')->middleware('auth')->name('addactivity');
    Route::post('ngo/saveactivity', 'saveactivity')->middleware('auth')->name('saveactivity');
    Route::get('ngo/editactivity/{id}', 'editactivity')->middleware('auth')->name('editactivity');
    Route::post('ngo/updateactivity/{id}', 'updateactivity')->middleware('auth')->name('updateactivity');
    Route::get('ngo/removeactivity/{id}', 'removeactivity')->middleware('auth')->name('removeactivity');
    Route::get('ngo/viewactivity/{id}', 'viewactivity')->middleware('auth')->name('viewactivity');

});








require __DIR__ . '/auth.php';
