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
    protected $table = 'fcm_site_manager_alias';
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
        if(count($rows) > 0) {
            $rows['mtpPartString']= !empty($rows['mtpPartString']) ? $rows['mtpPartString'] : $this->getDefaultValue('mtpPartString');
            $rows['fiberPartString']= !empty($rows['fiberPartString']) ? $rows['fiberPartString'] : $this->getDefaultValue('fiberPartString');
            $rows['mtpDescString']= !empty($rows['mtpDescString']) ? $rows['mtpDescString'] : $this->getDefaultValue('mtpDescString');
            $rows['fiberDescString']= !empty($rows['fiberDescString']) ? $rows['fiberDescString'] : $this->getDefaultValue('fiberDescString');
            return $rows;
        } else {
            
            return array(
                        'mtpPartString'=>$this->getDefaultValue('mtpPartString'),
                        'fiberPartString'=>$this->getDefaultValue('fiberPartString'),
                        'mtpDescString'=>$this->getDefaultValue('mtpDescString'),
                        'fiberDescString'=>$this->getDefaultValue('fiberDescString'),
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
        }

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

  public function getDefaultValue($key) {
    $defaults = array('mtpPartString'=>'{corePart}{strandsPart}{connectorAPart}{PolishAPart}{connectorBPart}{PolishBPart}{typePart}{shapePart}{colorPart}{pinoutPart}-{sizeunit}',
                     'fiberPartString'=>'{corePart}{strandsPart}{connectorAPart}{PolishAPart}{connectorBPart}{PolishBPart}{typePart}{diameterPart}{colorPart}-{sizeunits}',
                     'mtpDescString'=>'MTP/MPO {strandsDes} {coreDes} {connectorADes}/{PolishADes} to {connectorBDes}/{PolishBDes} {typeDes} {shapeDes} {colorDes} {pinoutDes} {sizeunit}',
                     'fiberDescString'=>'Fiber Jumper {strandsDes} {coreDes} {connectorADes}/{PolishADes} to {connectorBDes}/{PolishBDes} {typeDes} {diameterDes} {colorDes} {sizeunit}',
                     'mtpPartSuffix'=>'',
                     'fiberPartSuffix'=>'',
                     'mtpDescSuffix'=>'',
                     'fiberDescSuffix'=>'',
                     'mtpPartPrefix'=>'',
                     'fiberPartPrefix'=>'',
                     'mtpDescPrefix'=>'',
                     'fiberDescPrefix'=>'',
                     'id'=>NULL,
                     );
    return  $defaults[$key];
  }

}// class ends here 
