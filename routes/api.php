<?php

//use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});



Route::group(['namespace' => 'Api\Frontend'],function (){
    Route::get('/','HomeController@index')->name('home.page');
    //Register
    Route::get('account/register','UserController@register');
    Route::post('account/register','UserController@doRegister');

    //Authentication
    Route::get('account/login','UserController@login')->name('login.page');
    Route::post('account/logined','UserController@checkFastLogin');
    Route::get('account/passwordResets','UserController@page_password_resets');
    Route::post('passwordResets','UserController@password_resets');
    Route::post('account/login','UserController@doLogin');
    Route::post('account/loginWithEmail','UserController@loginWithEmail');
    Route::get('account/loginWithEmail','UserController@showloginWithEmail');
    Route::post('account/loginWithEmail/{token}','UserController@doLoginWithEmail');


    Route::group(['middleware' =>'auth:api'],function (){
        Route::get('check-auth','UserController@authCheck');
        Route::post('account/logOut','UserController@logOut')->name('logOut');
        Route::get('account/dashboard','DashboardController@index');
        Route::post('account/dashboard','DashboardController@update');
        //Uploaded The Case
        Route::get('upload/case','CaseFileController@index');
        Route::post('upload/case','CaseFileController@upload');
    });
});

Route::group(['namespace' => 'Api\Admin'],function (){

});
