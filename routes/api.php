<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Api\OccasionEventsApiController;
use App\Http\Controllers\Api\OccasionsApiController;
use App\Http\Controllers\Api\ServicesApiController;
use App\Http\Controllers\Api\ServiceTypesApiController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\OccasionController;
use App\Http\Controllers\OccasionEventController;
use App\Http\Controllers\OccasionEventReviewsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1','middleware' => ['cors']], function () {
    Route::post('/login', 'Auth\ApiAuthController@login')->name('login.api');
    Route::post('/register','Auth\ApiAuthController@register')->name('register.api');
    Route::post('/resend-confirmation','Auth\ApiAuthController@resendConfirmation')->name('resend.confirmation.api');
    Route::post('/google-login', 'Auth\ApiAuthController@googleLogin')->name('google.login.api');
    Route::get('/occasions', [OccasionController::class,'index'])->name('occasions.list.api');
});
Route::group(['prefix' => 'v1', 'middleware' => ['auth:api','cors']], function() {
    Route::get('/transactions', [TransactionController::class,'index'])->name('transactions.list.api');
    Route::post('/logout', 'Auth\ApiAuthController@logout')->name('logout.api');
    Route::get('/me', 'Auth\ApiAuthController@me')->name('me.api');
    Route::get('/users', [UserController::class,'userList'])->name('users.list.api');
});

//  INFO: Membership Endpoints
Route::group(['prefix' => 'v1/membership', 'middleware' => ['cors']], function() {
    Route::get('/', [MembershipController::class, 'index'])->name('index');
    Route::post('/create', [MembershipController::class, 'create'])->name('create');
    Route::post('/store', [MembershipController::class, 'store'])->name('store');
    Route::get('/show/{id}', [MembershipController::class, 'show'])->name('show');
    Route::get('/edit/{id}', [MembershipController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [MembershipController::class, 'update'])->name('update');
    Route::post('/destroy/{id}', [MembershipController::class, 'destroy'])->name('destroy');
    Route::get('/members', [MembershipController::class, 'getMembers'])->name('membership');
});


Route::group(['prefix' => 'v1', 'middleware' => ['cors']], function() {

    Route::group(['prefix' => 'occasions', 'middleware' => ['cors']], function() {
       Route::get('/', [OccasionsApiController::class, 'getOccasions'])->name('get-occasions');
       Route::get('/by-type', [OccasionsApiController::class, 'getOccasionTypeByOccasionId'])->name('get-occasions-by-occasion-type');
    });

    Route::group(['prefix' => 'occasion-events', 'middleware' => ['cors']], function() {
        Route::get('/', [OccasionEventsApiController::class, 'getOccasionEvents'])->name('get-occasion-events');
        Route::get('/{id}', [OccasionEventsApiController::class, 'getOccasionEventById'])->name('get-occasion');
        Route::get('/by-event-type', [OccasionEventsApiController::class, 'getEventsByEventType'])->name('get-events-by-event-type');
        Route::get('/by-occasion-date', [OccasionEventsApiController::class, 'getEventsByOccasionDate'])->name('get-events-by-occasion-date');
        Route::get('/by-occasion-id', [OccasionEventsApiController::class, 'getOccasionEventsByOccasionId'])->name('get-occasion-events-by-occasion-id');
    });

    Route::group(['prefix' => '/services', 'middleware' => ['cors']], function() {
       Route::get('/types', [ServiceTypesApiController::class, 'getServiceTypes'])->name('get-all-service-types');

       Route::get('/occasion-by-id', [ServicesApiController::class, 'getServiceTypeByOccasionId'])->name('get-service-type-by-occasion-id');
       Route::get('/by-vendors', [ServicesApiController::class, 'findOccasionServiceByVendors'])->name('find-service-by-vendor');
    });
});



