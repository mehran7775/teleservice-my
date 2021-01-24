<?php

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['namespace' => 'Api\Frontend'],function (){
    Route::get('/',[
      'as' => 'home',
      'uses' => 'HomeController@index'
    ]);
    Route::get('services',[
      'as' => 'services',
      'uses' => 'ServiceController@index'
    ]);
    //Register
    Route::get('account/register',[
        'as' => 'register',
        'uses' => 'UserController@register'
    ]);
    Route::post('account/register',[
        'as' => 'register',
        'uses' => 'UserController@doRegister'
    ]);


    //Authentication
    Route::get('account/login',[
        'as' => 'login',
        'uses' => 'UserController@login'

    ]);
    Route::post('account/logined',[
        'as' => 'logined',
        'uses' => 'UserController@checkFastLogin'
    ]);
    Route::get('account/passwordResets',[
        'as' => 'reset_password',
        'uses' =>'UserController@page_password_resets'
    ]);
    Route::post('passwordResets',[
        'as' => 'reset_password' ,
        'uses'=>'UserController@password_resets'
    ]);
    Route::post('account/login',[
        'as' => 'login',
        'uses'=>'UserController@doLogin'
    ]);
    Route::post('account/loginWithEmail',[
        'as' => 'login_with_email',
        'uses'=>'UserController@loginWithEmail'
    ]);
    Route::get('account/loginWithEmail',[
        'as' => 'login_with_email',
        'uses'=>'UserController@showloginWithEmail'
    ]);
    Route::post('account/loginWithEmail/{token}',[
        'as' => 'doLogin_with_email' ,
        'uses'=>'UserController@doLoginWithEmail'
    ]);
    
    Route::get('cities',[
        'as' => 'cities',
        'uses' => 'CityController@index'
    ]);
    Route::get('categories',[
        'as' => 'categories',
        'uses' => 'CategoryController@index'
    ]);
    Route::get('check',function(){
        return 'check';
    });
//    Route::apiResources([
//        'upload' => 'uploadController'
//    ]);

    Route::group(['middleware' =>'auth:api'],function (){
//        Route::get('users','userController@get_all_user');

        Route::get('check-auth',[
            'as' => 'check-auth',
            'uses' => 'UserController@authCheck'
        ]);
        Route::post('account/logOut',[
            'as' => 'logout',
            'uses' => 'UserController@logOut'
        ]);
        Route::apiResource('account/dashboard', 'DashboardController');
        Route::apiResource('account/profile','ProfileController');
        Route::apiResource('case','CaseController');
        Route::get('download/{name}','DownloadController@download');
    });

});

Route::group(['namespace' => 'Api\Admin'],function (){

});
