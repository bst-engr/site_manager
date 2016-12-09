<?php namespace App\Http\Controllers;

use \App\Models\Contacts;
use Illuminate\Routing\Controller as BaseController;  // <<< See here - no real class, only an alias
use View,Input;
class ContactsController extends BaseController {

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
	private $contacts;
	public function __construct(){
		$this->contacts = new Contacts();
	}

	public function showWelcome()
	{
		return View::make('hello');
	}

	public function contactList() {
		return View::make('contacts.contacts');
	}

	public function getContacts() {
		$contacts = $this->contacts->take(80)->get();
		echo json_encode($contacts);
	}	

	public function contactDetail($id) {
		$contacts = $this->contacts->where('contact_id','=', $id)->first();
		echo json_encode($contacts);
	}

	public function saveContact() {
		$contact = $this->contacts->saveContact(Input::all());
		echo $contact;	
	}
	public function create() {

	}

	public function update($id) {
		$this->contacts->updateContact($id);
		$this->contacts->preparePusherList();
		return "Updated";
	}

}