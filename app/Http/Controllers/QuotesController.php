<?php namespace App\Http\Controllers;

use \App\Models\Quote;
use \App\Models\Customer;

use Illuminate\Routing\Controller as BaseController;  // <<< See here - no real class, only an alias
use View, Input, Auth, Image;

class quotesController extends BaseController {
	/**
	 * [$quote description]
	 * @var [type]
	 */
	private $quote;

	/**
	 * [__construct description]
	 */
	public function __construct(){
		$this->middleware('auth');
		$this->quote = new Quote();
	}

	public function getQuote () {
		$data = $this->quote->getQuote(Input::get('customer'));
		if($data == NULL) {
			$data = $this->quote->nullArray;
		}
		return json_encode($data);
	}

	public function saveQuote () {
		$formData = Input::all();
		// $formData['message'] = strip_tags($formData['message']);
		// $formData['terms'] = strip_tags($formData['terms']);
		
		$this->quote->fill($formData);
		if($this->quote->isValid()) {
			if(Input::get('id') == NULL || Input::get('id') == 0) {
				$this->quote->save();

			} else {
				$this->quote->find(Input::get('id'))->fill($formData)->update();
				//$this->quote->updateRecord($formData);
			}
			$this->quote->broadCastNotification(array(
					'text'=> "Quote Settings saved for Customer ID: ". $formData['fkCustomerID'].', By '.Auth::user()->name
					),
					'site_manager',
					'settings'
				);
			echo $this->quote->id;
			
			// savging customer session used on page relaod 

			session(['fkCustomerID' => $formData['fkCustomerID']]);
		
		} else {
			return json_encode($this->quote->errors);
		}
	}
}