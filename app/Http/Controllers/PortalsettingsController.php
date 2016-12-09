<?php namespace App\Http\Controllers;

use \App\Models\WhitelabelPortal;
use \App\Models\Customer;

use Illuminate\Routing\Controller as BaseController;  // <<< See here - no real class, only an alias
use View, Input, Auth, Image;

class PortalsettingsController extends BaseController {
	/**
	 * [$portal description]
	 * @var [type]
	 */
	private $portal;
	private $customer;

	/**
	 * [__construct description]
	 */
	public function __construct(){
		$this->middleware('auth');
		$this->portal = new WhitelabelPortal();
		$this->customer = new Customer();
	}

	/**
	 * 
	 */
	public function index() {
		return view('portal_settings.list');
	}
	
	/**
	 * [loadForm description]
	 * @return [type] [description]
	 */
	public function loadForm () {
		return view('portal_settings.form');
	}

	public function loadCustomerForm ($customer) {
		$data = array();
		if($customer != false) {
			$data = $this->portal->where('fkCustomerID','=', $customer)->first();
		}		
		
		return view('portal_settings.form', json_decode(json_encode($data), TRUE));
	}
	public function saveSettings () {
		$formData = Input::all();
		$formData['created_by'] = Auth::user()->name;
		$formData['lastUpdateTime'] = date('Y-m-d', time());
		$formData['lastUpdateByUser'] =Auth::user()->name;
		$this->portal->fill($formData);
		if($this->portal->isValid()) {
			if(Input::get('id') == NULL || Input::get('id') == 0) {
				$this->portal->save();
			} else {
				//exit(Input::get('id'));
				$this->portal->find(Input::get('id'))->fill($formData)->update();
				//$this->portal->updateRecord($formData);
			}
			//Pusher Event Trigger
			$this->portal->broadCastNotification(array(
					'text'=> "Basic Settings saved for:". $formData['fkCustomerID'].', By '.Auth::user()->name
					),
					'site_manager',
					'settings'
				);
			echo $this->portal->id;
			
			// savging customer session used on page relaod 

			session(['fkCustomerID' => $formData['fkCustomerID']]);
		
		} else {
			return json_encode($this->portal->errors);
		}

	}

	public function deletePortal ($id) {
		$data = $this->portal->where('id','=', $id)->first();
		$check = $this->portal->deletePortal($id);
		//Pusher Event Trigger
		$this->portal->broadCastNotification(array(
				'text'=> "Site Manager Entry for ". $data->site_name.' has been deleted,'.' By '.Auth::user()->name
				),
				'site_manager',
				'settings'
			);
		return $check;
	}

	public function uploadLogo() {
		$image = Input::file('file');
		$imageName = time().'.'.$image->getClientOriginalExtension();
		$path = public_path('images/logos'.$imageName );

		Image::make($image->getRealPath())->resize(200, 200)->save(public_path('images/logos/quotes_'.$imageName ));
		Image::make($image->getRealPath())->resize(200, 200)->save(public_path('images/logos/login_'.$imageName ));
		Image::make($image->getRealPath())->resize(200, 200)->save(public_path('images/logos/config_'.$imageName ));
        
        return $imageName;
	}

	public function getPortalDetail () {
		
        $data=$this->portal->where('fkCustomerID', '=', Input::get('customerId'))->first();
         
        if($data==NULL) {
        
        $companyName=$this->customer->getCustomerData("companyName",Input::get('customerId'));
        $companyNameArray=explode(" ",$companyName);

        $companyName= $companyNameArray[1];


        $sugggestion="configurator.com/".$companyName;

       
        $arrayNew = array_except($companyNameArray, [0]);
        array_set($this->portal->nullArray, 'site_name',implode(" ", $arrayNew));
     
        array_set($this->portal->nullArray, 'site_url',$sugggestion);
        return json_encode($this->portal->nullArray);	
        
        }
        else  
		return json_encode($data);
	}
	/**
	 * 
	 */
	public function portals() {
		return json_encode($this->portal->getPortals());
	}

}