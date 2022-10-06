<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\OccasionController;
use Illuminate\Http\Request;

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
    Route::post('/logout', 'Auth\ApiAuthController@logout')->name('logout.api');
    Route::get('/me', 'Auth\ApiAuthController@me')->name('me.api');
    Route::get('/users', [UserController::class,'userList'])->name('users.list.api');
});
