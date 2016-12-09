<?php

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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

/**
Route::get('/contacts',array('as' => 'contacts', 'uses' => 'ContactsController@getContacts'));
Route::post('/save_contact', array('as'=>'save_contact', 'uses'=> 'ContactsController@saveContact'));

//
Route::get('/cron-queue',function(){
	return json_encode(array(array('data1'),array('data2'),array('data3'),array('data4')));
});

//
use Illuminate\Support\Facades\App;
Route::get('/bridge', function() {
    $pusher = App::make('pusher');
    $pusher->trigger( 'contacts-channel',
                      'contacts-event', 
                      array('text' => 'Preparing the Pusher Laracon.eu workshop!'));
    //return view('welcome');
});*/