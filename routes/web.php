<?php

use App\Http\Controllers\admin\products\productsController;
use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    // return view('admin.en.dashboard');
       return view('welcome');
});

Route::group(['prefix'=>'admin','namespace'=>'admin','middleware'=>['auth','verified']], function () {       

    Route::get('/','dashboardController@index');
    
    Route::group(['prefix'=>'products','namespace'=>'products'],function(){

        Route::get('all','productsController@index')->name('all');
        Route::get('create','productsController@create');
        Route::post('store','productsController@store');
        Route::delete('destroy/{pro_id}','productsController@destroy');
        Route::get('edit/{id}','productsController@edit');
        Route::put('update','productsController@update');


    });

    Route::group(['prefix' => 'mails','namespace'=>'mails'], function () {
        
        Route::get('all','mailController@index')->name('mails');
        Route::post('send-mail','mailController@send')->name('send-mail');

    });
    // Route::group(['prefix'=>'subCat','namespace'=>'subCat'],function(){
    //     Route::get('all','subCatController@index');
    // });


});

Route::group(['prefix' => 'user','namespace'=>'user'], function () {
    
    
});

Auth::routes(['verify' => true]);                
Route::get('/home', 'HomeController@index')->name('home'); 
