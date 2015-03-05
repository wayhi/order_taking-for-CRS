<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', array('as' => 'login', 'uses' => 'app\controllers\LoginController@getLogin'));
Route::get('login', array('as' => 'login', 'uses' => 'app\controllers\LoginController@getLogin'));
Route::post('login','app\controllers\LoginController@postLogin');
Route::get('logout', array('as'=>'logout','uses'=>'app\controllers\LoginController@getLogout'));
Route::get('/showcart',['as'=>'showcart','uses'=>'app\controllers\ItemController@showcart']);
Route::get('/clearcart',['as'=>'clearcart','uses'=>'app\controllers\ItemController@clearcart']);
Route::get('items/addtocart/{item_id}/{page?}',['as'=>'items.addtocart','uses'=>'app\controllers\ItemController@addtocart']);	
Route::Resource('items','app\controllers\ItemController');
Route::Resource('orders','app\controllers\OrderController');
	

