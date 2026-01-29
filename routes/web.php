<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialActivityController;
use App\Http\Controllers\HomeControlller;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BeneficiarieController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\CashBookController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\EduactionCardController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\NgoController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HealthCardController;
use App\Http\Controllers\IdcardController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\KycController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\ProblemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SallaryController;
use App\Http\Controllers\SignatureController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StaffWorkController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\TrainingCenterController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\WorkingAreaController;
use App\Http\Controllers\WorkPlanController;
use App\Models\academic_session;
use Illuminate\Support\Facades\Session;
use App\Models\Working_Area;
use App\Models\WorkPlan;
use GuzzleHttp\Middleware;
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
    Route::get('/eligibility', 'eligibility')->name('eligibility');
    Route::get('/organization-groups/{id}', 'groups')->name('organization.groups');
    Route::get('/organization-groups-member/{id}', 'OrgMemberListByOrganization')->name('show.group.member');
    Route::get('/demand', 'demand')->name('demand');
    Route::get('/center', 'Center')->name('home.center.list');
    Route::get('/vacancies', 'HomeJobList')->name('vacancies');
    Route::get('/download-document', 'document')->name('document');
    Route::get('/true-story', 'TrueStory')->name('true.story.list');
});

Route::controller(CertificateController::class)->group(function () {
    Route::get('/search-certificate',  'SearchCerti')->name('search.certi');
    Route::post('/certificate/member', 'memberSearch')->name('certi.member');
    Route::post('/certificate/bene', 'beneficiarySearch')->name('certi.bene');
    Route::post('/certificate/donor', 'donorSearch')->name('certi.donor');
});


Route::controller(PaymentController::class)->group(function () {
    Route::post('/donate',  'savedonor')->name('donate');
    Route::get('/payment-success/{id}', 'success')->name('payment.success');
    Route::get('/checkout',  'checkout')->name('checkout');
});

