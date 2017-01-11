<?php namespace App\Http\Controllers;

use \App\Models\Markup;
use \App\Models\Customer;
use \App\Models\Log;

use Illuminate\Routing\Controller as BaseController;  // <<< See here - no real class, only an alias
use View, Input, Auth, Image;


class MarkupsController extends BaseController {
	/**
	 * [$markup description]
	 * @var [type]
	 */
	private $markup;
	private $logger;

	/**
	 * [__construct description]
	 */
	public function __construct(){
		$this->middleware('auth');
		$this->markup = new Markup();
		$this->logger = new Log();
	}

	public function getMarkups () {
		return json_encode($this->markup->getMarkups(Input::get('customer')));
	}

	public function saveMarkups () {
		$formData = Input::all();
		
		$this->markup->fill($formData);
		if($this->markup->isValid()) {
			if(Input::get('id') == NULL || Input::get('id') == 0) {
				$this->markup->save();
				//creating log
				$this->logger->createLog(Auth::user()->name, 'Markup Settings', 'New Entry', $formData , array() );
			} else {
				$oldData = $this->markup->where('id','=',Input::get('id'))->first();
				$this->markup->find(Input::get('id'))->fill($formData)->update();
				//$this->markup->updateRecord($formData);
				//creating log
				$this->logger->createLog(Auth::user()->name, 'Markup Settings', 'Update', $formData, $oldData );
			}
			$this->markup->broadCastNotification(array(
					'text'=> "Markup saved for Customer ID: ". $formData['fkCustomerID']. ", for Domain: ".$formData['domain'].', By '.Auth::user()->name,
					'reLoadCustomer'=> 'no'
					),
					'site_manager',
					'settings'
				);
			echo $this->markup->id;
			
			// savging customer session used on page relaod 

			session(['fkCustomerID' => $formData['fkCustomerID']]);
		
		} else {
			return json_encode($this->markup->errors);
		}
	}

	/**
	 * [removeMarkup description]
	 * @return [type] [description]
	 */
	public function removeMarkup () {
		$formData = Input::all();
		$this->markup->find($formData['id'])->delete();
		//creating log
		$this->logger->createLog(Auth::user()->name, 'Markup Settings', 'Remove', array(), $formData );

		$this->markup->broadCastNotification(array(
					'text'=> "Markup saved for Customer ID: ". $formData['fkCustomerID']. ", for Domain: ".$formData['domain'].', By '.Auth::user()->name,
					'reLoadCustomer'=> 'no'
					),
					'site_manager',
					'settings'
				);
	}
}