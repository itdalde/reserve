<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Api\CartApiController;
use App\Http\Controllers\Api\CompanyApiController;
use App\Http\Controllers\Api\LocationApiController;
use App\Http\Controllers\Api\NotificationApiController;
use App\Http\Controllers\Api\OccasionEventsApiController;
use App\Http\Controllers\Api\OccasionsApiController;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\PaymentApiController;
use App\Http\Controllers\Api\PaymentMethodApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\ServicesApiController;
use App\Http\Controllers\Api\ServiceTypesApiController;
use App\Http\Controllers\Api\WhatsAppApiController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\OccasionController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;
use LaravelApi\Facade as Api;

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
Api::apiKeySecurity ( 'token' )
    ->parameterName ( 'Authorization' )
    ->inHeader ();
Route::group(['prefix' => 'v1','middleware' => ['cors']], function () {
    Api::post('/login', 'Auth\ApiAuthController@login')
        ->addFormDataParameter ( 'email', '', true  )
        ->addFormDataParameter ( 'password', '', true )
        ->addTag('Auth')
        ->setDescription('Login') ;
    Api::post('/reset-password', 'Auth\ApiAuthController@resetPassword')
        ->addFormDataParameter ( 'token', '', true  )
        ->addFormDataParameter ( 'email', '', true  )
        ->addFormDataParameter ( 'password', '', true )
        ->addTag('Auth')
        ->setDescription('Reset Password');
    Api::post('/forgot-password', 'Auth\ApiAuthController@forgotPassword')
        ->addFormDataParameter ( 'email', '', true  )
        ->addTag('Auth')
        ->setDescription('Forgot Password');
    Api::post('/register','Auth\ApiAuthController@register')
        ->addFormDataParameter ( 'first_name', '', true  )
        ->addFormDataParameter ( 'email', '', true  )
        ->addFormDataParameter ( 'phone_number', '', true  )
        ->addFormDataParameter ( 'password', '', true  )
        ->addTag('Auth')
        ->setDescription('Forgot Password');
    Api::post('/resend-confirmation','Auth\ApiAuthController@resendConfirmation')
        ->addFormDataParameter ( 'email', '', true  )
        ->addTag('Auth')
        ->setDescription('Resend Confirmation');
    Api::post('/google-login', 'Auth\ApiAuthController@googleLogin')
        ->addFormDataParameter ( 'token', '', true  )
        ->addTag('Auth')
        ->setDescription('Google login');
    Api::get('/occasions', [OccasionController::class,'index'])
        ->addTag('Occasions')
        ->setDescription('List')
        ->setProduces(['application/json']);
});
Route::group(['prefix' => 'v1', 'middleware' => ['auth:api','cors']], function() {
    Api::get('/transactions', [TransactionController::class,'index'])
        ->addTag('Transactions')
        ->setDescription('Get List of transactions')
        ->requiresAuth ( 'token', [ 'read' ] );
    Route::post('/logout', 'Auth\ApiAuthController@logout')->name('logout.api');
    Api::get('/me', 'Auth\ApiAuthController@me')
        ->addTag('User')
        ->setDescription('Get User Information')
        ->requiresAuth ( 'token', [ 'read' ] );
    Api::post('/reset-password-with-token', 'Auth\ApiAuthController@resetPasswordWithToken')
        ->addTag('Auth')
        ->addFormDataParameter ( 'email', '', true  )
        ->addFormDataParameter ( 'password', '', true )
        ->setDescription('Update password with token')
        ->requiresAuth ( 'token', [ 'read' ] );
    Api::get('/users', [UserController::class,'userList'])
        ->addTag('User')
        ->setDescription('Get User Lists')
        ->requiresAuth ( 'token', [ 'read' ] );
    Api::post('/fcm-token', [UserController::class, 'updateToken'])
        ->addFormDataParameter ( 'fcm_token', '', true  )
        ->addTag('User')
        ->requiresAuth ( 'token', [ 'read' ] );
});

