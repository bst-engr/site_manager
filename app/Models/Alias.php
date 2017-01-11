<?php
namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\App;
use DB;

class Alias extends Model
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
    protected $table = 'fcm_customer_alias';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        
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
    protected $primaryKey = '';

    public $errors;
    
    public static $rules = array(
                                
                            );
    /**
     * [__construct description]
     */
    public function __construct()
    {
        
    }
   
   public function getAliasRow($customer,$part) {

     $query = "select DISTINCT fcm_customer_alias.partNumber as partNumber, fcm_vendor_details.aliasPartNumber, fcm_vendor_details.cableId as productType, fcm_vendor_details.partNumber as dbRef, fcm_vendor_details.fieldTable as fieldTable, IFNULL(fcm_customer_alias.aliasPart, fcm_vendor_details.aliasPartNumber) as aliasPart,IFNULL(fcm_customer_alias.aliasDescription, fcm_vendor_details.aliasDes) as aliasDescription  
                      from fcm_vendor_details , fcm_customer_alias where 
                      fcm_customer_alias.fieldTable=fcm_vendor_details.fieldTable 
                      and fcm_customer_alias.partNumber=fcm_vendor_details.partNumber 
                      and (fcm_vendor_details.cableId = 151 or  fcm_vendor_details.cableId = 278)".' 
                      and fkCustomerID = '.$customer." and fcm_customer_alias.partNumber='{$part}'";

     return DB::select($query);

   }
    
    public function getCustomerAliasList ($customer = false, $site) {
        $customerCheck = '';
        $customerCheck = $this->where('fkCustomerID','=', $customer)->get();
        $query = '';
        if($customer != false && count($customerCheck) > 0 ) {
            $query = "select DISTINCT fcm_customer_alias.partNumber as partNumber, fcm_vendor_details.aliasPartNumber, fcm_vendor_details.cableId as productType, fcm_vendor_details.partNumber as dbRef, fcm_vendor_details.fieldTable as fieldTable, IFNULL(fcm_customer_alias.aliasPart, fcm_vendor_details.aliasPartNumber) as aliasPart,IFNULL(fcm_customer_alias.aliasDescription, fcm_vendor_details.aliasDes) as aliasDescription  
                      from fcm_vendor_details , fcm_customer_alias where 
                      fcm_customer_alias.fieldTable=fcm_vendor_details.fieldTable 
                      and fcm_customer_alias.partNumber=fcm_vendor_details.partNumber 
                      and (fcm_vendor_details.cableId = 151 or  fcm_vendor_details.cableId = 278)".' 
                      and fkCustomerID = '.$customer." order by fieldTable asc ";
            /*$query =    $this->where('fkCustomerID', '=', $customer)
                            ->where ('fcm_vendor_details.cableId', 'in', array(180,278))
                            ->where ('fcm_customer_alias.partNumber','=','fcm_vendor_details.partNumber')
                            ->join('fcm_vendor_details', 'fcm_customer_alias.fieldTable','=','fcm_vendor_details.fieldTable')
                            ->select(  'fcm_customer_alias.partNumber as partNumber', 
                                    'fcm_vendor_details.cableId as productType', 
                                    'fcm_vendor_details.partNumber as dbRef', 
                                    'fcm_vendor_details.fieldTable as fieldTable', 
                                    DB::raw('IFNULL(fcm_customer_alias.aliasPart, fcm_vendor_details.aliasPartNumber) as aliasPart') ,
                                    DB::raw('IFNULL(fcm_customer_alias.aliasDescription, fcm_vendor_details.aliasDes) as aliasDescription')
                                );*/
        } else {
            $query = "select DISTINCT fcm_vendor_details.partNumber as partNumber,  fcm_vendor_details.aliasPartNumber,
                     fcm_vendor_details.cableId as productType, 
                     fcm_vendor_details.partNumber as dbRef, fcm_vendor_details.fieldTable as fieldTable, 
                     fcm_vendor_details.aliasPartNumber as aliasPart, 
                     fcm_vendor_details.aliasDes as aliasDescription   
                     from fcm_vendor_details where (fcm_vendor_details.cableId = 151 or  fcm_vendor_details.cableId = 278) order by fieldTable asc";
          /*  $query =    DB::table('fcm_vendor_details')
                            ->where ('fcm_vendor_details.cableId', 'in', array(180,278))
                            ->select(  
                                    'fcm_vendor_details.partNumber as partNumber', 
                                    'fcm_vendor_details.cableId as productType', 
                                    'fcm_vendor_details.partNumber as dbRef', 
                                    'fcm_vendor_details.fieldTable as fieldTable', 
                                    'fcm_vendor_details.aliasPartNumber as aliasPart' ,
                                    'fcm_vendor_details.aliasDes as aliasDescription'
                                );*/
           
           // setting Query Array to save default template
            if(!empty($site)) {
               $aliasList=DB::select($query);
               
               for($i=0;$i<count($aliasList);$i++) {
                 
                 $default[]=array("partNumber"=>$aliasList[$i]->partNumber,
                                  "fieldTable"=>$aliasList[$i]->fieldTable,'fkCustomerID'=>$customer,
                                  "aliasPart"=>$aliasList[$i]->aliasPart,"aliasDescription"=>$aliasList[$i]->aliasDescription,
                                  "site"=>$site);
                
               } // loop ends here
              
              DB::table('fcm_customer_alias')->insert($default);
            }
          //$this->save();
         
        }
        // return $query->get();
       return DB::select($query);
        
    }
}
