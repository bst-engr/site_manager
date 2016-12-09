<?php namespace App\Http\Controllers;

use \App\Models\Color;
use Illuminate\Routing\Controller as BaseController;  // <<< See here - no real class, only an alias
use View,Input;
class ColorsController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/
	private $color;

	public function __construct(){
		$this->color = new Color();
	}

	public function getCustomerColors () {
		
	}

}