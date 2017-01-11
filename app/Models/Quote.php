<?php
namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\App;
use Validator;
use DB;

class Quote extends Model
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
    protected $table = 'fcm_site_manager_quotes';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

     public $nullArray = [
        'headerEmail'=> '',
        'phone'=> '',
        'message'=> '',
        'terms'=> '',
        'quoteNumberPrefix'=> '',
        'footerLeft'=> '',
        'footerMiddle'=> '',
        'fkCustomerID'=> '',
        'adminCcEmail'=>'',
        'customPartColor'=> '',
        'smtpHost'=> '',
        'smtpPort'=> '',
        'smtpUser'=> '',
        'smtpPassword'=> '',
        'mailFrom'=> '',
        'fromName'=> '',
        'noReplyEmail'=> '',
        'costColumnAlias'=>'',
        'id'=> null
    ];

    protected $fillable = [
        'headerEmail',
        'phone',
        'message',
        'terms',
        'quoteNumberPrefix',
        'footerLeft',
        'footerMiddle',
        'fkCustomerID',
        'customPartColor',
        'adminCcEmail',
        'smtpHost',
        'smtpPort',
        'smtpUser',
        'smtpPassword',
        'mailFrom',
        'fromName',
        'noReplyEmail',
        'costColumnAlias',
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
                                'headerEmail'=> 'required',
                                'phone'=> 'required',
                                'message'=> 'required',
                                'terms'=> 'required',
                                'quoteNumberPrefix'=> 'required',
                                'footerLeft'=> 'required',
                                'footerMiddle'=> 'required',
                                'fkCustomerID'=> 'required',
                                'adminCcEmail'=>'required',
                                'customPartColor'=> 'required',
                                'smtpHost'=> 'required',
                                'smtpPort'=> 'required',
                                'smtpUser'=> 'required|alpha_num',
                                'smtpPassword'=> 'required',
                                'mailFrom'=> 'required|email',
                                'fromName'=> 'required',
                                'costColumnAlias'=> 'required',
                                'noReplyEmail' => 'required|email'
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
    public function getQuote ($customer) {
        return $this->where('fkCustomerID', '=', $customer)->first();
    }

    public function updateRecord ($formData) {
         $check = $this->where('id','=',$formData['id'])
            ->update(
                    array(
                       'headerEmail'=> $formData['headerEmail'],
                        'phone'=> $formData['phone'],
                        'message'=> $formData['message'],
                        'terms'=> $formData['terms'],
                        'quoteNumberPrefix'=> $formData['quoteNumberPrefix'],
                        'footerLeft'=> $formData['footerLeft'],
                        'footerMiddle'=> $formData['footerMiddle'],
                        'fkCustomerID'=> $formData['fkCustomerID'],
                        'adminCcEmail'=>$formData['adminCcEmail'],
                        'customPartColor'=> $formData['customPartColor'],
                        'noReplyEmail'=> $formData['noReplyEmail'],
                        'costColumnAlias'=> $formData['costColumnAlias']
                    )
                );
        return $check;
    }

}
