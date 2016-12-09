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
    protected $table = 'site_manager_domains';
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
                                'catMarkup' => 'required',
                                'mtpMarkup' => 'required',
                                'fibermarkup' => 'required',
                                'domainLevel' => 'required',
                                'attachCsvFlag' => 'required',
                                'costColunmName' => 'required'
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
        return $this->where('fkCustomerID', '=', $customer)->get();
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
                        'fkCustomerID' => $formData['fkCustomerID'],                                  
                    )
                );
        return $check;
    }

}
