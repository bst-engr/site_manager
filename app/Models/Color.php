<?php
namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\App;
use DB;

class Color extends Model
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
    protected $table = 'site_manager_color';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'loginButtonColor',
        'signupButtonColor',
        'configuratorColor',
        'customPartColor',
        'fkSiteId'
    ];

    /**
     * [$nullFields description]
     * @var array
     */
    public $nullFields = [
        'id' => '',
        'loginButtonColor' => '',
        'signupButtonColor' => '',
        'configuratorColor' => '',
        'customPartColor' => '',
        'fkSiteId' => ''
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

    

}
