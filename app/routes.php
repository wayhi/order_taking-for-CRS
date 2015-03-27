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
Route::get('login', array('as' => 'login', 'uses' => 'app\controllers\LoginController@getLogin'));
Route::post('login','app\controllers\LoginController@postLogin');
Route::get('/', array('as' => 'login', 'uses' => 'app\controllers\LoginController@getLogin'));
Route::post('/','app\controllers\LoginController@postLogin');
Route::group(array('before'=>'auth.login'),function(){
	Route::get('login/show_policy',['as'=>'login.show_policy','uses'=>'app\controllers\LoginController@show_policy']);
	Route::get('login/confirm/{activity_id}',['as'=>'login.confirm','uses'=>'app\controllers\LoginController@confirm']);
	Route::get('logout', array('as'=>'logout','uses'=>'app\controllers\LoginController@getLogout'));
	Route::get('/showcart',['as'=>'showcart','uses'=>'app\controllers\ItemController@showcart']);
	Route::get('/clearcart',['as'=>'clearcart','uses'=>'app\controllers\ItemController@clearcart']);
	Route::get('items/addtocart/{item_id}/{page?}',
		['as'=>'items.addtocart','uses'=>'app\controllers\ItemController@addtocart']);
	Route::get('/delfrmcart/{item_id}',
		['as'=>'delfrmcart','uses'=>'app\controllers\ItemController@delfrmcart']);		
	Route::group(['before'=>'activated'],function(){
		Route::Resource('items','app\controllers\ItemController');
	});
	Route::get('download_template/{file_name}',['as'=>'download_template','uses'=>function($file_name)
		{return Redirect::to('/Templates/'.$file_name);}]);
	Route::get('products/import',['as'=>'products.import','uses'=>'app\controllers\ProductController@import']);
	Route::get('orders/manage/{activity_id}/{item_id?}/{user_id?}',['as'=>'orders.manage','uses'=>'app\controllers\OrderController@manage']);
	Route::Resource('orders','app\controllers\OrderController');
	Route::Resource('activity','app\controllers\ActivityController');
	Route::Resource('products','app\controllers\ProductController');
});	

