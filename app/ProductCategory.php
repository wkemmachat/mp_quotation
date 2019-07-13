<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $fillable = [ 'remark','productCategoryId','productCategoryName'
                            ,'user_key_in_id'  ];

    // protected $dates = ['input_date'];

    public function user_key_in() {
        return $this->belongsTo(User::class);
    }

    public function products() {
        return $this->hasMany(Product::class,'productCategoryRunning_id');
    }

}
