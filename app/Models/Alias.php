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
    protected $table = 'customer_alias';
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

    public function getCustomerAliasList ($customer = false, $site) {
        $customerCheck = '';
        $customerCheck = $this->where('fkCustomerID','=', $customer)->get();
        $query = '';
        if($customer != false && count($customerCheck) > 0 ) {
            $query = "select DISTINCT customer_alias.partNumber as partNumber, vendor_details.cableId as productType, vendor_details.partNumber as dbRef, vendor_details.fieldTable as fieldTable, IFNULL(customer_alias.aliasPart, vendor_details.aliasPartNumber) as aliasPart,IFNULL(customer_alias.aliasDescription, vendor_details.aliasDes) as aliasDescription  
                      from vendor_details , customer_alias where 
                      customer_alias.fieldTable=vendor_details.fieldTable 
                      and customer_alias.partNumber=vendor_details.partNumber 
                      and (vendor_details.cableId = 151 or  vendor_details.cableId = 278)".' 
                      and fkCustomerID = '.$customer;
            /*$query =    $this->where('fkCustomerID', '=', $customer)
                            ->where ('vendor_details.cableId', 'in', array(180,278))
                            ->where ('customer_alias.partNumber','=','vendor_details.partNumber')
                            ->join('vendor_details', 'customer_alias.fieldTable','=','vendor_details.fieldTable')
                            ->select(  'customer_alias.partNumber as partNumber', 
                                    'vendor_details.cableId as productType', 
                                    'vendor_details.partNumber as dbRef', 
                                    'vendor_details.fieldTable as fieldTable', 
                                    DB::raw('IFNULL(customer_alias.aliasPart, vendor_details.aliasPartNumber) as aliasPart') ,
                                    DB::raw('IFNULL(customer_alias.aliasDescription, vendor_details.aliasDes) as aliasDescription')
                                );*/
        } else {
            $query = "select DISTINCT vendor_details.partNumber as partNumber, 
                     vendor_details.cableId as productType, 
                     vendor_details.partNumber as dbRef, vendor_details.fieldTable as fieldTable, 
                     vendor_details.aliasPartNumber as aliasPart, 
                     vendor_details.aliasDes as aliasDescription   
                     from vendor_details where (vendor_details.cableId = 151 or  vendor_details.cableId = 278)";
          /*  $query =    DB::table('vendor_details')
                            ->where ('vendor_details.cableId', 'in', array(180,278))
                            ->select(  
                                    'vendor_details.partNumber as partNumber', 
                                    'vendor_details.cableId as productType', 
                                    'vendor_details.partNumber as dbRef', 
                                    'vendor_details.fieldTable as fieldTable', 
                                    'vendor_details.aliasPartNumber as aliasPart' ,
                                    'vendor_details.aliasDes as aliasDescription'
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
              
              DB::table('customer_alias')->insert($default);
            }
          //$this->save();
         
        }
        // return $query->get();
       return DB::select($query);
        
    }
}
