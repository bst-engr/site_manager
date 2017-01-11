<?php
namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\App;
use Validator;
use DB;

class Markup extends Model
{
    protected $pusher;
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'fcm_site_manager_domains';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

     public $nullArray = [
        'domain' => '',
        'catMarkup' => '',
        'mtpMarkup' => '',
        'fibermarkup' => '',
        'domainLevel' => '',
        'attachCsvFlag' => '',
        'costColunmName' => '',
        'preffered'=>'',
        'id'=> ''
    ];

    protected $fillable = [
        'domain',
        'catMarkup',
        'mtpMarkup',
        'fibermarkup',
        'domainLevel',
        'attachCsvFlag',
        'costColunmName',
        'fkCustomerID',
        'preffered',
        'id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];
    

    public $errors;
    
    public static $rules = array(
                                'domain' => 'required',
                                'catMarkup' => 'required|numeric|between:0.1,0.99',
                                'mtpMarkup' => 'required|numeric|between:0.1,0.99',
                                'fibermarkup' => 'required|numeric|between:0.1,0.99',
                                'domainLevel' => 'required',
                                'attachCsvFlag' => 'required',                                
                            );
    /**
     * [__construct description]
     */
    public function __construct()
    {
        
    }

    /**
     * [isValid description]
     * @return boolean [description]
     */
    public function isValid() {
        // mkaing validations
        $validator = Validator::make($this->attributes, static::$rules);
        
        // check if validation passes
        if($validator->passes()){

            return true;

        } else {

            // setting up error messages.
            $this->errors = $validator->messages();
            return false;
        }
    }

    /**
     * [getPortals description]
     * @return [type] [description]
     */
    public function getMarkups ($customer) {
        $rows = $this->where('fkCustomerID', '=', $customer)->get();
        //var_dump(count($rows));
        if(count($rows) == 0) { //insert default markups
            $rows = $this->defaultMarkups($customer);
        }        
        return $rows;
    }

    public function updateRecord ($formData) {
        $check = $this->where('id','=',$formData['id'])
            ->update(
                    array(
                        'domain' => $formData['domain'],
                        'catMarkup' => $formData['catMarkup'],
                        'mtpMarkup' => $formData['mtpMarkup'],
                        'fibermarkup' => $formData['fibermarkup'],
                        'domainLevel' => $formData['domainLevel'],
                        'attachCsvFlag' => $formData['attachCsvFlag'],
                        'costColunmName' => $formData['costColunmName'],
                        'preffered'=> $formData['costColunmName'],
                        'fkCustomerID' => $formData['fkCustomerID'],                                  
                    )
                );
        return $check;
    }

    public function defaultMarkups ($customer) {
        $data= array(
                array(
                        'domain' => "*.*",
                        'catMarkup' => 0.15,
                        'mtpMarkup' => 0.15,
                        'fibermarkup' =>0.15,
                        'domainLevel' => "admin",
                        'attachCsvFlag' => "Yes",
                        'costColunmName' => "",
                        'preffered'      => "Yes",  
                        'fkCustomerID' => $customer,                                  
                ),
                array(
                                'domain' => "*.*",
                                'catMarkup' => 0.15,
                                'mtpMarkup' => 0.15,
                                'fibermarkup' =>0.15,
                                'domainLevel' => "re-seller",
                                'attachCsvFlag' => "No",
                                'costColunmName' => "",
                                'preffered'      => "Yes",  
                                'fkCustomerID' => $customer,                                  
                ),
                array(
                                'domain' => "*.*",
                                'catMarkup' => 0.15,
                                'mtpMarkup' => 0.15,
                                'fibermarkup' =>0.15,
                                'domainLevel' => "end-user",
                                'attachCsvFlag' => "No",
                                'costColunmName' => "",
                                'preffered'      => "Yes",  
                                'fkCustomerID' => $customer,                                  
                ),
                array(
                                'domain' => "*.*",
                                'catMarkup' => 0.15,
                                'mtpMarkup' => 0.15,
                                'fibermarkup' =>0.15,
                                'domainLevel' => "sales-rep",
                                'attachCsvFlag' => "Yes",
                                'costColunmName' => "",
                                'preffered'      => "Yes",  
                                'fkCustomerID' => $customer,                                  
                )
            );
        //mass insertion of default templates.
        $this->insert($data);
        return $this->where('fkCustomerID', '=', $customer)->get();
    }

}
