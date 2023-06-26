<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Containers\SMS\SmsService;
// use App\Http\Controllers\AuthController;
// Route::resource('auth', AuthController::class);
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

// Route::get('/', function () {
//     return view('frontend.home');
// });



Route::get('/change_language/{local}', function($locale) {
    if (! in_array($locale, ['en', 'ko'])) {
        abort(404);
    }
    App::setLocale($locale);
    Session::put('applocale', $locale);
    return redirect()->back();
})->name('change-language');

Route::get('/', 'HomeController@index')->name('home');
Route::get('/event/{slug}', 'HomeController@eventDetail')->name('event-detail');
Route::get('/magazine/{slug}', 'HomeController@magazineDetail')->name('magazine-detail');
Route::get('/see-all/{type}', 'HomeController@seeAllPost')->name('see-all-post');
// social login
Route::get('/kakao/login', function () {
    return Socialite::driver('kakao')->redirect();
})->name('login-kakao');
Route::get('/social/kakao', 'AuthController@kakao')->name('kakao-login');

Route::get('/naver/login', function () {
    return Socialite::driver('naver')->redirect();
})->name('login-naver');
Route::get('/social/naver', 'AuthController@naver')->name('naver-login');
// social login

Route::get('/edit/{id}', 'HomeController@edit')->name('edit-home');
// Route::resource('/auth', 'AuthController');

Route::get('/term_and_conditions', 'HomeController@term_and_conditions')->name('term_and_conditions');
Route::get('/privacy_policy', 'HomeController@privacy_policy')->name('privacy_policy');

Route::middleware(['guestmiddleware'])->group( function(){
// Signup
Route::get('/signup', 'AuthController@signup')->name('signup');
Route::post('/signupSubmit', 'AuthController@signupSubmit')->name('signup-submit');
Route::get('/emailsent/{id}', 'AuthController@emailsent')->name('emailsent');
Route::get('/emailVerfication/{id}', 'AuthController@emailVerfication')->name('emailVerfication');
Route::get('/resend_verification_signup_link', 'AuthController@resend_verification_signup_link')->name('resend_verification_signup_link');
Route::get('/user_reg_succes', 'AuthController@user_reg_succes')->name('user_reg_succes');

// login 
Route::post('/login', 'AuthController@login')->name('login');

// Forgot-password & reset-password
Route::post('/forgot_password', 'AuthController@forgot_password')->name('forgot_password');
Route::get('/reset_password/{token}', 'AuthController@reset_password')->name('reset_password');

Route::get('/forgot_email_sent/{id}', 'AuthController@forgot_email_sent')->name('forgot_email_sent');
Route::post('/update_password', 'AuthController@update_password')->name('update_password');
Route::get('/resend_forgot_link', 'AuthController@resend_forgot_link')->name('resend_forgot_link');
Route::get('/forgot_password_success', 'AuthController@forgot_password_success')->name('forgot_password_success');


// set passwod hotel manager/staff
Route::get('/set_your_password/{token}', 'AuthController@set_your_password')->name('set_your_password');
Route::post('/set_password', 'AuthController@set_password')->name('set_password');
Route::get('/set_password_success', 'AuthController@set_password_success')->name('set_password_success');
Route::post('/resend_signup_link', 'AuthController@resend_signup_link')->name('resend_signup_link');

});

Route::get('/hotel-list', 'HomeController@hotelList')->name('hotel-list');
Route::get('/hotel-detail/{slug}', 'HomeController@hotelDetail')->name('hotel-detail');
Route::get('/room-checkout', 'HomeController@roomCheckout')->name('room-checkout');
Route::get('/room-payment', 'HomeController@roomPayment')->name('room-payment');
Route::post('/confirm-booking', 'HomeController@confirmBooking')->name('confirm-booking');
Route::post('/direct-bank-transfer', 'HomeController@directBankTransferSubmit')->name('direct-bank-transfer');
Route::post('/apply-coupon', 'CouponCtrl@applyCoupon')->name('apply-coupon');
Route::post('/remove-coupon', 'CouponCtrl@removeCoupon')->name('remove-coupon');
Route::post('/hotel-enquiry', 'EnquiryController@store')->name('hotel-enquiry');
// logout
Route::get('/logout', 'AuthController@logout')->name('logout');
Route::get('/email_changed_succes', 'AuthController@email_changed_succes')->name('email_changed_succes');
Route::get('/changeEmailVerfied/{token}', 'AuthController@changeEmailVerfied')->name('changeEmailVerfied');
Route::post('/newsletter-subscribe', 'NewsLetterCtrl@subscribe')->name('newsletter-subscribe');