Route::controller(EmailController::class)->group(function () {
    Route::post('/email',  'StoreEmail')->name('store.email');
    Route::get('ngo/email-list',  'EmailList')->middleware('auth')->name('email.list');
    Route::get('ngo/email-view/{id}',  'ViewEmail')->middleware('auth')->name('view.email');
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

Route::controller(ProfileController::class)->group(function () {
    Route::get('ngo/profile', 'Profile')->middleware('auth')->name('profile');
    Route::post('ngo/store-profile', 'StoreProfile')->middleware('auth')->name('profile.store');
    Route::get('ngo/edit-profile', 'EditProfile')->middleware('auth')->name('edit.profile');
    Route::post('ngo/update-profile', 'UpdateProfile')->middleware('auth')->name('profile.update');
    Route::get('ngo/change-pass', 'ChangePassword')->Middleware('auth')->name('change.pass.show');
    Route::post('ngo/update-pass', 'UpdatePass')->middleware('auth')->name('password.change');
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
    Route::get('ngo/category-list', 'CategoryList')->middleware('auth')->name('category.list');
    Route::get('ngo/add-category', 'AddCategory')->middleware('auth')->name('add.category');
    Route::post('ngo/store-category', 'StoreCategory')->middleware('auth')->name('store.category');
    Route::get('ngo/category-delete/{id}', 'DeleteCategory')->middleware('auth')->name('remove.category');
});

Route::middleware('auth')->group(function () {
    Route::get('ngo/registration', [RegistrationController::class, 'registration'])->name('registration');
    Route::post('ngo/store-registration', [RegistrationController::class, 'StoreRegistration'])->name('store-registration');
    Route::post('ngo/update-registration/{id}', [RegistrationController::class, 'UpdateRegistration'])->name('update-registration');
    Route::get('ngo/pending-registration', [RegistrationController::class, 'pendingRegistration'])->name('pending-registration');
    Route::patch('ngo/approve-status/{type}/{id}', [RegistrationController::class, 'approveStatus'])->name('approve-status');
    Route::get('ngo/approve-registration', [RegistrationController::class, 'approveRegistration'])->name('approve-registration');
    Route::get('ngo/show-apporve-registration/{id}/{type}', [RegistrationController::class, 'showApporveReg'])->name('show-apporve-reg');
    Route::get('ngo/show-registration-card/{id}/{type}', [RegistrationController::class, 'showApporveRegCard'])->name('show-reg-card');
    Route::patch('ngo/pending-status/{type}/{id}', [RegistrationController::class, 'pendingStatus'])->name('pending-status');
    Route::get('ngo/view-registration/{id}/{type}', [RegistrationController::class, 'viewRegistration'])->name('view-reg');
    Route::get('ngo/delete-view/{id}/{type}', [RegistrationController::class, 'deleteRegistrationPage'])->name('delete-view');
    Route::post('ngo/delete-registration/{id}/{type}', [RegistrationController::class, 'deleteRegistration'])->name('delete-reg');
    Route::get('ngo/recover-registration', [RegistrationController::class, 'recover'])->name('recover');
    Route::get('ngo/recover/{id}/{type}', [RegistrationController::class, 'recoverItem'])->name('recover-item');
    Route::get('ngo/online-registration-setting', [RegistrationController::class, 'onlineregistrationSetting'])->name('reg-setting');
    Route::post('ngo/registration-toggle', [RegistrationController::class, 'toggleSetting'])->name('registration.toggle');
    Route::get('ngo/edit-registration/{id}/{type}', [RegistrationController::class, 'editRegistration'])->name('edit-reg');
    Route::get('ngo/edit-apporve-registration/{id}/{type}', [RegistrationController::class, 'editApproveRegistration'])->name('edit-apporve-reg');
    Route::post('ngo/update-apporve-registration/{id}', [RegistrationController::class, 'UpdateApporveRegistration'])->name('update-apporve-registration');
});

Route::controller(RegistrationController::class)->group(function () {
    Route::get('ngo/online-registration', 'onlineregistration')->name('online-registration');
    Route::post('ngo/online-store-registration', 'onlineStoreRegistration')->name('onlinestore-registration');
    Route::get('/check-identity', [RegistrationController::class, 'checkIdentity'])->name('check.identity');
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
    Route::get('ngo/delete-beneficiarie-facilities/{id}', 'deleteBeneficiarieFacilities')->middleware('auth')->name('delete.beneficiarie.facilities');
    Route::get('ngo/distribute-beneficiarie-facilities/{beneficiarie_id}/survey/{survey_id}', 'distributebeneficiarieFacilities')->middleware('auth')->name('distribute-beneficiarie-facilities');
    Route::post('ngo/store-distribute-facilities/{beneficiarie_id}/survey/{survey_id}', 'storedistributefacilities')->middleware('auth')->name('store-distribute-facilities');
    Route::get('ngo/edit-distribute-facilities/{beneficiarie_id}/survey/{survey_id}', 'EditDistributeFacilities')->middleware('auth')->name('edit-distribute-facilities');
    Route::post('ngo/update-distribute-facilities/{beneficiarie_id}/survey/{survey_id}', 'Updatedistributefacilities')->middleware('auth')->name('update-distribute-facilities');
    Route::get('ngo/edit-distribute-facilities-status/{beneficiarie_id}/survey/{survey_id}', 'EditDistributeFacilitiesStatus')->middleware('auth')->name('edit-distribute-facilities-status');
    Route::post('ngo/update-distribute-facilities-status/{beneficiarie_id}/survey/{survey_id}', 'UpdatedistributefacilitiesStatus')->middleware('auth')->name('update-distribute-facilities-status');
    Route::get('ngo/distributed-facilities', 'distributefacilities')->middleware('auth')->name('distributed-list');
    Route::get('ngo/distributed-facilities-for-approve', 'DistributeFacilitiesForApprove')->middleware('auth')->name('distributed-list-for-approve');
    Route::get('ngo/distribute-approve-facilities/{beneficiarie_id}/survey/{survey_id}', 'DistributeFacilitiesStatus')->middleware('auth')->name('distribute-facilities-status');
    Route::post('ngo/store-approve-facilities/{beneficiarie_id}/survey/{survey_id}', 'storedistributefacilitiesStatus')->middleware('auth')->name('store-distribute-status');
    Route::get('ngo/all-beneficiarie-list', 'allbeneficiarielist')->middleware('auth')->name('all-beneficiarie-list');
    Route::get('ngo/Pending-facilities', 'pendingfacilities')->middleware('auth')->name('pending-distribute-list');
    Route::get('ngo/beneficiarie-report-list', 'beneficiarieReportList')->middleware('auth')->name('beneficiarie-report-list');
    Route::get('ngo/show-beneficiarie-report/{beneficiarie_id}/survey/{survey_id}', 'showbeneficiariereport')->middleware('auth')->name('show-beneficiarie-report');
    Route::get('ngo/Survey-received-list', 'surveyrecivedlist')->middleware('auth')->name('survey-received-list');
    Route::post('/beneficiaries/facilities/bulk-store',  'storeBulkBeneficiarieFacilities')->middleware('auth')
        ->name('store-bulk-beneficiarie-facilities');
    Route::get('ngo/show-beneficiarie-token', 'showbeneficiarietoken')->middleware('auth')->name('show-beneficiarie-token');
    // Route::get('ngo/show-beneficiarie-token/{beneficiarie_id}/survey/{survey_id}', 'showbeneficiarietoken')->middleware('auth')->name('show-beneficiarie-token');
    Route::get('ngo/show-beneficiarie-receipt/{beneficiarie_id}/survey/{survey_id}', 'showbeneficiarieRecipt')->middleware('auth')->name('show-beneficiarie-receipt');
    Route::post('ngo/store-bulk-beneficiarie', 'storeBulkBeneficiarie')->middleware('auth')->name('store-bulk-beneficiarie');
    Route::post('ngo/store-bulk-distribute', 'storeBulkDistribute')->middleware('auth')->name('store-bulk-distribute');
    Route::post('ngo/store-bulk-distribute-status', 'storeBulkDistributeStatus')->middleware('auth')->name('store-bulk-distribute-status');
    Route::get('ngo/delete-distribute-facilities/{beneficiarie_id}/survey/{survey_id}', 'DeleteDistribueFacilities')->middleware('auth')->name('delete-distribute-facilities');
    Route::get('ngo/delete-distribute-facilities-status/{beneficiarie_id}/survey/{survey_id}', 'DeleteDistribueFacilitiesStatus')->middleware('auth')->name('delete-distribute-facilities-status');
    Route::get('ngo/delete-distribute-facilities-all/{beneficiarie_id}/survey/{survey_id}', 'deleteBeneficiarieFacilitiesAll')->middleware('auth')->name('delete-distribute-facilities-all');
});

Route::controller(WorkingAreaController::class)->group(function () {
    Route::get('ngo/working-area', 'workingarea')->middleware('auth')->name('working-area');
    Route::post('ngo/store-area', 'storeArea')->middleware('auth')->name('store-area');
    Route::get('ngo/working-area-list', 'workingAreaList')->middleware('auth')->name('working-area-list');
    Route::get('ngo/edit-area/{id}', 'editarea')->middleware('auth')->name('edit-area');
    Route::post('ngo/update-area/{id}', 'updatearea')->middleware('auth')->name('update-area');
    Route::get('ngo/delete-Working-area/{id}', 'removeArea')->middleware('auth')->name('remove-area');
});

Route::controller(NoticeController::class)->group(function () {
    Route::get('ngo/add-notice', 'addnotice')->middleware('auth')->name('add-notice');
    Route::post('ngo/store-notice', 'storeNotice')->middleware('auth')->name('store-notice');
    Route::get('ngo/notice-list', 'NoticeList')->middleware('auth')->name('notice-list');
    Route::get('ngo/view-notice/{id}', 'ViewNotice')->middleware('auth')->name('view-notice');
    Route::get('ngo/edit-notice/{id}', 'editNotice')->middleware('auth')->name('edit-notice');
    Route::post('ngo/update-notice/{id}', 'updateNotice')->middleware('auth')->name('update-notice');
    Route::get('ngo/delete-notice/{id}', 'deleteNotice')->middleware('auth')->name('delete-notice');
    Route::get('ngo/notice-status/{id}', 'NoticeStatus')->middleware('auth')->name('notice-status');
});

Route::controller(StaffController::class)->group(function () {
    Route::get('ngo/add-position', 'addPosition')->middleware('auth')->name('add.position');
    Route::post('ngo/store-sposition', 'StorePosition')->middleware('auth')->name('store.position');
    Route::get('ngo/delete-position/{id}', 'DeletePosition')->middleware('auth')->name('delete.position');
    Route::get('ngo/position-list', 'PositionList')->middleware('auth')->name('position.list');
    Route::get('ngo/add-staff', 'addstaff')->middleware('auth')->name('add-staff');
    Route::post('ngo/store-staff', 'StoreStaff')->middleware('auth')->name('store.staff');
    Route::get('ngo/edit-staff/{id}', 'EditStaff')->middleware('auth')->name('edit-staff');
    Route::post('ngo/update-staff/{id}', 'UpdateStaff')->middleware('auth')->name('update.staff');
    Route::get('ngo/delete-staff/{id}', 'DeleteStaff')->middleware('auth')->name('delete-staff');
    Route::get('ngo/staff-list', 'staffList')->middleware('auth')->name('staff-list');
    Route::get('ngo/view-staff/{id}', 'ViewStaff')->middleware('auth')->name('view-staff');
    Route::get('ngo/staff-letter-list', 'staffListLetter')->middleware('auth')->name('staff.list.letter');
    Route::get('ngo/view-appointment/{id}', 'ViewAppointment')->middleware('auth')->name('view.appointment.letter');
    Route::get('ngo/view-resign/{id}', 'ViewResign')->middleware('auth')->name('view.resign.letter');
});

Route::controller(SallaryController::class)->middleware('auth')->group(function () {
    Route::get('ngo/salary-list', 'SalaryList')->name('list.salary');
    Route::get('ngo/add-salary', 'ManageSalary')->name('manage.salary');
    Route::post('ngo/store-salary', 'StoreSalary')->name('store.salary');
    Route::get('ngo/edit-salary/{id}', 'EditSalary')->name('edit.salary');
    Route::post('ngo/update-salary/{id}', 'UpdateSalary')->name('update.salary');
    Route::get('ngo/delete-salary/{id}', 'DeleteSalary')->name('delete.salary');
    Route::get('ngo/staff-salary', 'StaffSalary')->name('staff.salary');
    Route::get('ngo/pay-salary/{id}', 'PaySalary')->name('pay.salary');
    Route::post('ngo/store-salary/{id}', 'storeSalaryPayment')->name('store.salary.payment');
    Route::post('ngo/unpaid-salary/{id}', 'unpaySalary')->name('unpaid.salary');
    Route::get('ngo/salary-tranctions/{id}', 'salaryTransactions')->name('salary.transactions');
    Route::get('ngo/staff-passbook/{id}', 'staffPassbook')->name('salary.passbook');
});

Route::controller(MemberController::class)->group(function () {
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

Route::controller(DonationController::class)->group(function () {
    Route::get('ngo/online-donor-list', 'onlineDonor')->middleware('auth')->name('online-donor-list');
    Route::get('ngo/donation-list', 'donationList')->middleware('auth')->name('donation-list');
    Route::get('ngo/donation', 'donation')->middleware('auth')->name('donation');
    Route::post('ngo/save-donation', 'saveDonation')->middleware('auth')->name('save-donation');
    Route::get('ngo/edit-donation/{id}', 'EditDonation')->middleware('auth')->name('edit-donation');
    Route::post('ngo/update-donation/{id}', 'updateDonation')->middleware('auth')->name('update-donation');
    Route::get('ngo/delete-donation/{id}', 'deleteDonation')->middleware('auth')->name('delete-donation');
    Route::get('ngo/view-donation/{id}', 'viewDonation')->middleware('auth')->name('view-donation');
    Route::get('ngo/donation-card/{id}', 'viewDonationCard')->middleware('auth')->name('view-donation-card');
    Route::get('ngo/donation-certificate/{id}', 'viewDonationCertificate')->middleware('auth')->name('certi-donation');
    Route::get('ngo/donation-card-list', 'donationCardList')->middleware('auth')->name('donation-card-list');
    Route::get('ngo/all-donor-list', 'allDonations')->middleware('auth')->name('all-donor-list');
    Route::get('ngo/dontaion-report', 'DonationReport')->middleware('auth')->name('dontaion-report');
});

Route::controller(TrainingCenterController::class)->group(function () {
    Route::get('ngo/add-center', 'AddCenter')->middleware('auth')->name('add-center');
    Route::post('ngo/store-center', 'storeCenter')->middleware('auth')->name('store-center');
    Route::get('ngo/center-list', 'CenterList')->middleware('auth')->name('center-list');
    Route::get('ngo/edit-center/{id}', 'EditCenter')->middleware('auth')->name('edit-center');
    Route::post('ngo/update-center/{id}', 'updateCenter')->middleware('auth')->name('update-center');
    Route::get('ngo/delete-center/{id}', 'DeleteCenter')->middleware('auth')->name('delete-center');
    Route::get('ngo/taining-demand-bene', 'AddBeneForCenter')->middleware('auth')->name('taining-demand-bene');
    Route::post('ngo/store-demand', 'storeTrainingDemand')->middleware('auth')->name('store-demand');
    Route::get('ngo/training-center', 'CenterListForbene')->middleware('auth')->name('taining-center-bene');
    Route::get('ngo/approve-training-demand-bene/{center_code}', [TrainingCenterController::class, 'ApproveBeneForTraining'])
        ->name('approve-taining-demand-bene');
    Route::get('ngo/training-present-list/{center_code}', [TrainingCenterController::class, 'TrainingBeneForPresent'])
        ->name('taining-bene-present-list');
    Route::get('ngo/training-fees-list/{center_code}', [TrainingCenterController::class, 'TrainingBeneForFee'])
        ->name('taining-bene-fess-list');
    Route::get('ngo/training-progress-list/{center_code}', [TrainingCenterController::class, 'TrainingBeneForprogress'])
        ->name('taining-bene-progress-list');
    Route::get('ngo/view-approve-training-bene/{id}/{center_code}', 'ShowApproveBeneTraining')->middleware('auth')->name('show-approve-bene-training');
    Route::get('ngo/genrate-training-certificate', 'GenrateTrainingCerti')->middleware('auth')->name('genrate-training-certi');
    Route::get('ngo/generate-tarining-certificate/{id}/{center_code}', 'GenrateTrainingCertificate')->middleware('auth')->name('genrate-training-certificate');
    Route::post('ngo/save-genrate-training-record', 'SaveGenrateTrainingCertificate')->middleware('auth')->name('save-genrate-training-record');
    Route::get('ngo/training-certificate-list', 'TrainingCerti')->middleware('auth')->name('training-certi-list');
    Route::get('ngo/tarining-certificate/{id}/{center_code}', 'TrainingCertificate')->middleware('auth')->name('training-certificate');
});

Route::controller(ExperienceController::class)->group(function () {
    Route::get('ngo/genrate-letter', 'GenrateLetter')->middleware('auth')->name('genrate-letter');
    Route::post('ngo/save-letter', 'saveLetter')->middleware('auth')->name('save-letter');
    Route::get('ngo/edit-letter/{id}', 'editLetter')->middleware('auth')->name('edit-letter');
    Route::post('ngo/update-letter/{id}', 'updateLetter')->middleware('auth')->name('update-letter');
    Route::get('ngo/delete-letter/{id}', 'deleteLetter')->middleware('auth')->name('delete-letter');
    Route::get('ngo/letter-list', 'LetterCerti')->middleware('auth')->name('letter-list');
    Route::get('ngo/letter-certificate/{id}', 'LetterCertificate')->middleware('auth')->name('letter');
});

Route::controller(SignatureController::class)->group(function () {
    Route::get('ngo/signature', 'addSignature')->middleware('auth')->name('signature');
    Route::post('ngo/save-signature', 'saveSignature')->middleware('auth')->name('save-signature');
});

Route::controller(IdcardController::class)->group(function () {
    Route::get('ngo/member-idcard', 'MemberIdcard')->middleware('auth')->name('member-idcard');
    Route::get('ngo/beneficiary-idcard', 'BeneficiaryIdcard')->name('beneficiary-idcard');
    Route::get('ngo/donor-idcard', 'DonorIdcard')->middleware('auth')->name('donor-idcard');
    Route::get('ngo/staff-idcard', 'StaffIdcard')->middleware('auth')->name('staff-idcard');
});

Route::controller(BillController::class)->group(function () {
    Route::get('ngo/add-bill', 'AddBill')->middleware('auth')->name('add-bill');
    Route::post('ngo/store-bill', 'StoreBill')->middleware('auth')->name('store-bill');
    Route::get('ngo/edit-bill/{id}', 'EditBill')->middleware('auth')->name('edit-bill');
    Route::post('ngo/update-bill/{id}', 'UpdateBill')->middleware('auth')->name('update-bill');
    Route::get('ngo/bill-list', 'BillList')->middleware('auth')->name('bill-list');
    Route::get('ngo/view-bill/{id}', 'ViewBill')->Middleware('auth')->name('view-bill');
    Route::get('ngo/delete-bill/{id}', 'DeleteBill')->middleware('auth')->name('delete-bill');
    Route::get('ngo/generate-person-bill', 'GeneratePersonBill')->middleware('auth')->name('generate-person-bill');
    Route::get('ngo/generate-bill', 'GenerateSansthaBill')->middleware('auth')->name('generate-sanstha-bill');
    Route::post('ngo/store-person-bill', 'StorePersonBill')->middleware('auth')->name('store-person-bill');
    Route::get('ngo/edit-person=bill/{id}', 'EditPersonBill')->middleware('auth')->name('edit-person-bill');
    Route::post('ngo/update-person-bill/{id}', 'UdatePersonBill')->middleware('auth')->name('update-person-bill');
    Route::get('ngo/delete-person-bill/{id}', 'DeletePersonBill')->middleware('auth')->name('delete-person-bill');
    Route::get('ngo/person-bill-list', 'PersonBillList')->middleware('auth')->name('person-bill-list');
    Route::get('ngo/view-person-bill/{id}', 'ViewPersonBill')->Middleware('auth')->name('view-person-bill');
    Route::post('ngo/store-gbs-bill', 'StoreGbsBill')->middleware('auth')->name('store-gbs-bill');
    Route::get('ngo/edit-gbs-bill/{id}', 'EditGbsBill')->middleware('auth')->name('edit-gbs-bill');
    Route::post('ngo/update-gbs-bill/{id}', 'UpdateGbsBill')->middleware('auth')->name('update-gbs-bill');
    Route::get('ngo/delete-gbs-bill/{id}', 'DeleteGbsBill')->middleware('auth')->name('delete-gbs-bill');
    Route::get('ngo/gbs-bill-list', 'GbsBillList')->middleware('auth')->name('gbs-bill-list');
    Route::get('ngo/view-gbs-bill/{id}', 'ViewGbsBill')->middleware('auth')->name('view-gbs-bill');
});

Route::controller(VendorController::class)->middleware('auth')->group(function () {
    Route::get('ngo/add-vendor', 'AddVendor')->name('add.vendor');
    Route::post('ngo/store-vendor', 'StoreVendor')->name('store.vendor');
    Route::get('ngo/vendor-list', 'VendorList')->name('vendor.list');
    Route::get('ngo/edit-vendor/{id}', 'EditVendor')->name('edit.vendor');
    Route::post('ngo/update-vendor/{id}', 'UpdateVendor')->name('update.vendor');
    Route::get('ngo/delete-vendor/{id}', 'DeleteVendor')->name('delete.vendor');
    Route::get('ngo/view-vendor/{id}', 'ViewVendor')->name('view.vendor');
});

Route::controller(WorkPlanController::class)->group(function () {
    Route::get('ngo/add-workplan', 'AddWorkPlan')->middleware('auth')->name('add-workplan');
    Route::post('ngo/store-workplan', 'StoreWorkPlan')->middleware('auth')->name('store-workplan');
    Route::get('ngo/edit-workplan/{id}', 'EditWorkPlan')->middleware('auth')->name('edit-workplan');
    Route::post('ngo/update-workplan/{id}', 'UpdateWorkPlan')->middleware('auth')->name('update-workplan');
    Route::get('ngo/workplan-list', 'WorkPlanList')->middleware('auth')->name('workplan-list');
    Route::get('ngo/view-workplan/{id}', 'ViewWorkPlan')->middleware('auth')->name('view-workplan');
    Route::get('ngo/delete-workplan/{id}', 'DeleteWorkPlan')->middleware('auth')->name('delete-workplan');
});

Route::controller(ProblemController::class)->group(function () {
    Route::get('ngo/add-problem', 'problem')->middleware('auth')->name('problem.add');
    Route::post('ngo/store-problem', 'StoreProblem')->middleware('auth')->name('store.problem');
    Route::get('ngo/edit-problem/{id}', 'EditProblem')->middleware('auth')->name('edit.problem');
    Route::post('ngo/update-problem{id}', 'UpdateProblem')->middleware('auth')->name('update.problem');
    Route::get('ngo/delete-problem/{id}', 'DeleteProblem')->middleware('auth')->name('delete.problem');
    Route::get('ngo/problem-list', 'ProblemList')->middleware('auth')->name('problem.list');
    Route::get('ngo/list-solution', 'ListForSolution')->middleware('auth')->name('list.for.solution');
    Route::get('ngo/solution/{id}', 'Solution')->middleware('auth')->name('solution');
    Route::post('ngo/store-solution/{id}', 'StoreSolution')->middleware('auth')->name('store.solution');
    Route::get('ngo/edit-solution/{id}', 'EditSolution')->middleware('auth')->name('edit.solution');
    Route::post('ngo/update-solution{id}', 'UpdateSolution')->middleware('auth')->name('update.solution');
    Route::get('ngo/delete-solution/{id}', 'DeleteSolution')->middleware('auth')->name('delete.solution');
    Route::get('ngo/solution-list', 'SolutionList')->middleware('auth')->name('solution.list');
    Route::get('ngo/view-problem/{id}', 'ViewProblem')->middleware('auth')->name('view.problem');
});

Route::controller(ProjectController::class)->group(function () {
    Route::get('ngo/add-project', 'AddProject')->middleware('auth')->name('add.project');
    Route::post('ngo/store-project', 'StoreProject')->middleware('auth')->name('store.project');
    Route::get('ngo/edit-project/{id}', 'EditProject')->middleware('auth')->name('edit.project');
    Route::post('ngo/update-project/{id}', 'UpdateProject')->middleware('auth')->name('update.project');
    Route::get('ngo/delete-project/{id}', 'DeleteProject')->middleware('auth')->name('delete.project');
    Route::get('ngo/view-project/{id}', 'ViewProject')->middleware('auth')->name('view.project');
    Route::get('ngo/project-list', 'ProjectList')->middleware('auth')->name('list.project');
    Route::get('ngo/add-project-report/{id}', 'AddProjectReport')->middleware('auth')->name('add.project.report');
    Route::post('ngo/store-project-report', 'StoreProjectReport')->middleware('auth')->name('store.project.report');
    Route::get('ngo/edit-project-report/{id}', 'EditProjectReport')->middleware('auth')->name('edit.project.report');
    Route::post('ngo/update-project-report/{id}', 'UpdateProjectReport')->middleware('auth')->name('update.project.report');
    Route::get('ngo/delete-project-report/{id}', 'DeleteProjectReport')->middleware('auth')->name('delete.project.report');
    Route::get('ngo/view-project-report/{id}', 'ViewProjectReport')->middleware('auth')->name('view.project.report');
    Route::get('ngo/project-list-report', 'ProjectReportList')->middleware('auth')->name('list.project.report');
});

Route::controller(OrganizationController::class)->group(function () {
    Route::get('ngo/add-head-organization', 'AddHeadOrg')->middleware('auth')->name('add.head.organization');
    Route::post('ngo/store-head-organization', 'StoreHeadOrg')->middleware('auth')->name('store.head.organization');
    Route::get('ngo/edit-head-organization/{id}', 'EditHeadOrg')->middleware('auth')->name('edit.head.organization');
    Route::post('ngo/update-head-organization/{id}', 'UpdateHeadOrg')->middleware('auth')->name('update.head.organization');
    Route::get('ngo/delete-head-organization/{id}', 'DeleteHeadOrg')->middleware('auth')->name('delete.head.organization');
    Route::get('ngo/organization-head-list', 'OrgHeadList')->middleware('auth')->name('list.head.organization');
    Route::get('ngo/add-organization', 'AddOrg')->middleware('auth')->name('add.organization');
    Route::post('ngo/store-organization', 'StoreOrg')->middleware('auth')->name('store.organization');
    Route::get('ngo/edit-organization/{id}', 'EditOrg')->middleware('auth')->name('edit.organization');
    Route::post('ngo/update-organization/{id}', 'UpdateOrg')->middleware('auth')->name('update.organization');
    Route::get('ngo/delete-organization/{id}', 'DeleteOrg')->middleware('auth')->name('delete.organization');
    Route::get('ngo/view-organization/{id}', 'ViewOrg')->middleware('auth')->name('view.organization');
    Route::get('ngo/organization-list', 'OrgList')->middleware('auth')->name('list.organization');
    Route::get('ngo/add-organization-member/{id}', 'AddOrgMember')->middleware('auth')->name('add.organization.member');
    Route::post('ngo/store-organization-member/{id}', 'StoreOrgMember')->middleware('auth')->name('store.organization.member');
    Route::get('ngo/organization-member-list', 'OrgMemberList')->middleware('auth')->name('list.organization.member');
    Route::get('ngo/view-organization-member/{id}', 'ViewOrgMember')->middleware('auth')->name('view.organization.member');
    Route::get('ngo/delete-organization-member/{id}', 'DeleteOrgMember')->middleware('auth')->name('delete.organization.member');
    Route::get('ngo/group-member-list/{id}', 'GroupMemberList')->middleware('auth')->name('list.group.member');
});

Route::controller(CashBookController::class)->middleware('auth')->group(function () {
    Route::get('ngo/income-list', 'IncomeList')->name('list.income');
    Route::get('ngo/expenditure-list', 'ExpenditureList')->name('expenditure.list');
    Route::get('ngo/balance-report', 'BalanceReportView')->name('balance.report.view');
    Route::get('ngo/generate-balance-report', 'generateMonthlyReport')->name('balance.report.generate');
    Route::get('ngo/income-expenditure-report', 'IncomeExpenditureReport')->name('income.expenditure.view');
});

Route::controller(CourseController::class)->middleware('auth')->group(function () {
    Route::get('ngo/course-list', 'CourseList')->name('list.course');
    Route::get('ngo/add-course', 'AddCourse')->name('add.course');
    Route::post('ngo/store-course', 'StoreCourse')->name('store.course');
    Route::get('ngo/delete-course/{id}', 'DeleteCourse')->name('delete.course');
});

Route::controller(JobController::class)->middleware('auth')->group(function () {
    Route::get('ngo/job-list', 'JobList')->name('list.job');
    Route::get('ngo/add-job', 'AddJob')->name('add.job');
    Route::post('ngo/store-job', 'StoreJob')->name('store.job');
    Route::get('ngo/edit-job/{id}', 'EditJob')->name('edit.job');
    Route::post('ngo/update-job/{id}', 'UpdateJob')->name('update.job');
    Route::get('ngo/delete-job/{id}', 'DeleteJob')->name('delete.job');
    Route::get('ngo/apply-candidate', 'ApplyCandidate')->name('apply.candidate');
});

Route::get('/apply-job/{id}', [JobController::class, 'Apply'])->name('apply.job');
Route::post('/store-vacancies', [JobController::class, 'StoreVacancies'])->name('vacancies.store');

Route::controller(StaffWorkController::class)->middleware('auth')->group(function () {
    Route::get('ngo/work-list', 'WorkList')->name('work.list');
    Route::get('ngo/work-view/{id}', 'WorkView')->name('work.view');
});

Route::middleware(['auth'])->group(function () {
    Route::get('ngo/upload-document', [DocumentController::class, 'index'])->name('form-downloads.index');
    Route::get('ngo/store-document', [DocumentController::class, 'create'])->name('form-downloads.create');
    Route::post('ngo/form-downloads', [DocumentController::class, 'store'])->name('form-downloads.store');
    Route::get('ngo/form-downloads/{id}/download', [DocumentController::class, 'download'])->name('form-downloads.download');
    Route::delete('/form-downloads/{id}', [DocumentController::class, 'destroy'])->name('form-downloads.destroy');
});
Route::get('ngo/form-downloads/{id}/preview', [DocumentController::class, 'preview'])->name('form-downloads.preview');
Route::controller(StaffWorkController::class)->middleware('auth')->group(function () {
    Route::get('ngo/survey-start', 'Survey')->name('survey.start');
    Route::post('ngo/survey-store', 'StoreSurvey')->name('store.survey');
    Route::get('ngo/edit-survey/{id}', 'editSurvey')->name('survey.edit');
    Route::post('ngo/update-survey/{id}', 'UpdateSurvey')->name('update.survey');
    Route::get('ngo/view-survey/{id}', 'ViewSurvey')->name('survey.show');
    Route::get('ngo/survey-delete/{id}', 'SurveyDelete')->name('survey.delete');
    Route::get('ngo/survey-list', 'SurveyList')->name('survey.list');
    Route::get('ngo/check-survey-identity', [StaffWorkController::class, 'checkIdentity'])->name('check.survey.identity');
    Route::get('ngo/check-document', 'CheckDocument')->name('Survey.CheckDocument');
    Route::post('ngo/update-document-checkbox', [StaffWorkController::class, 'updateCheckbox'])->name('update-document-checkbox');
    Route::post('ngo/{benefresSurveyId}/update-document', [StaffWorkController::class, 'updateDocuments'])->name('update-document');
});

Route::middleware(['auth'])->group(function () {
    Route::get('ngo/true-story', [StoryController::class, 'TrueStory'])->name('true.story');
    Route::get('ngo/add-story', [StoryController::class, 'AddStory'])->name('add-story');
    Route::post('ngo/save-story', [StoryController::class, 'store'])->name('save-story');
    Route::get('ngo/delete-story/{id}', [StoryController::class, 'DeleteStory'])->name('delete-story');
});

Route::controller(HealthCardController::class)->middleware('auth')->group(function () {
    Route::get('ngo/add-disease', 'AddDisease')->name('add.disease');
    Route::get('ngo/delete-disease/{id}', 'DeleteDisease')->name('delete.disease');
    Route::post('ngo/disease/store', 'StoreDisease')->name('store.disease');
    Route::delete('ngo/disease/{id}', 'DestroyDisease')->name('disease.delete');
    Route::get('ngo/list-hospital', 'ListHospital')->name('list.hospital');
    Route::get('ngo/add-hospital', 'AddHospital')->name('add.hospital');
    Route::post('ngo/hospital/store', 'StoreHospital')->name('store.hospital');
    Route::get('ngo/edit-hospital/{id}', 'EditHospital')->name('edit.hospital');
    Route::post('ngo/hospital/update/{id}', 'UpdateHospital')->name('update.hospital');
    Route::get('ngo/delete-hospital/{id}', 'deleteHospital')->name('delete.hospital');
    Route::get('ngo/list-generate-healthcard', 'RegList')->name('generatelist.healthcard');
    Route::get('ngo/generate-healthcard/{id}/{type}', 'GenerateHealthCard')->name('generate.healthcard');
    Route::post('ngo/healthcard/store', 'StoreHealthCard')->name('healthcard.store');
    Route::get('ngo/edit-healthcard/{health_id}/edit', 'EditHealthCard')->name('healthcard.edit');
    Route::post('ngo/update-healthcard/{health_id}', 'UpdateHealthCard')->name('healthcard.update');
    Route::get('ngo/healthcard-list', 'CardList')->name('list.healthcard');
    Route::get('ngo/show-healthcard/{id}/{health_id}', 'ShowHealthCard')->name('show.healthcard');
    Route::get('ngo/demand-facility-list', 'DemandFacilityList')->name('list.demandfacility');
    Route::get('ngo/demand-health-facility/{id}/{health_id}', 'DemandFacility')->name('demand.health.facility');
    Route::post('ngo/health-facility/store', 'StoreDemandFacilities')->name('health.facility.store');
    Route::get('ngo/edit-health-facility/{facility}', 'EditFacility')->name('edit.healthfacility');
    Route::post('ngo/health-facility/update/{id}', 'UpdtaeDemandFacilities')->name('health.facility.update');
    Route::get('ngo/delete-health-facility/{facility}', 'DeleteFacility')->name('delete.healthfacility');
    Route::get('ngo/pending-facility-list', 'PendingFacilityList')->name('list.pendingfacility');
    Route::post('ngo/health-facility-investigation/store/{facility}', 'StoreFacilitiesInvestigation')->name('investigation.healthfacility.store');
    Route::get('ngo/pending-healthfacility/{facility}', 'ShowPendingFacility')->name('pending.healthfacility.show');
    Route::get('ngo/Investigation-facility-list', 'InvestigationFacilityList')->name('list.Investigationfacility');
    Route::get('ngo/verify-facility-list', 'VerifyFacilityList')->name('list.Verifyhealthfacility');
    Route::post('ngo/health-facility-verify/store/{facility}', 'StoreFacilitiesVerify')->name('verify.healthfacility.store');
    Route::post('ngo/facility-investigation-form/store/{facility}', 'StoreInvestigationForm')->name('investigation.form.store');
    Route::get('ngo/Investigation-facility-delete/{facility}', 'DeleteFacilitiesInvestigation')->name('delete.Investigationfacility');
    Route::get('ngo/show-healthfacility-investigation/{facility}', 'ShowPendingInvestigationForm')->name('investigation.healthfacility.show');
    Route::get('ngo/approvel-facility-list', 'ApprovelFacilityList')->name('list.Approvalhealthfacility');
    Route::get('ngo/show-healthfacility-investigation-form/{facility}', 'ShowInvestigationForm')->name('healthfacility.investigation.form.show');
    Route::get('ngo/reject-healthfacility-investigation-form/{facility}', 'RejectInvestigationForm')->name('healthfacility.investigation.form.reject');
    Route::post('ngo/facility-verify/store/{facility}', 'StoreVerifyHealth')->name('verify.healthfacility.store');
    Route::get('ngo/show-healthfacility-verify-form/{facility}', 'ShowVerifyForm')->name('healthfacility.verify.form.show');
    Route::post('ngo/facility-status/store/{facility}', 'StoreHealthFacilitiesStatus')->name('status.healthfacility.store');
    Route::get('ngo/approve-facility-list', 'ApproveFacilityList')->name('list.Approvehealthfacility');
    Route::get('ngo/non-budget-facility-list', 'NonBudgetFacilityList')->name('list.NonBudgethealthfacility');
    Route::get('ngo/reject-facility-list', 'RejectFacilityList')->name('list.Rejecthealthfacility');
    Route::get('ngo/demandpending-facility-list', 'DemandPendingFacilityList')->name('list.DemandPendinghealthfacility');
    Route::get('ngo/show-healthfacility-final-form/{facility}', 'ShowFinalForm')->name('healthfacility.final.form.show');
});

Route::controller(EduactionCardController::class)->middleware('auth')->group(function () {
    Route::get('ngo/education-reg', 'RegList')->name('eduaction.reg.list');
    Route::get('ngo/add-class', 'AddClass')->name('add.class');
    Route::post('ngo/store-class', 'StoreClass')->name('store.class');
    Route::get('ngo/delete-class/{id}', 'DeleteClass')->name('delete.class');
    Route::get('ngo/add-school', 'AddSchool')->name('add.school');
    Route::post('ngo/store-school', 'StoreSchool')->name('store.school');
    Route::get('ngo/edit-school/{id}', 'EditSchool')->name('edit.school');
    Route::post('ngo/update-school/{id}', 'UpdateSchool')->name('update.school');
    Route::get('ngo/delete-school/{id}', 'DeleteSchool')->name('delete.school');
    Route::get('ngo/list-school', 'SchoolList')->name('list.school');
    Route::get('ngo/add-student', 'AddStudent')->name('add.student');
    Route::post('ngo/store-student', 'StoreStudent')->name('store.student');
    Route::get('ngo/edit-student/{id}', 'EditStudent')->name('edit.student');
    Route::post('ngo/update-student/{id}', 'UpdateStudent')->name('update.student');
    Route::get('ngo/list-student', 'StudentList')->name('list.student');
    Route::get('ngo/generate-educationcard/{id}/{type}', 'GenerateEducationCard')->name('generate.educationcard');
    Route::post('ngo/educationcard/store', 'StoreEducationCard')->name('educationcard.store');
    Route::get('ngo/edit-educationcard/{id}', 'EditEducationCard')->name('edit.educationcard');
    Route::post('ngo/educationcard/update/{id}', 'UpdateEducationCard')->name('educationcard.upate');
    Route::get('ngo/education-card-list', 'EducationCardList')->name('eduaction.card.list');
    Route::get('ngo/show-education-card/{id}/{education_id}', 'ShowEducationCard')->name('show.educationcard');
    Route::get('ngo/delete-educationcard/{id}', 'DeleteEducationCard')->name('delete.educationcard');
    Route::get('ngo/education-demand-list', 'EducationDemandList')->name('eduaction.demand.list');
    Route::get('ngo/demand-education-facility/{id}/{education_id}', 'DemandEducationFacility')->name('demand.education.facility');
    Route::post('ngo/store-demand-education-facility', 'StoreDemandFacility')->name('demand.education.facility.store');
    Route::get('ngo/education-demand-pending-list', 'EducationDemandPendingList')->name('eduaction.demand.pending.list');
    Route::get('ngo/edit-demand-education-facility/{facility}', 'EditFacility')->name('demand.education.facility.edit');
    Route::post('ngo/update-demand-education-facility', 'UpdateDemandFacility')->name('demand.education.facility.update');
    Route::delete('ngo/demand/education/facility/{id}','DeleteDemandFacility')->name('demand.education.facility.delete');
    Route::get('ngo/show-demand-education-facility/{facility}', 'ShowFacility')->name('demand.education.facility.show');

});

Route::controller(KycController::class)->middleware('auth')->group(function () {
    Route::get('ngo/beneficiarie-list-for-kyc', 'BeneficiarieListForKyc')->name('list-for-kyc');
    Route::get('ngo/beneficiarie-kyc/{id}', 'BeneficiarieKyc')->name('beneficiare-kyc');
    Route::post('ngo/kyc-store/{id}', 'StoreKyc')->name('kyc.store');
    Route::get('ngo/edit-beneficiarie-kyc/{id}/{kyc_id}', 'EditBeneficiarieKyc')->name('edit-beneficiare-kyc');
    Route::post('ngo/kyc-update/{id}', 'UpdateKyc')->name('kyc.update');
    Route::get('ngo/pending-list-kyc', 'PendingKycList')->name('list.pending.kyc');
    Route::post('ngo/store-kyc-status/{id}', 'StoreKycStatus')->name('kyc.store.status');
    Route::get('ngo/approve-list-kyc', 'ApproveKycList')->name('list.approve.kyc');
    Route::get('ngo/reject-list-kyc', 'RejectKycList')->name('list.reject.kyc');
    Route::get('ngo/show-kyc/{id}/{kyc_id}', 'ShowKyc')->name('show.kyc');
    Route::get('ngo/delete-kyc/{id}/{kyc_id}', 'DeleteKyc')->name('delete-beneficiare-kyc');
});



require __DIR__ . '/auth.php';
