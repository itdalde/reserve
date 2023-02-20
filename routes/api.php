<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Api\CartApiController;
use App\Http\Controllers\Api\CompanyApiController;
use App\Http\Controllers\Api\LocationApiController;
use App\Http\Controllers\Api\OccasionEventsApiController;
use App\Http\Controllers\Api\OccasionsApiController;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\PaymentApiController;
use App\Http\Controllers\Api\PaymentMethodApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\ServicesApiController;
use App\Http\Controllers\Api\ServiceTypesApiController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\OccasionController;
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
    Route::post('/reset-password', 'Auth\ApiAuthController@resetPassword')->name('reset-password.api');
    Route::post('/forgot-password', 'Auth\ApiAuthController@forgotPassword')->name('forgot-password.api');
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
    Route::post('/fcm-token', [UserController::class, 'updateToken']);
});

Route::get('/test-fcm', [UserController::class, 'testFcm']);
Route::get('/test-socket', [UserController::class, 'testSocket']);
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
        Route::get('/{id}', [OccasionsApiController::class, 'getOccasion'])->name('get-occasion-by-id');
    });

    Route::group(['prefix' => 'occasion-events', 'middleware' => ['cors']], function() {
        Route::get('/from-to-date', [OccasionEventsApiController::class, 'getOccasionEventsByFromToDate'])->name('get-events-by-occasion-date');
        Route::get('/service-type/{id}', [OccasionEventsApiController::class, 'getOccasionByServiceType'])->name('get-events-by-event-type');
        Route::get('/{id}', [OccasionEventsApiController::class, 'getOccasionEventById'])->name('get-occasion-events-by-id');
        Route::get('/', [OccasionEventsApiController::class, 'getOccasionEvents'])->name('get-occasion-events');
    });

    Route::group(['prefix' => 'services', 'middleware' => ['cors']], function() {
        Route::get('/', [ServiceTypesApiController::class, 'getServices'])->name('get-services');
        Route::get('/type/{service_type_id}', [ServiceTypesApiController::class, 'getService'])->name('get-service-by-id');
        Route::get('/occasion-service-type/{occasion_id}', [ServiceTypesApiController::class, 'getServiceTypesByOccasionId'])->name('get-service-type-by-occasion-id');

        Route::get('/occasion-event/{occasion_event_id}', [OccasionEventsApiController::class, 'getOccasionServiceByOccasionId'])->name('get-occasion-service-by-occasion-id');
        Route::get('/provider/{provider_id}', [ServicesApiController::class, 'getServicesByProviders'])->name('get-services-by-provider');

        // search
        Route::get('/{service_type_id}/events/{search}', [ServicesApiController::class, 'findOccasionServiceByProvider'])->name('find-occasion-events-by-service-provider');
    });

    Route::group(['prefix' => 'providers', 'middleware' => ['cors']], function() {
        Route::get('/', [CompanyApiController::class, 'getProviders'])->name('get-all-providers');
        Route::get('/service-type/{service_type_id}', [ServicesApiController::class, 'getProvidersByServiceType'])->name('get-providers-by-service-type');
        Route::get('/{provider_id}/service-type/{service_id}', [ServicesApiController::class, 'getServicesByCompanyAndServiceType'])->name('get-services-under-company-group-by-service-type');
    });

    Route::group(['prefix' => 'cart', 'middleware' => ['cors']], function() {
        Route::post('/add-service-to-cart/{user_id}', [CartApiController::class, 'addServiceToCart'])->name('add-service-to-cart');
        Route::get('/user/{user_id}', [CartApiController::class, 'getUserCart'])->name('get-cart-by-user-id');
        Route::post('/{cart_id}/remove-service/{service_id}', [CartApiController::class, 'removeServiceFromCart'])->name('remove-service-from-cart');
        Route::post('/{cart_id}/update-service/{service_id}', [CartApiController::class, 'updateServiceFromCart'])->name('update-service-in-cart');
        Route::get('/{cart_id}/service/{status}', [CartApiController::class, 'getItemInCartByStatus'])->name('get-service-in-cart-by-status');
        Route::get('/{cart_id}/service-item/{service_id}', [CartApiController::class, 'getServiceByCartAndServiceId'])->name('get-cart-item-service-by-id');


        Route::post('/{cart_id}/place-order/{user_id}', [CartApiController::class, 'placeOrder'])->name('user-placed-order');

    });

    Route::group(['prefix' => 'order', 'middleware' => ['cors']], function() {
        Route::post('/{order_id}/timeline/{timeline}', [OrderApiController::class, 'updateTimelineForOrder'])->name('update-order-timeline-status');
        Route::post('/{order_id}/status/{status}', [OrderApiController::class, 'updateStatusForOrder'])->name('update-order-status-status');
        Route::get('/{reference_no}', [OrderApiController::class, 'getOrderByReferenceNo'])->name('get-order-by-reference-no');
        Route::get('/user/{user_id}/orders', [OrderApiController::class, 'getUserOrders'])->name('get-user-order-history');

        Route::get('/payment-detail/{reference_no}', [OrderApiController::class, 'getPaymentDetailByReferenceNo'])->name('get-payment-detail-by-reference-no');
    });

    Route::group(['prefix' => 'transactions', 'middleware' => ['cors']], function() {

    });

    Route::group(['prefix' => 'payment-method', 'middleware' => ['cors']], function() {
        Route::post('/', [PaymentMethodApiController::class, 'savePaymentMethod'])->name('save-payment-method');
        Route::get('/{payment_method_id}', [PaymentMethodApiController::class, 'getPaymentMethodById'])->name('get-payment-method-by-id');
    });

    Route::group(['prefix' => 'locations', 'middleware' => ['cors']], function() {
        Route::post('/', [LocationApiController::class, 'addLocation'])->name('post-new-location');
        Route::get('/user/{user_id}', [LocationApiController::class, 'getLocations'])->name('get-locations');
        Route::get('/default/{user_id}', [LocationApiController::class, 'getDefaultLocation'])->name('get-default-location');
    });

    Route::group(['prefix' => 'user', 'middleware' => ['cors']], function() {
        Route::put('/{user_id}', [UserApiController::class, 'updateUser'])->name('update-user-profile');
        Route::put('/profile-image/{user_id}', [UserApiController::class, 'updateProfilePicture'])->name('update-user-profile-image');
    });

    Route::group(['prefix' => 'payments', 'middleware' => ['cors']], function() {
        Route::post('/', [PaymentApiController::class, 'processPayment'])->name('process-payment');
        Route::get('/{payment_id}', [PaymentApiController::class, 'getProcessPayment'])->name('get-payment-by-id');

        Route::post('/processing',[PaymentApiController::class, 'paymentProcessing'])->name('payment-processing');
        Route::post('/success', [PaymentApiController::class, 'paymentSuccess'])->name('payment-success');
        Route::get('/receipt/{reference_no}', [PaymentApiController::class, 'paymentReceipt'])->name('payment-receipt');
    });

    Route::group(['prefix' => 'command', 'middleware' => ['cors']], function() {
        Route::get('/', [OrderApiController::class, 'executeCommand'])->name('order-apis');
    });
});