Route::get('/dashboard', 'DashboardCtrl@dashboard')->name('dashboard'); 
Route::post('/room-utilization-rate', 'DashboardCtrl@roomUtilizationRateRange')->name('room-utilization-rate'); 
// step-1
// Route::get('/hmstep2', 'HotelController@hmstep2')->name('hmstep2'); // step-2
// Route::get('/hmstep3', 'HotelController@hmstep3')->name('hmstep3'); // step-3
// Route::get('/hmstep4', 'HotelController@hmstep4')->name('hmstep5'); // step-4
// Route::get('/hmstep5', 'HotelController@hmstep5')->name('hmstep5'); // step-5
// Route::get('/hmstep6', 'HotelController@hmstep6')->name('hmstep6'); // step-6

Route::middleware(['adminmiddleware'])->group( function(){
    Route::get('/hotel_setup', 'AdminController@hotel_setup')->name('hotel_setup'); // admin stetp 
    Route::post('/staff_input_submit', 'AdminController@staff_input_submit')->name('staff_input_submit'); //admin hotel_staff_input submit
    Route::get('/hotel_staff_input', 'AdminController@hotel_staff_input')->name('hotel_staff_input'); //admin hotel_staff_input
    Route::get('/hotel_staff_input/{id}', 'AdminController@hotel_staff_input')->name('hotel_staff_input'); //admin hotel_staff_input
    Route::get('/staff_management/{id}', 'AdminController@staff_management')->name('staff_management'); // admin staff managment 
    Route::get('/hotel_managment', 'AdminController@hotel_managment')->name('hotel_managment'); // hotel listing in admin 
    Route::get('/customer_management', 'AdminController@customer_management')->name('customer_management'); // customer listing in admin 
    Route::get('/customer_status/{id}/{status}', 'AdminController@customer_status')->name('customer_status'); // customer update status 
    Route::get('/manager_status/{id}/{status}', 'AdminController@manager_status')->name('manager_status'); // customer update status 
    Route::get('/staff_status/{id}/{status}', 'AdminController@staff_status')->name('staff_status'); // customer update status 
    Route::post('/hotel_setup_submit', 'AdminController@hotel_setup_submit')->name('hotel_setup_submit'); // hotel listing in admin 
    Route::post('/customer_input_submit', 'AdminController@customer_input_submit')->name('customer_input_submit'); //admin hotel_staff_input submit
    Route::get('/customer_input/{id}', 'AdminController@customer_input')->name('customer_input'); //admin hotel_staff_input
    Route::get('/reward-details/{id}', 'AdminController@rewardDetails')->name('reward-details'); //admin can see user reward-history  
    Route::post('/credit-debit-reward', 'AdminController@rewardCreditDebit')->name('credit-debit-reward'); //admin can update user reward-points  
    Route::get('/del-ratingreview/{id}', 'RatingReviewCtrl@delete_ratingreview')->name('del-ratingreview');
    // Coupon Managment 
    Route::get('/rating-review-list', 'RatingReviewCtrl@index')->name('rating-review-list');
    Route::post('/rating-review-list', 'RatingReviewCtrl@index')->name('rating-review-list');
    // Route::get('/facilities-input', 'FacilitiesCtrl@facilitiesInput')->name('facilities-input'); //admin facilities-add
    Route::get('/facilities-input/{id}', 'FacilitiesCtrl@facilitiesInput')->name('facilities-input'); //admin facilities-add-edit
    Route::post('/facilities-input-submit', 'FacilitiesCtrl@facilitiesInputSubmit')->name('facilities-input-submit'); //admin facilities-add-edit
    Route::get('/facilities-list', 'FacilitiesCtrl@index')->name('facilities-list'); // admin facilities-list 
    Route::get('/facilities-status/{id}/{status}', 'FacilitiesCtrl@facilitiesStatus')->name('facilities-status'); // admin facilities-list 
    // Route::get('/amenities-input', 'FeaturesCtrl@amenitiesInput')->name('amenities-input'); //admin amenities-add
    Route::post('/amenitie-input-submit', 'FeaturesCtrl@featuresInputSubmit')->name('amenitie-input-submit'); //admin facilities-add-edit
    Route::get('/amenities-input/{id}', 'FeaturesCtrl@featuresInput')->name('amenities-input'); //admin amenities-edit
    Route::get('/amenities-list', 'FeaturesCtrl@index')->name('amenities-list'); // admin amenities-list 
    Route::get('/amenities-status/{id}/{status}', 'FeaturesCtrl@featuresStatus')->name('amenities-status');
    // Post Managment
    Route::get('/post-management', 'AdminPostController@index')->name('admin-post-list'); //admin post-list
    Route::get('/post-create', 'AdminPostController@create')->name('admin-post-create'); //admin post-add
    Route::get('/post-edit/{id}', 'AdminPostController@edit')->name('admin-post-edit'); //admin post-edit
    Route::post('/post-update/{id}', 'AdminPostController@update')->name('admin-post-update'); //admin post-update
    Route::post('/post-store', 'AdminPostController@store')->name('admin-post-store'); //admin post-store
    Route::post('/post-delete', 'AdminPostController@destroy')->name('admin-post-destroy'); //admin post-destroy
    // Coupon Managment 
    Route::get('/system-configuration-list', 'SystemConfigurationCtrl@index')->name('system-configuration-list');
    Route::get('/system-configuration-edit/{type}', 'SystemConfigurationCtrl@SystemConfigurationCtrl')->name('system-configuration-edit');
    Route::post('/system-configuration-update', 'SystemConfigurationCtrl@systemConfigurationUpdate')->name('system-configuration-update');

    Route::get('/ediotrs-pick/{id}/{status}', 'AdminController@isEitdorPicks')->name('ediotrs-pick');

    Route::get('/payout-mark-paid/{id}', 'PayoutCtrl@payoutMarkPaid')->name('payout-mark-paid');

    Route::get('/newsletter-list', 'NewsLetterCtrl@index')->name('newsletter-list'); // admin newsletter-list 
    Route::get('/newsletter-status/{id}/{status}', 'NewsLetterCtrl@status')->name('newsletter-status');

    Route::post('/uploadFeatureIcon', 'FeaturesCtrl@uploadFeatureIcon')->name('uploadFeatureIcon');
    Route::post('/delFeatureIcon', 'FeaturesCtrl@delFeatureIcon')->name('delFeatureIcon');
    
});


