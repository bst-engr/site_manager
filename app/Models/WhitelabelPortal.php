<?php
namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes; // <-- This is required
use Illuminate\Support\Facades\App;

use Validator;
use DB;

class WhitelabelPortal extends Model
{
    use SoftDeletes; // <-- Use This Instead Of SoftDeletingTrait

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
    protected $table = 'site_manager';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

     public $nullArray = [
        'id'=>NULL,
        'site_name'=>'',
        'site_url'=>'',
        'created_by'=>'',
        'lastUpdateTime'=>'',
        'fkCustomerID'=>'',
        'lastUpdateByUser'=>'',
        'loginMessage'=>'',
        'signupMessage'=>'',
        'catPrefix'=>'',
        'catSuffix'=>'',
        'site_logo'=>'',
        'loginButtonColor' => '',
        'configuratorColor' =>'',
        'customPartColor' => ''
    ];

    protected $fillable = [
        'id',
        'site_name',
        'site_url',
        'created_by',
        'lastUpdateTime',
        'fkCustomerID',
        'lastUpdateByUser',
        'loginMessage',
        'signupMessage',
        'catPrefix',
        'catSuffix',
        'site_logo',
        'loginButtonColor',
        'configuratorColor',
        'customPartColor'
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
                                'site_name' => 'required',
                                'site_url' => 'required',
                                'fkCustomerID' => 'required',
                                'loginMessage' => 'required',
                                'signupMessage' => 'required',
                                'site_logo' => 'required',
                                'loginButtonColor' => 'required' ,
                                'configuratorColor' => 'required',
                                'customPartColor' => 'required'
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
    public function getPortals () {
        return $this->whereNull('deleted_at')
                ->join('customers','customers.pkCustomerID','=', $this->table.'.fkCustomerID')
                ->get();
    }

    public function updateRecord($formData) {
        
        $check = $this->find($formData['id'])->save();
            /*->update(
                    array(
                        'site_name' => $formData['site_name'],
                        'site_url' => $formData['site_url'],
                        'created_by' => $formData['created_by'],
                        'lastUpdateTime' => $formData['lastUpdateTime'],
                        'fkCustomerID' => $formData['fkCustomerID'],
                        'lastUpdateByUser' => $formData['lastUpdateByUser'],
                        'loginMessage' => $formData['loginMessage'],
                        'signupMessage' => $formData['signupMessage'],
                        'catPrefix' => $formData['catPrefix'],
                        'catSuffix' => $formData['catSuffix'],
                        'site_logo' => $formData['site_logo'],
                        'loginButtonColor' => $formData['loginButtonColor'],
                        'configuratorColor' => $formData['configuratorColor'],
                        'customPartColor' => $formData['customPartColor']
                    )
                );*/
        return $check;
    }

    public function deletePortal ($id){
        $check = $this->find($id)->delete();
        return 'done';
    }

}
