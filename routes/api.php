<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Api\OccasionEventsApiController;
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

//  INFO: Occasion Endpoints
Route::group(['prefix' => 'v1/occasion', 'middleware' => ['cors']], function() {
    Route::get('/', [OccasionController::class, 'index'])->name('index');
    Route::post('/create', [OccasionController::class, 'create'])->name('create');
    Route::post('/store', [OccasionController::class, 'store'])->name('store');
    Route::get('/show/{id}', [OccasionController::class, 'show'])->name('show');
    Route::get('/edit/{id}', [OccasionController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [OccasionController::class, 'update'])->name('update');
    Route::post('/destroy/{id}', [OccasionController::class, 'destroy'])->name('destroy');
    Route::get('/demo', [OccasionController::class, 'demo'])->name('demo');
});

//  INFO: OccasionEvent Endpoints
Route::group(['prefix' => 'v1/events', 'middleware' => ['cors']], function() {
    Route::get('/', [OccasionEventController::class, 'index'])->name('index');
    Route::post('/create', [OccasionEventController::class, 'create'])->name('create');
    Route::post('/store', [OccasionEventController::class, 'store'])->name('store');
    Route::get('/show/{id}', [OccasionEventController::class, 'show'])->name('show');
    Route::get('/edit/{id}', [OccasionEventController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [OccasionEventController::class, 'update'])->name('update');
    Route::post('/destroy/{id}', [OccasionEventController::class, 'destroy'])->name('destroy');
    Route::post('/create-order', [OccasionEventController::class, 'createOrder'])->name('create-order');
    Route::post('/delete-event', [OccasionEventController::class, 'deleteEvent'])->name('delete-event');
    Route::get('/events', [OccasionEventController::class, 'getEvents'])->name('occasion-events');
});

Route::group(['prefix' => 'v1/occasions', 'middleware' => ['cors']], function() {
   Route::get('/', [OccasionEventsApiController::class, 'getOccasions'])->name('get-occasions');;
   Route::get('/events-by-occasion', [OccasionEventsApiController::class, 'getEventsByOccasion'])->name('get-occasions');
});

//  INFO: OccasionEventReviews Endpoints
Route::group(['prefix' => 'v1/event-reviews', 'middleware' => ['cors']], function() {
    Route::get('/', [OccasionEventReviewsController::class, 'index'])->name('index');
    Route::post('/create', [OccasionEventReviewsController::class, 'create'])->name('create');
    Route::post('/store', [OccasionEventReviewsController::class, 'store'])->name('store');
    Route::get('/show/{id}', [OccasionEventReviewsController::class, 'show'])->name('show');
    Route::get('/edit/{id}', [OccasionEventReviewsController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [OccasionEventReviewsController::class, 'update'])->name('update');
    Route::post('/destroy/{id}', [OccasionEventReviewsController::class, 'destroy'])->name('destroy');
});

//  INFO: Order Endpoints
Route::group(['prefix' => 'v1/order', 'middleware' => ['cors']], function() {
    Route::get('/', [OrderController::class, 'index'])->name('index');
    Route::post('/create', [OrderController::class, 'create'])->name('create');
    Route::post('/store', [OrderController::class, 'store'])->name('store');
    Route::get('/show/{id}', [OrderController::class, 'show'])->name('show');
    Route::get('/edit/{id}', [OrderController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [OrderController::class, 'update'])->name('update');
    Route::post('/destroy/{id}', [OrderController::class, 'destroy'])->name('destroy');
});

//  INFO: Service Endpoints
Route::group(['prefix' => 'v1/service', 'middleware' => ['cors']], function() {
    Route::get('/', [ServiceController::class, 'index'])->name('index');
    Route::post('/create', [ServiceController::class, 'create'])->name('create');
    Route::post('/store', [ServiceController::class, 'store'])->name('store');
    Route::get('/show/{id}', [ServiceController::class, 'show'])->name('show');
    Route::get('/edit/{id}', [ServiceController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [ServiceController::class, 'update'])->name('update');
    Route::post('/destroy/{id}', [ServiceController::class, 'destroy'])->name('destroy');
});

//  INFO: Transaction Endpoints
Route::group(['prefix' => 'v1/transaction', 'middleware' => ['cors']], function() {
    Route::get('/', [TransactionController::class, 'index'])->name('index');
    Route::post('/create', [TransactionController::class, 'create'])->name('create');
    Route::post('/store', [TransactionController::class, 'store'])->name('store');
    Route::get('/show/{id}', [TransactionController::class, 'show'])->name('show');
    Route::get('/edit/{id}', [TransactionController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [TransactionController::class, 'update'])->name('update');
    Route::post('/destroy/{id}', [TransactionController::class, 'destroy'])->name('destroy');
});