Route::middleware(['managermiddleware'])->group( function(){
// Hotel managment 
Route::post('/hm_basic_info_submit', 'HotelController@hm_basic_info_submit')->name('hm_basic_info_submit'); // hotel listing in admin 
Route::post('/hm_policies_submit', 'HotelController@hm_policies_submit')->name('hm_policies_submit'); // hotel policies_submit 
Route::post('/hm_addressNAttractions_submit', 'HotelController@hm_addressNAttractions_submit')->name('hm_addressNAttractions_submit'); // hotel listing in admin 
Route::post('/hm_feNfa_submit', 'HotelController@hm_feNfa_submit')->name('hm_feNfa_submit'); // hotel features & facilitie submit next 
Route::post('/select_features', 'HotelController@select_features')->name('select_features'); // select features
Route::post('/select_facilities', 'HotelController@select_facilities')->name('select_facilities'); // select features
Route::post('/delete_feature', 'HotelController@delete_feature')->name('delete_feature'); // delete features
Route::post('/delete_facilitie', 'HotelController@delete_facilitie')->name('delete_facilitie'); // delete facilitie

// Hotel managment admin/hotel 
Route::get('/hm_basic_info/{id}', 'HotelController@hm_basic_info')->name('hm_basic_info'); 
Route::get('/hm_addressNAttractions/{id}', 'HotelController@hm_addressNAttractions')->name('hm_addressNAttractions'); 
Route::get('/hm_policies/{id}', 'HotelController@hm_policies')->name('hm_policies'); 
Route::get('/hm_FeaturesNFacilities/{id}', 'HotelController@hm_FeaturesNFacilities')->name('hm_FeaturesNFacilities'); 
Route::get('/hm_otherInfo/{id}', 'HotelController@hm_otherInfo')->name('hm_otherInfo'); 
Route::post('/hm_otherInfo_submit', 'HotelController@hm_otherInfo_submit')->name('hm_otherInfo_submit'); 
Route::get('/hm_summary/{id}', 'HotelController@hm_summary')->name('hm_summary'); 
Route::post('/hm_summary_submit', 'HotelController@hm_summary_submit')->name('hm_summary_submit'); 
Route::get('/hm_bankinfo/{id}', 'HotelController@hm_bankinfo')->name('hm_bankinfo'); 
Route::post('/hm_bankinfo_submit', 'HotelController@hm_bankinfo_submit')->name('hm_bankinfo_submit'); 

Route::post('/uploadHotelLogo', 'HotelManagementCtrl@uploadHotelLogo')->name('uploadHotelLogo');
Route::post('/delHotelLogo', 'HotelManagementCtrl@delHotelLogo')->name('delHotelLogo');

Route::post('/uploadHotelOtherImages', 'HotelManagementCtrl@uploadHotelOtherImages')->name('uploadHotelOtherImages');
Route::post('/delHotelOtherImg', 'HotelManagementCtrl@delHotelOtherImg')->name('delHotelOtherImg');
Route::post('/markFeaturedHotelImg', 'HotelManagementCtrl@markFeaturedHotelImg')->name('markFeaturedHotelImg');
Route::post('/delNTA', 'HotelManagementCtrl@delNTA')->name('delNTA'); // Delete NTA 

Route::post('/delES', 'HotelManagementCtrl@delES')->name('delES'); // Delete ES
Route::post('/delLSD', 'HotelManagementCtrl@delLSD')->name('delLSD'); // Delete LSD
Route::post('/delPS', 'HotelManagementCtrl@delPS')->name('delPS'); // Delete PS

// Room listing  getCalendarData
Route::get('/rooms', 'RoomsController@index')->name('rooms');
Route::get('/room-calendar', 'RoomsController@roomCalendar')->name('room-calendar');
// Route::get('/get-calendar-data', 'RoomsController@getCalendarData')->name('get-calendar-data');
Route::post('/get-calendar-data', 'RoomsController@getCalendarData')->name('get-calendar-data');
Route::post('/room-block-unblock', 'RoomsController@roomBlockUnBlock')->name('room-block-unblock');
// Room step-1
Route::get('/room_basic_info/{slug}', 'RoomsController@rm_basic_info')->name('room_basic_info');
Route::post('/room_basicinfo_submit', 'RoomsController@rm_basic_info_submit')->name('room_basicinfo_submit'); 
Route::post('/uploadRoomOtherImages', 'RoomsController@uploadRoomOtherImages')->name('uploadRoomOtherImages');
Route::post('/delRoomOtherImg', 'RoomsController@delRoomOtherImg')->name('delRoomOtherImg');
Route::post('/markFeaturedRoomImg', 'RoomsController@markFeaturedRoomImg')->name('markFeaturedRoomImg');

// Room step-2
Route::get('/room_beds_info/{slug}', 'RoomsController@rm_beds_info')->name('room_beds_info');
Route::post('/room_beds_info_submit', 'RoomsController@rm_beds_info_submit')->name('room_beds_info_submit'); 
Route::post('/delBed', 'RoomsController@delBed')->name('delBed'); 

// Room step-3
Route::get('/room_features_n_facilities/{slug}', 'RoomsController@rm_features_n_facilities')->name('room_features_n_facilities');
Route::post('/room_features_n_facilities_submit', 'RoomsController@rm_features_n_facilities_submit')->name('room_features_n_facilities_submit'); 

// Room step-4
Route::get('/room_occupancy_n_pricing/{slug}', 'RoomsController@rm_occupancy_n_pricing')->name('room_occupancy_n_pricing');
Route::post('/room_occupancy_n_pricing_submit', 'RoomsController@rm_occupancy_n_pricing_submit')->name('room_occupancy_n_pricing_submit'); 

// Room step-5
Route::get('/room_summary/{slug}', 'RoomsController@rm_summary')->name('room_summary');
Route::post('/room_summary_save', 'RoomsController@rm_summary_save')->name('room_summary_save');
Route::get('/room_status/{slug}/{status}', 'RoomsController@room_status')->name('room_status');

// Coupon Managment 
Route::get('/coupon-list', 'CouponCtrl@index')->name('coupon-list');
Route::post('/coupon-list', 'CouponCtrl@index')->name('coupon-list');
Route::get('/coupon-input/{slug}', 'CouponCtrl@input')->name('coupon-input');
Route::post('/coupon-input-submit', 'CouponCtrl@inputSubmit')->name('coupon-input-submit');
Route::get('/del-coupon/{slug}', 'CouponCtrl@delete_coupon')->name('del-coupon');

Route::post('/apply-additional-discount', 'BookinController@applyAdditionalDiscount')->name('apply-additional-discount');
Route::post('/remove-additional-discount', 'BookinController@removeAdditionalDiscount')->name('remove-additional-discount');

//booking 
Route::get('/edit-booking/{slug}', 'BookinController@editBooking')->name('edit-booking');
Route::post('/edit-booking-submit', 'BookinController@editBookingSubmit')->name('edit-booking-submit');
Route::get('/create-booking', 'BookinController@createBooking')->name('create-booking');
Route::post('/create-booking-submit', 'BookinController@createBookingSubmit')->name('create-booking-submit');
Route::get('/cancel-create-booking', 'BookinController@cancelCreateBooking')->name('cancel-create-booking');

Route::post('/create-booking-step1', 'BookinController@createBookingStep1')->name('create-booking-step1');
Route::post('/create-booking-step2', 'BookinController@createBookingStep2')->name('create-booking-step2');
Route::post('/create-booking-step3', 'BookinController@createBookingStep3')->name('create-booking-step3');
Route::post('/create-booking-step4', 'BookinController@createBookingStep4')->name('create-booking-step4');

// My-Payouts listing 
Route::get('/my-payouts', 'PayoutCtrl@myPayouts')->name('my-payouts');
Route::post('/my-payouts', 'PayoutCtrl@myPayouts')->name('my-payouts');
Route::get('/payout-details/{slug}', 'PayoutCtrl@payoutDetails')->name('payout-details');

});

