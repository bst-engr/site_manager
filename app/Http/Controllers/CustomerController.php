<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Input;
//Model to be used
use \App\Models\Customer;
use Request;

class CustomerController extends Controller
{
    private $customer;

    public function __construct() {
    	$this->customer = New Customer;
    }

    public function LoadCustomers()
    {
        return $this->customer->getCustomerList();
    }

    public function getSession(Request $request)  {

        if (session()->has('fkCustomerID')) {
        		
        	$fkCustomerID=session('fkCustomerID');
        	echo $fkCustomerID;
        
        }
         else
         echo "NULL";	
    }

}