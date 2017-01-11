<?php namespace App\Http\Controllers;

use \App\Models\Quote;
use \App\Models\Customer;
use \App\Models\Log;

use Illuminate\Routing\Controller as BaseController;  // <<< See here - no real class, only an alias
use View, Input, Auth, Image;

class quotesController extends BaseController {
	/**
	 * [$quote description]
	 * @var [type]
	 */
	private $quote;
	private $logger;
	/**
	 * [__construct description]
	 */
	public function __construct(){
		$this->middleware('auth');
		$this->quote = new Quote();
		$this->logger = new Log();
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
				$oldData = array();
				$this->quote->save();
				//creating log
				$this->logger->createLog(Auth::user()->name, 'Quote Settings', 'New Entry', $formData, $oldData );

			} else {
				$oldData = $this->quote->where('id','=',Input::get('id'))->first();
				$this->quote->find(Input::get('id'))->fill($formData)->update();
				//creating log
				$this->logger->createLog(Auth::user()->name, 'Quote Settings', 'Update', $formData, $oldData );
				//$this->quote->updateRecord($formData);
			}
			$this->quote->broadCastNotification(array(
					'text'=> "Quote Settings saved for Customer ID: ". $formData['fkCustomerID'].', By '.Auth::user()->name,
					'reLoadCustomer'=> 'yes'
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