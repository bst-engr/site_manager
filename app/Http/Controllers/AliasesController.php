<?php namespace App\Http\Controllers;

use \App\Models\Alias;
use \App\Models\AliasFormula;
use Illuminate\Routing\Controller as BaseController;  // <<< See here - no real class, only an alias
use View,Input;
class AliasesController extends BaseController {
	/**
	 * [$portal description]
	 * @var [type]
	 */
	private $alias;
	private $aliasFormula;

	/**
	 * [__construct description]
	 */
	public function __construct(){
		$this->middleware('auth');
		$this->alias = new Alias();
		$this->aliasFormula=new AliasFormula();
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
		 
	   $this->alias->where('site', $postData['site'] )
       ->where('fkCustomerID',$postData['fkCustomerID'])
       ->where('aliasPart',$postData['lastPart'])
       ->where ('aliasDescription',$postData['lastDescription'])
       ->update(['aliasPart' => $postData['aliasPart'],'aliasDescription'=>$postData['aliasDescription']]);

	}

	public function getAliasFormula() {

       $postData = Input::all();
		
	   $data=$this->aliasFormula->getCustomerAliasFormula($postData['fkCustomerID']);
       
       return $data;
	}

	public function saveAliasFormula() {

       $postData = Input::all();
		
	   $data=$this->aliasFormula->saveCustomerAliasFormula($postData);
       
      return json_encode($data);
      
	}

}