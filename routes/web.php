<?php
/**
 * Author: Muhammad Basit Munir
 * Date: Nov 24 2016
 */
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', array('as'=> 'home', 'uses'=> 'PortalsettingsController@index'));

Route::get('/dashboard', array('as' => 'dashboard', 'uses' => 'HomeController@dashboard'));
Route::get('/contacts', array('as' => 'contacts', 'uses' => 'ContactsController@contactList'));

/******************************************************************
***********	Whitelabel Portal Authentication **********************
*******************************************************************/

/******************************************************************
 **********	Whitelabel Portal Settings ****************************
*******************************************************************/
Route::group(['prefix' => 'portal'], function()
{
	//Get Requests
   	Route::get('/', array('as'=> 'portal_dashboard', 'uses'=> 'PortalsettingsController@index'));
   	Route::get('/settings', array('as'=> 'portal_list', 'uses'=> 'PortalsettingsController@loadForm'));
      Route::get('/edit/setting/{customer}', array('as'=> 'customer_portal_edit', 'uses'=> 'PortalsettingsController@loadCustomerForm'));
      Route::post('/delete/{portal_id}', array('as'=> 'delete_portal_edit', 'uses'=> 'PortalsettingsController@deletePortal'));
   	//Post Requests
   	Route::post('/list', array('as'=> 'portal_list', 'uses'=> 'PortalsettingsController@portals'));
   	Route::post ('/save_settings', array('as'=> 'save_portal_settings', 'uses'=> 'PortalsettingsController@saveSettings'));
   	Route::post ('/upload_logo', array('as'=> 'upload_logo', 'uses'=> 'PortalsettingsController@uploadLogo'));
   	Route::post ('/detail', array('as'=> 'upload_logo', 'uses'=> 'PortalsettingsController@getPortalDetail'));
});

/******************************************************************
***********	Portal Aliases Settings *******************************
*******************************************************************/
Route::group(['prefix' => 'aliases'], function()
{
   Route::post('/{customer?}', array('as'=> 'fetchAliases', 'uses'=> 'AliasesController@getAliases'));
   Route::post('/edit/editAliases', array('as'=> 'editAliases', 'uses'=> 'AliasesController@editAliases'));
   Route::post('/getFomula/getAliasFormula', array('as'=> 'getAliasFormula', 'uses'=> 'AliasesController@getAliasFormula'));
   Route::post('/getFomula/saveAliaseFormula', array('as'=> 'saveAliasFormula', 'uses'=> 'AliasesController@saveAliasFormula'));

});

/******************************************************************
*********** Markup Settings ***************************************
*******************************************************************/
Route::group(['prefix' => 'markups'], function()
{
   Route::post('/', array('as'=> 'fetchMarkups', 'uses'=> 'MarkupsController@getMarkups'));
   Route::post('/save', array('as'=> 'saveMarkups', 'uses'=> 'MarkupsController@saveMarkups'));
   Route::post('/remove', array('as'=> 'removeMarkups', 'uses'=> 'MarkupsController@removeMarkup'));
});

/******************************************************************
*********** Markup Settings ***************************************
*******************************************************************/
Route::group(['prefix' => 'colors'], function()
{
   Route::post('/', array('as'=> 'fetchColors', 'uses'=> 'ColorsController@getCustomerColors'));
});

/******************************************************************
*********** Markup Settings ***************************************
*******************************************************************/
Route::group(['prefix' => 'quotes'], function()
{
   Route::post('/', array('as'=> 'fetchQuote', 'uses'=> 'QuotesController@getQuote'));
   Route::post('/save', array('as'=> 'saveQuote', 'uses'=> 'QuotesController@saveQuote'));
});

/******************************************************************
***********	 Customer Controllers *********************************
*******************************************************************/
Route::group(['prefix' => 'customers'], function()
{
   Route::post('load_customers', array('as'=> 'load_customers', 'uses'=> 'CustomerController@LoadCustomers'));
   Route::post('customer_session', array('as'=> 'customer_session', 'uses'=> 'CustomerController@getSession'));
});


/********************************************************/

Route::get('/phpinfo', function(){
	phpinfo();
	die();
});
Auth::routes();

Route::get('/home', 'HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index');
