<?php
namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\App;
use DB;

class Log extends Model
{
    protected $pusher;
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'fcm_site_manager_logs';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'updated_by',
        'module',
        'action',
        'data_string'
    ];

    /**
     * [$nullFields description]
     * @var array
     */
    public $nullFields = [
        
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];
    /**
     * [$primaryKey description]
     * @var string
     */
    protected $primaryKey = 'id';

    public $errors;
    
    public static $rules = array(
                                'loginButtonColor' => 'required',
                                'configuratorColor' => 'required',
                                'customPartColor' => 'required',
                                'fkSiteId' => 'required'
                            );
    /**
     * [__construct description]
     */
    public function __construct()
    {
        
    }

    public function createLog($user, $module, $operation, $data, $oldData){
        // var_dump($data);
        // var_dump($oldData);
        $this->fill(
                    array(
                        'updated_by'=> $user,
                        'module'=> $module,
                        'action'=> $operation,
                        'data_string'=> json_encode(array('updatedData'=>$data, 'oldData'=> $oldData))
                    )
                )->save();
    }
    

}