Route::get('/hm_cancel', 'HotelController@hm_cancel')->name('hm_cancel');
Route::post('/markunmarkfavorite', 'MyFavoriteCtrl@myFavoriteToggle')->name('markunmarkfavorite');
Route::get('/mark-booking-completed-cronjob', 'BookinController@markBookingComplete')->name('mark-booking-completed-cronjob');
Route::get('/payout-generate-cronjob', 'PayoutCtrl@payoutGenerate')->name('payout-generate-cronjob');
Route::get('/payout-test', 'PayoutCtrl@index')->name('payout-test');



Route::middleware(['authmiddleware'])->group( function(){
    
    // Customer-profile
    Route::get('/my_profile', 'CustomerController@my_profile')->name('my_profile');
    Route::post('/update_myprofile', 'CustomerController@update_myprofile')->name('update_myprofile');
    Route::post('/update_profilepic', 'AuthController@update_profilepic')->name('update_profilepic');
    Route::post('/uploadProfilePic', 'CustomerController@uploadProfilePic')->name('uploadProfilePic');
    Route::post('/deleteMyProfilePic', 'CustomerController@deleteMyProfilePic')->name('deleteMyProfilePic');
    Route::post('/email_change_req', 'CustomerController@email_change_req')->name('email_change_req');
    
    Route::get('/deleteMyAcccount', 'CustomerController@deleteMyAcccount')->name('deleteMyAcccount');
    
    // change-password
    Route::post('/change_password', 'AuthController@change_password')->name('change_password');
    // my-favorites list
    Route::get('/my-favorites', 'MyFavoriteCtrl@index')->name('my-favorites');
    Route::get('/my-rewards', 'RewardCtrl@index')->name('my-rewards');
    Route::get('/my-bookings', 'BookinController@customerBooking')->name('my-bookings');
    Route::get('/booking-detail/{slug}', 'BookinController@bookingDetails')->name('booking-detail');
    Route::post('/booking-cancel', 'BookinController@bookingCancel')->name('booking-cancel');
    Route::get('/bookings', 'BookinController@hotelBooking')->name('bookings');
    Route::post('/payment-make-confirm', 'BookinController@paymentMakeConfirm')->name('payment-make-confirm');

    Route::get('/rating-review/{slug}', 'RatingReviewCtrl@saveRating')->name('rating-review');
    Route::post('/submit-rating-review', 'RatingReviewCtrl@submitRating')->name('submit-rating-review');
    Route::post('/submit-rating-review', 'RatingReviewCtrl@submitRating')->name('submit-rating-review');
    // 
    Route::post('/save-refund-bankinfo', 'BookinController@saveRefundBankInfo')->name('save-refund-bankinfo');
    Route::post('/refund-booking-amount', 'BookinController@refundBookingAmount')->name('refund-booking-amount');
    Route::get('/notification-setting', 'NotificationSettingCtrl@index')->name('notification-setting');
    Route::get('/my-notifications', 'NotificationCtrl@index')->name('my-notifications');
    Route::post('/save-notification-setting', 'NotificationSettingCtrl@update')->name('save-notification-setting');

    Route::get('/chat', 'ChatController@index')->name('chat');
    Route::post('/chat/sendMessage', 'ChatController@store')->name('chat.store');
    Route::get('/chat/getMessages', 'ChatController@getMessages')->name('chat.getMessages');

    Route::get('/chat/search', 'ChatController@search')->name('chat.search');
});
 
Route::get('/test-sms', function (SmsService $smsService) {
    $response = $smsService->send('1051337362', 'Test SMS');
    dd($response);
});