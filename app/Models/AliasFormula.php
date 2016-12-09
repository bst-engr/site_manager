<?php
namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\App;
use DB;

class AliasFormula extends Model
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
    protected $table = 'site_manager_alias';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
                     'mtpPartString',
                     'fiberPartString',
                     'mtpDescString',
                     'fiberDescString',
                     'mtpPartSuffix',
                     'fiberPartSuffix',
                     'mtpDescSuffix',
                     'fiberDescSuffix',
                     'mtpPartPrefix',
                     'fiberPartPrefix',
                     'mtpDescPrefix',
                     'fiberDescPrefix',
                     'fkCustomerID'
        
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
                                
                            );
    /**
     * [__construct description]
     */
    public function __construct()
    {
        
    }

    public function getCustomerAliasFormula ($pkCustomerID) {
        
        $rows =  $this->where('fkCustomerID','=',$pkCustomerID)->select()->first();
        if(count($rows) > 0)
        return $rows;
        else
        return array('mtpPartString'=>'',
                     'fiberPartString'=>'',
                     'mtpDescString'=>'',
                     'fiberDescString'=>'',
                     'mtpPartSuffix'=>'',
                     'fiberPartSuffix'=>'',
                     'mtpDescSuffix'=>'',
                     'fiberDescSuffix'=>'',
                     'mtpPartPrefix'=>'',
                     'fiberPartPrefix'=>'',
                     'mtpDescPrefix'=>'',
                     'fiberDescPrefix'=>'',
                     'id'=>NULL,
                     'fkCustomerID'=>'');    

    } // alias formula ends here
 
 public function saveCustomerAliasFormula ($data) {

       
    $dataArray = array_except($data, ['id']);
    $this->fill($dataArray);
     
       if($data['id'] == NULL) {
                
                 $this->save();
                 $data['id']=$this->id;
                 return $data;

            } else {
                
             $this->find($data['id'])->fill($dataArray)->update();
              return $data;
            }

  }// formula Alias saved here

}// class ends here 
