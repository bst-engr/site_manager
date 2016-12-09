<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Validator;

class Product extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ "productId",
                            "productName",
                            "productCode",
                            "releaseDate",
                            "description",
                            "price",
                            "starRating",
                            "imageUrl"
                        ];
    /**
     * [$primaryKey description]
     * @var string
     */
    protected $primaryKey = 'productId';

    public $errors;
    
    public static $rules = array(
                                    "productName" => 'required',
                                    "productCode" => 'required',
                                    "releaseDate" => 'required',
                                    "description" => 'required',
                                    "price" => 'required',
                                    "imageUrl" => 'required'
                            );
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public function getProducts() {
        return $this->get();
    }

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

    public function updateProduct($formData) {
        return $this->where('productId', '=', $formData['productId'])
                    ->update(
                        array(
                            "productName" => $formData['productName'],
                            "productCode" => $formData['productCode'],
                            "releaseDate" => $formData['releaseDate'],
                            "description" => $formData['description'],
                            "price" => $formData['price'],
                            "imageUrl" => $formData['imageUrl']
                        )
                    );
    }

    public function getProductDetails( $id ) {
        return $this->where('productId', '=', $id)->first();
    }
}