Route::get('/test-fcm', [UserController::class, 'testFcm']);
Route::get('/test-socket', [UserController::class, 'testSocket']);
//  INFO: Membership Endpoints
Route::group(['prefix' => 'v1/membership', 'middleware' => ['cors']], function() {
    Api::get('/', [MembershipController::class, 'index'])
        ->addTag('Membership')
        ->setDescription('Get Membership List');
    Api::post('/create', [MembershipController::class, 'create'])
        ->addTag('Membership')
        ->setDescription('Create Membership');
    Api::post('/store', [MembershipController::class, 'store'])
        ->addTag('Membership')
        ->setDescription('Store Membership') ;
    Api::get('/show/{id}', [MembershipController::class, 'show'])
        ->addTag('Membership')
        ->setDescription('Show Membership') ;
    Api::get('/edit/{id}', [MembershipController::class, 'edit'])
        ->addTag('Membership')
        ->setDescription('Edit Membership') ;
    Api::put('/update/{id}', [MembershipController::class, 'update'])
        ->addTag('Membership')
        ->setDescription('Update Membership') ;
    Api::post('/destroy/{id}', [MembershipController::class, 'destroy'])
        ->addTag('Membership')
        ->setDescription('Delete Member By ID');
    Api::get('/members', [MembershipController::class, 'getMembers'])
        ->addTag('Membership')
        ->setDescription('Get Members');
});


