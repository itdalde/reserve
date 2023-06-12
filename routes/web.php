<?php

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


/**
 * Auth routes
 */

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\ConfirmController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\OccasionController;
use App\Http\Controllers\SchedulesController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
Route::get('lang/{lang}', [LanguageController::class, 'switchLang'])->name('lang.switch');
Route::get('/schedules/delete-schedule', [\App\Http\Controllers\SchedulesController::class, 'deleteSchedule'])->name('schedules.delete-schedule');

Route::get('/fetch-available-dates-per-service', [\App\Http\Controllers\AvailableDatesController::class, 'availableDates'])->name('fetch-available-dates-per-service');
Route::get('/admin/orders', [\App\Http\Controllers\OrderController::class, 'superList'])->name('orders.admin');
Route::get('/admin/orders/view', [\App\Http\Controllers\OrderController::class, 'superListView'])->name('orders.admin.view');

Route::group(['middleware' => 'auth'], function(){
    Route::get('/get-average-order', [\App\Http\Controllers\OrderController::class, 'getAverageOrder'])->name('orders.getAverageOrder');
    Route::get('/calendar', [\App\Http\Controllers\SchedulesController::class, 'list'])->name('schedules.calendar');
    Route::post('/update-schedule', [SchedulesController::class, 'updateSchedule'])->name('schedules-update');

    Route::get('/settings/manage-orders', [SettingsController::class, 'manageOrders'])->name('settings.manage_orders');
    Route::get('/services/reviews', [ServiceController::class, 'reviews'])->name('services-reviews');

    Route::post('/occasions/assign', [OccasionController::class, 'assignServices'])->name('occasion-assign');
    Route::post('/occasions/store', [OccasionController::class, 'store'])->name('occasion-store');
    Route::post('/occasions/update', [OccasionController::class, 'edit'])->name('occasion-update');
    Route::get('/occasions/delete', [OccasionController::class, 'activateDeactivate'])->name('occasions.delete-occasion');
    Route::post('/settings/update-status-order', [SettingsController::class, 'updateStatusOrder'])->name('settings.update-status-order');


    Route::post('/settings/statuses/update', [SettingsController::class, 'statusUpdate'])->name('status-update');
    Route::post('/settings/statuses/store', [SettingsController::class, 'statusStore'])->name('status-store');
    Route::get('/settings/statuses/delete', [SettingsController::class, 'statusDelete'])->name('statuses.delete');

    Route::post('/settings/roles/update', [SettingsController::class, 'roleUpdate'])->name('role-update');
    Route::post('/settings/roles/store', [SettingsController::class, 'roleStore'])->name('role-store');
    Route::get('/settings/roles/delete', [SettingsController::class, 'roleDelete'])->name('roles.delete');

    Route::post('/settings/services/update', [SettingsController::class, 'serviceUpdate'])->name('service-update');
    Route::post('/settings/services/store', [SettingsController::class, 'serviceStore'])->name('service-store');
    Route::get('/settings/services/delete', [SettingsController::class, 'serviceDelete'])->name('services.delete');

    Route::post('/settings/company-update', [SettingsController::class, 'companyUpdate'])->name('settings.company_update');
    Route::get('/settings/services', [SettingsController::class, 'services'])->name('settings.services');
    Route::get('/settings/occasions', [SettingsController::class, 'occasions'])->name('settings.occasions');
    Route::get('/settings/statuses', [SettingsController::class, 'statuses'])->name('settings.statuses');
    Route::get('/settings/roles', [SettingsController::class, 'roles'])->name('settings.roles');
    Route::get('/users/remove', [UserController::class, 'removeUser'])->name('users.delete-user');
    Route::get('/users/view', [UserController::class, 'view'])->name('users.view-user');
    Route::get('/users/approve', [UserController::class, 'approve'])->name('users.approve-user');
    Route::post('/services/remove-image', [ServiceController::class, 'servicesRemoveImage'])->name('services-remove-image');
    Route::post('/services/update-event', [ServiceController::class, 'updateService'])->name('services.update_service');
    Route::post('/services/delete-service', [ServiceController::class, 'deleteService'])->name('services-delete');
    Route::post('/services/paused-service', [ServiceController::class, 'pausedService'])->name('services.paused_service');
    Route::post('/services/publish-service', [ServiceController::class, 'publishService'])->name('services.publish_service');
    Route::post('/services/resume-service', [ServiceController::class, 'resumeService'])->name('services.resume_service');
    Route::post('/issues/reply', [HelpController::class, 'reply'])->name('issues-reply');
    Route::get('/issues/replies', [HelpController::class, 'replies'])->name('issues-replies');
    Route::get('/service-providers/lists', [UserController::class, 'serviceProviders'])->name('service-providers.list');

    Route::get('/notes/remove', [NotesController::class, 'removeNote'])->name('notes.destroy-note');
    Route::resource('settings', 'SettingsController');
    Route::resource('schedules', 'SchedulesController');
    Route::resource('notes', 'NotesController');


    Route::resource('notifications', 'NotificationController');
    Route::resource('services', 'ServiceController');
    Route::resource('orders', 'OrderController');
    Route::resource('helps', 'HelpController');
});

Route::get('confirm/{user_by_code}',  [ConfirmController::class, 'confirm'])->name('confirm');

Route::group(['namespace' => 'Auth'], function () {

    // Authentication Routes...
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login');
    Route::get('logout', 'LoginController@logout')->name('logout');

    // Registration Routes...
    if (config('auth.users.registration')) {
        Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
        Route::post('register', 'RegisterController@register');
    }

    // Password Reset Routes...
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset');

    // Confirmation Routes...
    if (config('auth.users.confirm_email')) {
        Route::get('confirm/resend/{user_by_email}', 'ConfirmController@sendEmail')->name('confirm.send');
    }

    // Social Authentication Routes...
    Route::get('social/redirect/{provider}', 'SocialLoginController@redirect')->name('social.redirect');
    Route::get('social/login/{provider}', 'SocialLoginController@login')->name('social.login');
    Route::get('callback', 'SocialLoginController@register')->name('social.register');
});

/**
 * Backend routes
 */
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin'], function () {

    // Dashboard
    Route::get('/', 'DashboardController@index')->name('dashboard');

    //Users
    Route::get('users', 'UserController@index')->name('users');
    Route::get('users/restore', 'UserController@restore')->name('users.restore');
    Route::get('users/{id}/restore', 'UserController@restoreUser')->name('users.restore-user');
    Route::get('users/{user}', 'UserController@show')->name('users.show');
    Route::get('users/{user}/edit', 'UserController@edit')->name('users.edit');
    Route::put('users/{user}', 'UserController@update')->name('users.update');
    Route::any('users/{id}/destroy', 'UserController@destroy')->name('users.destroy');
    Route::get('permissions', 'PermissionController@index')->name('permissions');
    Route::get('permissions/{user}/repeat', 'PermissionController@repeat')->name('permissions.repeat');
    Route::get('dashboard/log-chart', 'DashboardController@getLogChartData')->name('dashboard.log.chart');
    Route::get('dashboard/registration-chart', 'DashboardController@getRegistrationChartData')->name('dashboard.registration.chart');
});

Route::get('/', 'HomeController@index');
Route::get('/privacy', 'HomeController@privacy')->name('privacy');
Route::get('/terms-condition', 'HomeController@termsCondition')->name('terms-condition');
Route::get('/faq', 'HomeController@faq')->name('faq');
Route::get('/help', 'HomeController@help')->name('help');
Route::get('/success-register', 'HomeController@successRegister')->name('success-register');

