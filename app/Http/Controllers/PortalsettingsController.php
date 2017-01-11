<?php namespace App\Http\Controllers;

use \App\Models\WhitelabelPortal;
use \App\Models\Customer;
use \App\Models\Log;

use Illuminate\Routing\Controller as BaseController;  // <<< See here - no real class, only an alias
use View, Input, Auth, Image;

class PortalsettingsController extends BaseController {
	/**
	 * [$portal description]
	 * @var [type]
	 */
	private $portal;
	private $customer;
	private $logger;

	/**
	 * [__construct description]
	 */
	public function __construct(){
		$this->middleware('auth');
		$this->portal = new WhitelabelPortal();
		$this->customer = new Customer();
		$this->logger = new Log();
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

	/**
	 * [loadCustomerForm description]
	 * @param  [type] $customer [description]
	 * @return [type]           [description]
	 */
	public function loadCustomerForm ($customer) {
		$data = array();
		if($customer != false) {
			$data = $this->portal->where('fkCustomerID','=', $customer)->first();
		}		
		
		return view('portal_settings.form', json_decode(json_encode($data), TRUE));
	}

	/**
	 * [customerPriceFormula description]
	 * @return [type] [description]
	 */
	public function customerPriceFormula ($customer) {
		$data = array();
		if($customer != false) {
			$data = $this->portal->getCustomerFormula($customer);
		}		
		echo json_encode($data);
	}

	/**
	 * [saveSettings description]
	 * @return [type] [description]
	 */
	public function saveSettings () {
		$formData = Input::all();
		$formData['created_by'] = Auth::user()->name;
		$formData['lastUpdateTime'] = date('Y-m-d', time());
		$formData['lastUpdateByUser'] =Auth::user()->name;
		$this->portal->fill($formData);
		$updateList='no';
		if($this->portal->isValid()) {
			if(Input::get('id') == NULL || Input::get('id') == 0) {
				$oldData = array();
				$this->portal->save();
				//creating log
				$this->logger->createLog(Auth::user()->name, 'Portal Settings', 'New Entry', $formData, $oldData );
			} else {
				$updateList='yes';
				
				$oldData = $this->portal->where('id','=',$formData['id'])->first();
				// var_dump($oldData);
				// echo "<br/>------------------------------";
				// var_dump($formData);
				//exit($formData['id']);
				$this->portal->find($formData['id'])->fill($formData)->update();
				//$this->portal->updateRecord($formData);
				//creating log
				$this->logger->createLog(Auth::user()->name, 'Portal Settings', 'Update', $formData, $oldData);
			}
			//Pusher Event Trigger
			$this->portal->broadCastNotification(array(
					'text'=> "Basic Settings saved for:". $formData['fkCustomerID'].', By '.Auth::user()->name,
					'reLoadCustomer'=> $updateList
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

	/**
	 * [deletePortal description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function deletePortal ($id) {
		$data = $this->portal->where('id','=', $id)->first();
		$check = $this->portal->deletePortal($id);
		//creating log
		$this->logger->createLog(Auth::user()->name, 'Portal Settings', 'Data Deleted', array() ,$data );
		//Pusher Event Trigger
		$this->portal->broadCastNotification(array(
				'text'=> "Site Manager Entry for ". $data->site_name.' has been deleted,'.' By '.Auth::user()->name,
				'reLoadCustomer'=> 'no'
				),
				'site_manager',
				'settings'
			);
		return $check;
	}

	/**
	 * [uploadLogo description]
	 * @return [type] [description]
	 */
	public function uploadLogo() {
		if(Input::get('background') == null) {
			if(Input::get('company_logo') == null) {
				$image = Input::file('file');
				$imageName = time().'.'.$image->getClientOriginalExtension();
				$base = '../../configurator.blixx/public_html/images/logo/';
				$path = public_path($base.$imageName );

				Image::make($image->getRealPath())->resize(200, 200)->save(public_path($base.'quotes_'.$imageName ));
				Image::make($image->getRealPath())->resize(187, 64)->save(public_path($base.'login_'.$imageName ));
				Image::make($image->getRealPath())->resize(117, 40)->save(public_path($base.'config_'.$imageName ));
		        
		        return $imageName;
		    } else {
		    	$image = Input::file('file');
				$imageName = time().'.'.$image->getClientOriginalExtension();
				$base = '../../configurator.blixx/public_html/images/logo/';
				$path = public_path($base.$imageName );
				Image::make($image->getRealPath())->resize(87, 48)->save(public_path($base.$imageName ));	        
		        return $imageName;
		    }
		} else {
				$image = Input::file('file');
				$imageName = time().'.'.$image->getClientOriginalExtension();
				$base = '../../configurator.blixx/public_html/images/logo/';
				$path = public_path($base.$imageName );
				Image::make($image->getRealPath())->save(public_path($base.$imageName ));
		        return $imageName;	
		}
	}

	/**
	 * [getPortalDetail description]
	 * @return [type] [description]
	 */
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