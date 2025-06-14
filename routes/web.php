<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialActivityController;
use App\Http\Controllers\HomeControlller;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BeneficiarieController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\NgoController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\WorkingAreaController;
use App\Models\academic_session;
use Illuminate\Support\Facades\Session;
use App\Models\Working_Area;
use Illuminate\Support\Facades\DB;

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




Route::get('/', [HomeControlller::class, 'index']);


Route::controller(HomeControlller::class)->group(function () {
    Route::get('/welcome', 'home')->name('welcome');
    Route::get('/SocialActivity', 'activitypage')->name('activity');
    Route::get('SocialActivity/ViewReport/{id}', 'viewreport')->name('viewreport');
    Route::get('/Services', 'servicepage')->name('service');
    Route::get('/About', 'aboutpage')->name('about');
    Route::get('/Event', 'eventpage')->name('event');
    Route::get('/event/show-event/{id}', 'showEvent')->name('show-event');
    Route::get('/Project', 'projectpage')->name('project');
    Route::get('/News', 'newspage')->name('news');
    Route::get('/Certificates', 'certificatepage')->name('certificate');
    Route::get('/Acheivement', 'rewardpage')->name('reward');
    Route::get('/Donation', 'donatepage')->name('donate-page');
    Route::get('/Contact', 'contactpage')->name('contact');
    Route::get('/education-donate', 'helpeducationcart')->name('help-education');
    Route::get('/food-donate', 'helpfood')->name('help-food');
    Route::get('/clothe-donate', 'helpclothe')->name('help-clothe');
    Route::get('/environment-donate', 'helpenvironment')->name('help-environment');
    Route::get('/Pay', 'pay')->name('pay');
    Route::get('/Notice', 'notice')->name('notice');
    Route::get('/Appliction-Status', 'applictionStatus')->name('applictionStatus');
    Route::post('/Check-Status', 'checkStatus')->name('check-status');
    Route::get('/Photos', 'photo')->name('photo');
    Route::get('/certificate-verify', 'certiStatus')->name('certiStatus');
    Route::get('/facilities-Status', 'facilitiesStatus')->name('facilitiesStatus');
    Route::post('/Check-Facilities', 'showfacilities')->name('check-facilities');
    Route::get('/working-area/{text}', 'showarea')->name('show-area');
    Route::get('/filter-area-counts',  'filterAreaCounts');
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

Route::get('/ngo', [NgoController::class, 'ngo'])
    ->middleware(['auth'])
    ->name('ngo');

// Route::get('/ngo', [NgoController::class, 'allbene']);
// Route::get('/test-stats', function () {
//     dd(get_bene_stats());
// });
Route::controller(NgoController::class)->group(function () {
    Route::post('save-ngo', 'savengo')->middleware('auth')->name('save-ngo');
    Route::get('edit-ngo/{id}', 'editngo')->middleware('auth')->name('edit-ngo');
    Route::post('update-ngo/{id}', 'updatengo')->middleware('auth')->name('update-ngo');
    Route::post('toggle-status/{id}', 'toggleStatus')->middleware('auth')->name('ngo.toggleStatus');
    Route::delete('delete-ngo/{id}', 'deletengo')->middleware('auth')->name('delete-ngo');
    Route::get('admin/view-ngo/{id}', 'viewngo')->middleware('auth')->name('view-ngo');
    Route::get('admin/totalngo-list', 'totalngo')->middleware('auth')->name('totalngo-list');
    Route::get('admin/activengo-list', 'activengo')->middleware('auth')->name('activengo-list');
    Route::get('admin/deactivengo-list', 'deactivengo')->middleware('auth')->name('deactivengo-list');
});

Route::controller(SocialActivityController::class)->group(function () {
    Route::get('ngo/activitylist', 'activitylist')->middleware('auth')->name('activitylist');
    Route::get('ngo/addactivity', 'addactivity')->middleware('auth')->name('addactivity');
    Route::post('ngo/saveactivity', 'saveactivity')->middleware('auth')->name('saveactivity');
    Route::get('ngo/editactivity/{id}', 'editactivity')->middleware('auth')->name('editactivity');
    Route::post('ngo/updateactivity/{id}', 'updateactivity')->middleware('auth')->name('updateactivity');
    Route::get('ngo/removeactivity/{id}', 'removeactivity')->middleware('auth')->name('removeactivity');
    Route::get('ngo/viewactivity/{id}', 'viewactivity')->middleware('auth')->name('viewactivity');
    Route::get('ngo/addevent', 'addevent')->middleware('auth')->name('add-event');
    Route::post('ngo/save-event', 'saveEvent')->middleware('auth')->name('save-event');
    Route::get('ngo/event-list', 'eventList')->middleware('auth')->name('event-list');
    Route::get('ngo/delete-event/{id}', 'removeEvent')->middleware('auth')->name('remove-event');
    Route::get('ngo/view-event/{id}', 'viewEvent')->middleware('auth')->name('view-event');
    Route::get('ngo/edit-event/{id}', 'editEvent')->middleware('auth')->name('edit-event');
    Route::post('ngo/update-event/{id}', 'updateEvent')->middleware('auth')->name('update-event');
});


Route::middleware('auth')->group(function () {
    Route::get('ngo/registration', [RegistrationController::class, 'registration'])->name('registration');
    Route::post('ngo/store-registration', [RegistrationController::class, 'StoreRegistration'])->name('store-registration');
    Route::post('ngo/update-registration/{id}', [RegistrationController::class, 'UpdateRegistration'])->name('update-registration');
    Route::get('ngo/pending-registration', [RegistrationController::class, 'pendingRegistration'])->name('pending-registration');
    Route::patch('ngo/approve-status/{type}/{id}', [RegistrationController::class, 'approveStatus'])->name('approve-status');
    Route::get('ngo/approve-registration', [RegistrationController::class, 'approveRegistration'])->name('approve-registration');
    Route::get('ngo/show-apporve-registration/{id}/{type}', [RegistrationController::class, 'showApporveReg'])->name('show-apporve-reg');
    Route::patch('ngo/pending-status/{type}/{id}', [RegistrationController::class, 'pendingStatus'])->name('pending-status');
    Route::get('ngo/view-registration/{id}/{type}', [RegistrationController::class, 'viewRegistration'])->name('view-reg');
    Route::get('ngo/delete-view/{id}/{type}', [RegistrationController::class, 'deleteRegistrationPage'])->name('delete-view');
    Route::post('ngo/delete-registration/{id}/{type}', [RegistrationController::class, 'deleteRegistration'])->name('delete-reg');
    Route::get('ngo/recover-registration', [RegistrationController::class, 'recover'])->name('recover');
    Route::get('ngo/recover/{id}/{type}', [RegistrationController::class,'recoverItem'])->name('recover-item');
    Route::get('ngo/online-registration-setting', [RegistrationController::class, 'onlineregistrationSetting'])->name('reg-setting');
    Route::post('ngo/registration-toggle', [RegistrationController::class, 'toggleSetting'])->name('registration.toggle');
    Route::get('ngo/edit-registration/{id}/{type}', [RegistrationController::class, 'editRegistration'])->name('edit-reg');
    Route::get('ngo/edit-apporve-registration/{id}/{type}', [RegistrationController::class, 'editApproveRegistration'])->name('edit-apporve-reg');
    Route::post('ngo/update-apporve-registration/{id}', [RegistrationController::class, 'UpdateApporveRegistration'])->name('update-apporve-registration');

});

Route::controller(RegistrationController::class)->group(function () {
    Route::get('ngo/online-registration', 'onlineregistration')->name('online-registration');
    Route::post('ngo/online-store-registration', 'onlineStoreRegistration')->name('onlinestore-registration');

});

Route::controller(GalleryController::class)->group(function () {
    Route::get('ngo/Gallery', 'gallery')->middleware('auth')->name('gallery-list');
    Route::get('ngo/Add-Photos', 'addPhotos')->middleware('auth')->name('add-photos');
    Route::post('ngo/Save-Photo', 'storePhoto')->middleware('auth')->name('save-photo');
    Route::delete('ngo/Delete-Photo/{id}',  'deletePhoto')->middleware('auth')->name('delete-photo');
});

Route::controller(BeneficiarieController::class)->group(function () {
    Route::get('ngo/add-beneficiarie-list', 'AddbeneficiarieList')->middleware('auth')->name('beneficiarie-add-list');
    Route::get('ngo/view-beneficiarie/{id}', 'viewbeneficiarie')->middleware('auth')->name('view-beneficiarie');
    Route::get('ngo/add-beneficiarie/{id}', 'addbeneficiarie')->middleware('auth')->name('add-beneficiarie');
    Route::post('ngo/store-beneficiarie/{id}', 'storeBeneficiarie')->middleware('auth')->name('store-beneficiarie');
    Route::get('ngo/beneficiarie-facilities', 'beneficiarieFacilities')->middleware('auth')->name('beneficiarie-facilities');
    Route::get('ngo/add-beneficiarie-facilities/{beneficiarie_id}/survey/{survey_id}', 'addbeneficiarieFacilities')->middleware('auth')->name('add-beneficiarie-facilities');
    Route::post('ngo/store-beneficiarie-facilities/{beneficiarie_id}/survey/{survey_id}', 'storebeneficiariefacilities')->middleware('auth')->name('store-beneficiarie-facilities');
    Route::get('ngo/beneficiarie-Facilities-list', 'beneficiarieFacilitiesList')->middleware('auth')->name('beneficiarie-facilities-list');
    Route::get('ngo/edit-beneficiarie/{id}', 'editbeneficiarie')->middleware('auth')->name('edit-beneficiarie');
    Route::post('ngo/update-beneficiare/{id}', 'updatebeneficiarie')->middleware('auth')->name('update-beneficiarie');
    Route::get('ngo/show-beneficiarie-survey/{beneficiarie_id}/survey/{survey_id}', 'showbeneficiariesurvey')->middleware('auth')->name('show-beneficiarie-survey');
    Route::get('ngo/delete-survey/{beneficiarie_id}/survey/{survey_id}', 'deletesurvey')->middleware('auth')->name('delete-survey');
    Route::get('ngo/show-beneficiarie-facilities/{beneficiarie_id}/survey/{survey_id}', 'showbeneficiariefacilities')->middleware('auth')->name('show-beneficiarie-facilities');
    Route::get('ngo/edit-facilities/{beneficiarie_id}/survey/{survey_id}', 'editFacilities')->middleware('auth')->name('edit-facilities');
    Route::post('ngo/update-facilities/{beneficiarie_id}/survey/{survey_id}', 'updateFacilities')->middleware('auth')->name('update-facilities');
    // Route::get('ngo/delete-facilities/{beneficiarie_id}/survey/{survey_id}', 'deletefacilities')->middleware('auth')->name('delete-facilities');
    Route::get('ngo/distribute-beneficiarie-facilities/{beneficiarie_id}/survey/{survey_id}', 'distributebeneficiarieFacilities')->middleware('auth')->name('distribute-beneficiarie-facilities');
    Route::post('ngo/store-distribute-facilities/{beneficiarie_id}/survey/{survey_id}', 'storedistributefacilities')->middleware('auth')->name('store-distribute-facilities');
    Route::get('ngo/distributed-facilities', 'distributefacilities')->middleware('auth')->name('distributed-list');
    Route::get('ngo/all-beneficiarie-list', 'allbeneficiarielist')->middleware('auth')->name('all-beneficiarie-list');
    Route::get('ngo/Pending-facilities', 'pendingfacilities')->middleware('auth')->name('pending-distribute-list');
    Route::get('ngo/beneficiarie-report-list', 'beneficiarieReportList')->middleware('auth')->name('beneficiarie-report-list');
    Route::get('ngo/show-beneficiarie-report/{beneficiarie_id}/survey/{survey_id}', 'showbeneficiariereport')->middleware('auth')->name('show-beneficiarie-report');
    Route::get('ngo/Survey-received-list', 'surveyrecivedlist')->middleware('auth')->name('survey-received-list');


});

Route::controller(WorkingAreaController::class)->group(function(){
    Route::get('ngo/working-area', 'workingarea')->middleware('auth')->name('working-area');
    Route::post('ngo/store-area', 'storeArea')->middleware('auth')->name('store-area');
    Route::get('ngo/working-area-list', 'workingAreaList')->middleware('auth')->name('working-area-list');
    Route::get('ngo/edit-area/{id}', 'editarea')->middleware('auth')->name('edit-area');
    Route::post('ngo/update-area/{id}', 'updatearea')->middleware('auth')->name('update-area');
    Route::get('ngo/delete-Working-area/{id}', 'removeArea')->middleware('auth')->name('remove-area');
});

Route::controller(NoticeController::class)->group(function(){
    Route::get('ngo/add-notice', 'addnotice')->middleware('auth')->name('add-notice');
    Route::post('ngo/store-notice', 'storeNotice')->middleware('auth')->name('store-notice');
    Route::get('ngo/notice-list', 'NoticeList')->middleware('auth')->name('notice-list');
    Route::get('ngo/view-notice/{id}', 'ViewNotice')->middleware('auth')->name('view-notice');
    Route::get('ngo/edit-notice/{id}', 'editNotice')->middleware('auth')->name('edit-notice');
    Route::post('ngo/update-notice/{id}', 'updateNotice')->middleware('auth')->name('update-notice');
    Route::get('ngo/delete-notice/{id}', 'deleteNotice')->middleware('auth')->name('delete-notice');
    Route::get('ngo/notice-status/{id}', 'NoticeStatus')->middleware('auth')->name('notice-status');
});

Route::controller(StaffController::class)->group( function(){
    Route::get('ngo/add-staff', 'addstaff')->middleware('auth')->name('add-staff');
    Route::get('ngo/staff-list', 'staffList')->middleware('auth')->name('staff-list');
});

Route::controller(MemberController::class)->group( function(){
    Route::get('ngo/member-list', 'memberList')->middleware('auth')->name('member-list');
    Route::get('ngo/add-member-list', 'addmemberlist')->middleware('auth')->name('add-member-list');
    Route::get('ngo/view-member/{id}', 'showMember')->middleware('auth')->name('view-member');
    Route::post('ngo/save-position',  'savePosition')->middleware('auth')->name('save-member-position');
    Route::get('ngo/member-position-list', 'memberPostionlist')->middleware('auth')->name('member-position-list');
    Route::get('ngo/show-member/{id}', 'showMemberPosition')->middleware('auth')->name('show-member');
    Route::get('ngo/member-certificate/{id}', 'MemberCerti')->middleware('auth')->name('member-certi');
    Route::get('ngo/member-letter/{id}', 'MemberLetter')->middleware('auth')->name('member-letter');
    Route::get('ngo/member-activity-list', 'Memberactivitylist')->middleware('auth')->name('member-activitylist');
    Route::get('ngo/add-member-activity', 'addmemberactivity')->middleware('auth')->name('add-memberactivity');
    Route::post('ngo/save-member-activity',  'saveMemberactivity')->middleware('auth')->name('save-memberactivity');
    Route::get('ngo/activity-certificate/{id}/{category}', 'MemberActivityCerti')->middleware('auth')->name('member-activity-certi');
});

Route::controller(DonationController::class)->group(function(){
    Route::get('ngo/online-donor-list', 'onlineDonor')->middleware('auth')->name('online-donor-list');
    Route::get('ngo/donation-list', 'donationList')->middleware('auth')->name('donation-list');
    Route::get('ngo/donation', 'donation')->middleware('auth')->name('donation');
    Route::post('ngo/save-donation', 'saveDonation')->middleware('auth')->name('save-donation');
    Route::get('ngo/view-donation/{id}', 'viewDonation')->middleware('auth')->name('view-donation');
    Route::get('ngo/donation-card-list', 'donationCardList')->middleware('auth')->name('donation-card-list');
});



require __DIR__ . '/auth.php';
