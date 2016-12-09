<?php
namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\App;
use DB;

class Contacts extends Authenticatable
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
    protected $table = 'contacts';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'user_id', 'phone_number'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function __construct()
    {
        //$this->pusher = new Pusher();
    }

    public function preparePusherList()
    {
        $list = $this->getAllContacts();
        
        
        // $pusher = App::make('pusher');
        // $pusher->trigger(   
        //                     'contacts-channel',
        //                     'contacts-event', 
        //                     array('contacts'=> $list)
        //                 );
        // return true;
    }

    public function saveContact ($formData) {
        // $pusher = App::make('pusher');
        // $pusher->trigger(   
        //                     'contacts-channel',
        //                     'contact-updated', 
        //                     array('contact'=> $formData)
        //                 );
        // if(!empty($formData['contact_id'])) {
        //     $this->where('contact_id','=', $formData['contact_id'])
        //         ->update(
        //                 array(
        //                     'user_id'=> $formData['user_id'],
        //                     'name'=> $formData['name'],
        //                     'email'=> $formData['email'],
        //                     'phone_number'=> $formData['phone_number'],
        //                 )
        //             );
        // } else {
        //     $this->insert(
        //                 array(
        //                     'user_id'=> $formData['user_id'],
        //                     'name'=> $formData['name'],
        //                     'email'=> $formData['email'],
        //                     'phone_number'=> $formData['phone_number'],
        //                 )
        //             );
        // }
        
        // return true;
    }

    private function getAllContacts() {
        //var_dump($this->get());
        $contacts = $this->get();
        $temp=array();
        foreach ($contacts as $contact) {
            $temp[] = array(
                            'contact_id' => $contact->contact_id,
                            'user_id' => $contact->user_id,
                            'name' => $contact->name,
                            'email' => $contact->email,
                            'phone_number' => $contact->phone_number,
                            'avatar' => $contact->avatar,
                            'added_on' => $contact->added_on,
                            'status' => $contact->status,
                        );
        }
        //var_dump($temp);
        return array("event"=>'tests', 'id'=>'1', 'operatons'=>'test');//json_encode($temp);
    }
}
