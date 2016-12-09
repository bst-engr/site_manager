<?php
namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use DB;

class Customer extends Model 
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'customers';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [];

	/**
	 * [getAllTemplates description]
	 * @param  [type] $template [description]
	 * @param  [type] $id       [description]
	 * @return [type]           [description]
	 */

    public function getCustomerList() {
    	
		$rows =  $this->select('companyName as label', 'pkCustomerID as value')->get();
		return json_encode($rows);
    }

    public  function getCustomerData($colunm,$pkCustomerID) {
    	
		$rows =  $this->where('pkCustomerID','=',$pkCustomerID)->select($colunm)->first();
		return $rows->$colunm;
    }
}
