<?php namespace App\Http\Controllers;

use \App\Models\Alias;
use \App\Models\AliasFormula;
use \App\Models\Log;

use Illuminate\Routing\Controller as BaseController;  // <<< See here - no real class, only an alias
use View,Input, Auth;

class AliasesController extends BaseController {
	/**
	 * [$portal description]
	 * @var [type]
	 */
	private $alias;
	private $aliasFormula;
	private $logger;

	/**
	 * [__construct description]
	 */
	public function __construct(){
		$this->middleware('auth');
		$this->alias = new Alias();
		$this->aliasFormula=new AliasFormula();
		$this->logger = new Log();
	}

	/**
	 * 
	 */
	public function getAliases($customer=false) {

		 $postData = Input::all();

		return json_encode($this->alias->getCustomerAliasList($customer,$postData['siteName']));

	}

	public function editAliases() {

	   $postData = Input::all();
	   $oldData = $this->alias->where('fkCustomerID',$postData['fkCustomerID'])
       ->where('partNumber',$postData['dbref'])
       ->first();

	   $this->alias->where('fkCustomerID',$postData['fkCustomerID'])
       ->where('partNumber',$postData['dbref'])
       ->update(['aliasPart' => $postData['aliasPart'],'aliasDescription'=>$postData['aliasDescription']]);
       
       //saving logs on alias
       $this->logger->createLog(Auth::user()->name, 'Alias Settings', 'Update', $postData, $oldData );

       $data=$this->alias->getAliasRow($postData['fkCustomerID'],$postData['dbref']);

       return json_encode($data[0]);
	}

	public function getAliasFormula() {

       $postData = Input::all();
		
	   $data=$this->aliasFormula->getCustomerAliasFormula($postData['fkCustomerID']);
       
       return $data;
	}

	public function saveAliasFormula() {

       $postData = Input::all();
       //fetching Old Data to store.
		$oldData = $this->aliasFormula->getCustomerAliasFormula($postData['fkCustomerID']);

	   $data=$this->aliasFormula->saveCustomerAliasFormula($postData);
       
       //saving logs on alias
       $this->logger->createLog(Auth::user()->name, 'Alias Formula Settings', 'Update', $postData, $oldData );
      return json_encode($data);
      
	}

}