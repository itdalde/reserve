<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Api\OccasionEventsApiController;
use App\Http\Controllers\Api\OccasionsApiController;
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


Route::group(['prefix' => 'v1/occasions', 'middleware' => ['cors']], function() {
    Route::get('/', [OccasionsApiController::class, 'getOccasions'])->name('get-occasions');
    Route::get('/occasion-by-occasion-type', [OccasionsApiController::class, 'getOccasionTypeByOccasionId'])->name('get-occasions-by-occasion-type');
});

Route::group(['prefix' => 'v1/occasion-events', 'middleware' => ['cors']], function() {
   Route::get('/', [OccasionEventsApiController::class, 'getOccasionEvents'])->name('get-occasions');;
   Route::get('/events-by-event-type', [OccasionEventsApiController::class, 'getEventsByEventType'])->name('get-occasion-event-by-service-type');
   Route::get('/events-by-occasion-date', [OccasionEventsApiController::class, 'getEventsByOccasionDate'])->name('get-occasions');
   Route::get('/events-by-occasion-id', [OccasionEventsApiController::class, 'getOccasionEventsByOccasionId'])->name('get-occasion-events-by-occasion');
});

Route::group(['prefix' => 'v1/service-types', 'middleware' => ['cors']], function() {
    Route::get('/', [ServiceTypesApiController::class, 'getServiceTypes'])->name('get-all-service-types');
});