Route::group(['prefix' => 'v1', 'middleware' => ['cors']], function() {

    Route::group(['prefix' => 'occasions', 'middleware' => ['cors']], function() {
        Api::get('/', [OccasionsApiController::class, 'getOccasions'])
            ->addTag('Occasions')
            ->setDescription('Get Occasions')
            ->setProduces(['application/json']);
        Api::get ( '/{id}', 'Api\OccasionsApiController@getOccasion' )
            ->addTag('Occasions')
            ->setDescription('Get Occasion by ID')
            ->setProduces(['application/json']);
    });

    Route::group(['prefix' => 'occasion-events', 'middleware' => ['cors']], function() {
        Api::get('/from-to-date', [OccasionEventsApiController::class, 'getOccasionEventsByFromToDate'])
            ->addTag('Occasions Events')
            ->setDescription('getOccasionEventsByFromToDate')
            ->setProduces(['application/json']);
        Api::get('/service-type/{id}', [OccasionEventsApiController::class, 'getOccasionByServiceType'])
            ->addTag('Occasions Events')
            ->setDescription('getOccasionByServiceType')
            ->setProduces(['application/json']);
        Api::get('/{id}', [OccasionEventsApiController::class, 'getOccasionEventById'])
            ->addTag('Occasions Events')
            ->setDescription('getOccasionEventById')
            ->setProduces(['application/json']);
        Api::get('/', [OccasionEventsApiController::class, 'getOccasionEvents'])
            ->addTag('Occasions Events')
            ->setDescription('getOccasionEvents')
            ->setProduces(['application/json']);
    });

    Route::group(['prefix' => 'services', 'middleware' => ['cors']], function() {
        Api::get('/', [ServiceTypesApiController::class, 'getServices'])
            ->addTag('Services')
            ->setDescription('getServices')
            ->setProduces(['application/json']);
        Api::get('/{occasion_type_id}', [ServiceTypesApiController::class, 'getServicesByOccasionId'])
            ->addTag('Services')
            ->setDescription('getServicesByOccasionType')
            ->setProduces(['application/json']);
        Api::get('/type/{service_type_id}', [ServiceTypesApiController::class, 'getService'])
            ->addTag('Services')
            ->setDescription('getService')
            ->setProduces(['application/json']);
        Api::get('/occasion-service-type/{occasion_id}', [ServiceTypesApiController::class, 'getServiceTypesByOccasionId'])
            ->addTag('Services')
            ->setDescription('getServiceTypesByOccasionId')
            ->setProduces(['application/json']);
        Api::get('/occasion-event/{occasion_event_id}', [OccasionEventsApiController::class, 'getOccasionServiceByOccasionId'])
            ->addTag('Services')
            ->setDescription('getOccasionServiceByOccasionId')
            ->setProduces(['application/json']);
        Api::get('/provider/{provider_id}', [ServicesApiController::class, 'getServicesByProviders'])
            ->addTag('Services')
            ->setDescription('getServicesByProviders')
            ->setProduces(['application/json']);
        // search
        Api::get('/{service_type_id}/events/{search}', [ServicesApiController::class, 'findOccasionServiceByProvider'])
            ->addTag('Services')
            ->setDescription('findOccasionServiceByProvider')
            ->setProduces(['application/json']);
    });

    Route::group(['prefix' => 'providers', 'middleware' => ['cors']], function() {
        Api::get('/', [CompanyApiController::class, 'getProviders'])
            ->addTag('Providers')
            ->setDescription('findOccasionServiceByProvider')
            ->setProduces(['application/json']);
        Api::get('/service-type/{service_type_id}', [ServicesApiController::class, 'getProvidersByServiceType'])
            ->addTag('Providers')
            ->setDescription('getProvidersByServiceType')
            ->setProduces(['application/json']);
        Api::get('/{provider_id}/service-type/{service_id}', [ServicesApiController::class, 'getServicesByCompanyAndServiceType'])
            ->addTag('Providers')
            ->setDescription('getServicesByCompanyAndServiceType')
            ->setProduces(['application/json']);
    });

    Route::group(['prefix' => 'cart', 'middleware' => ['cors']], function() {
        Api::post('/add-service-to-cart/{user_id}', [CartApiController::class, 'addServiceToCart'])
            ->addTag('Cart')
            ->setDescription('addServiceToCart')
            ->setProduces(['application/json']);
        Api::get('/user/{user_id}', [CartApiController::class, 'getUserCart'])
            ->addTag('Cart')
            ->setDescription('getUserCart')
            ->setProduces(['application/json']);
        Api::post('/{cart_id}/remove-service/{service_id}', [CartApiController::class, 'removeServiceFromCart'])
            ->addTag('Cart')
            ->setDescription('removeServiceFromCart')
            ->setProduces(['application/json']);
        Api::post('/{cart_id}/update-service/{service_id}', [CartApiController::class, 'updateServiceFromCart'])
            ->addTag('Cart')
            ->setDescription('updateServiceFromCart')
            ->setProduces(['application/json']);
        Api::get('/{cart_id}/service/{status}', [CartApiController::class, 'getItemInCartByStatus'])
            ->addTag('Cart')
            ->setDescription('getItemInCartByStatus')
            ->setProduces(['application/json']);
        Api::get('/{cart_id}/service-item/{service_id}', [CartApiController::class, 'getServiceByCartAndServiceId'])
            ->addTag('Cart')
            ->setDescription('getServiceByCartAndServiceId')
            ->setProduces(['application/json']);
        Api::post('/{cart_id}/place-order/{user_id}', [CartApiController::class, 'placeOrder'])
            ->addTag('Cart')
            ->setDescription('placeOrder')
            ->setProduces(['application/json']);

    });

    Route::group(['prefix' => 'order', 'middleware' => ['cors']], function() {
        Api::post('/{order_id}/timeline/{timeline}', [OrderApiController::class, 'updateTimelineForOrder'])
            ->addTag('Order')
            ->setDescription('updateTimelineForOrder')
            ->setProduces(['application/json']);
        Api::post('/{order_id}/status/{status}', [OrderApiController::class, 'getOrderByReferenceNo'])
            ->addTag('Order')
            ->setDescription('getOrderByReferenceNo')
            ->setProduces(['application/json']);
        Api::get('/{reference_no}', [OrderApiController::class, 'getOrderByReferenceNo'])
            ->addTag('Order')
            ->setDescription('getOrderByReferenceNo')
            ->setProduces(['application/json']);
        Api::get('/user/{user_id}/orders', [OrderApiController::class, 'getUserOrders'])
            ->addTag('Order')
            ->setDescription('getUserOrders')
            ->setProduces(['application/json']);
        Api::get('/payment-detail/{reference_no}', [OrderApiController::class, 'getPaymentDetailByReferenceNo'])
            ->addTag('Order')
            ->setDescription('getPaymentDetailByReferenceNo')
            ->setProduces(['application/json']);
    });

    Route::group(['prefix' => 'transactions', 'middleware' => ['cors']], function() {

    });

    Route::group(['prefix' => 'payment-method', 'middleware' => ['cors']], function() {
        Api::post('/', [PaymentMethodApiController::class, 'savePaymentMethod'])
            ->addTag('Payment Method')
            ->setDescription('savePaymentMethod')
            ->setProduces(['application/json']);
        Api::get('/{payment_method_id}', [PaymentMethodApiController::class, 'getPaymentMethodById'])
            ->addTag('Payment Method')
            ->setDescription('getPaymentMethodById')
            ->setProduces(['application/json']);
    });

    Route::group(['prefix' => 'locations', 'middleware' => ['cors']], function() {
        Api::post('/', [LocationApiController::class, 'addLocation'])
            ->addTag('Locations')
            ->setDescription('addLocation')
            ->setProduces(['application/json']);
        Api::get('/user/{user_id}', [LocationApiController::class, 'getLocations'])
            ->addTag('Locations')
            ->setDescription('getLocations')
            ->setProduces(['application/json']);
        Api::get('/default/{user_id}', [LocationApiController::class, 'getDefaultLocation'])
            ->addTag('Locations')
            ->setDescription('getDefaultLocation')
            ->setProduces(['application/json']);
    });

    Route::group(['prefix' => 'user', 'middleware' => ['cors']], function() {
        Api::put('/{user_id}', [UserApiController::class, 'updateUser'])
            ->addTag('User')
            ->setDescription('updateUser')
            ->setProduces(['application/json']);
        Api::put('/profile-image/{user_id}', [UserApiController::class, 'updateProfilePicture'])
            ->addTag('User')
            ->setDescription('updateProfilePicture')
            ->setProduces(['application/json']);
    });

    Route::group(['prefix' => 'payments', 'middleware' => ['cors']], function() {
        Api::post('/', [PaymentApiController::class, 'processPayment'])
            ->addTag('Payments')
            ->setDescription('processPayment')
            ->setProduces(['application/json']);
        Api::get('/{payment_id}', [PaymentApiController::class, 'getProcessPayment'])
            ->addTag('Payments')
            ->setDescription('getProcessPayment')
            ->setProduces(['application/json']);

        Api::post('/processing',[PaymentApiController::class, 'paymentProcessing'])
            ->addTag('Payments')
            ->setDescription('paymentProcessing')
            ->setProduces(['application/json']);
        Api::post('/success', [PaymentApiController::class, 'paymentSuccess'])
            ->addTag('Payments')
            ->setDescription('paymentSuccess')
            ->setProduces(['application/json']);
        Api::get('/receipt/{reference_no}', [PaymentApiController::class, 'paymentReceipt'])
            ->addTag('Payments')
            ->setDescription('paymentReceipt')
            ->setProduces(['application/json']);
    });

    Route::group(['prefix' => 'notification', 'middleware' => ['cors']], function() {
        Api::get('/{user_id}', [NotificationApiController::class, 'getNotificationByUserID'])
            ->addTag('Notifications')
            ->setDescription('getNotificationByUserID')
            ->setProduces(['application/json']);

        Api::post('/enable/{user_id}', [NotificationApiController::class, 'enableNotification'])
            ->addTag('Notifications')
            ->addFormDataParameter ( 'enable_notification', 'This is value is 1 or 0. 1 to enable the notification', true ,'integer' )
            ->setDescription('Enable/Disable Notification')
            ->setProduces(['application/json']);
        Api::post('/order-completed', [NotificationApiController::class, 'checkOrderCompleted'])
            ->addTag('Notifications')
            ->setDescription('process-completed-order')
            ->setProduces(['application/json']);
        Api::post('/paid-order', [NotificationApiController::class, 'paidOrders'])
            ->addTag('Notifications')
            ->setDescription('process-paid-orders')
            ->setProduces(['application/json']);
        Api::post('/pending-order/{user_id}', [NotificationApiController::class, 'invokeNotificationByUser'])
            ->addTag('Notifications')
            ->setDescription('invoke-pending-order-by-user')
            ->setProduces(['application/json']);
    });

    Route::group(['prefix' => 'locale', 'middleware' => ['cors']], function() {
        Api::get('/{locale}', [NotificationApiController::class, 'getTranslation'])
            ->addTag('Locale')
            ->setDescription('get-locale')
            ->setProduces(['application/json']);
        Api::get('/{locale}/{key}', [NotificationApiController::class, 'getTranslation'])
            ->addTag('Locale')
            ->setDescription('get-locale-key')
            ->setProduces(['application/json']);
        Api::post('/currentLanguage', [NotificationApiController::class, 'getCurrentLanguage'])
            ->addTag('Locale')
            ->setDescription('get-current-language')
            ->setProduces(['application/json']);
        Api::post('/', [UserApiController::class, 'updateUserAppLanguage'])
            ->addTag('Locale')
            ->setDescription('update-user-app-language')
            ->setProduces(['application/json']);
    });

    Route::group(['prefix' => 'whatsapp', 'middleware' => ['cors']], function() {
        Api::post('/send', [WhatsAppApiController::class, 'sendWhatsAppMessage'])
            ->addTag('Whatsapp')
            ->setDescription('send-message')
            ->setProduces(['application/json']);
        Api::post('/send-v2', [WhatsAppApiController::class, 'sendWithTemplate'])
            ->addTag('Whatsapp')
            ->setDescription('send-message-with-template')
            ->setProduces(['application/json']);
    });

    Route::group(['prefix' => 'service-availability', 'middleware' => ['cors']], function() {
        Api::post('/', [OccasionEventsApiController::class, 'getPreferences'])
            ->addTag('Service Availability')
            ->setDescription('get-availability-dates')
            ->setProduces(['application/json']);
    });


    Route::group(['prefix' => 'command', 'middleware' => ['cors']], function() {
        Api::get('/', [OrderApiController::class, 'executeCommand'])
            ->addTag('Command')
            ->setDescription('order-apis')
            ->setProduces(['application/json']);
    });
});



