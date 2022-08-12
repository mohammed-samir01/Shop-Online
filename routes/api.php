<?php

use Illuminate\Http\Request;
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
define('PAGINATE',2);
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware'=>'changeLang'],function(){


    Route::group(['namespace'=>'auth','prefix'=>'user'],function(){
        Route::post('register','authController@register');
        Route::post('checkCode','authController@checkCode');
        Route::post('profile','authController@profile');
        Route::post('login','authController@login');
        Route::post('updateProfile','authController@updateProfile');
        Route::post('logout','authController@logout');

    });

    Route::group(['namespace'=>'products','prefix'=>'products','middleware'=>'checkAuth'],function(){
        Route::get('all','productController@index');
        Route::post('store','productController@store');
        Route::post('update','productController@update');
        Route::delete('delete/{id}','productController@delete');
    });

    Route::group(['namespace'=>'auth','prefix'=>'user'],function(){
        // Route:: 
    });

});
