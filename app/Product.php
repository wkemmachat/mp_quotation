<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [ 'remark','productId','productName'
                            ,'user_key_in_id','productCategoryRunning_id','active','min','imageName','desc1','desc2','desc3','desc4','desc5','desc6','std_price'  ];

    // protected $dates = ['input_date'];

    public function user_key_in() {
        return $this->belongsTo(User::class);
    }

    public function stock_real_time()
    {
        return $this->hasOne(StockRealTime::class,'product_running_id','id');
    }
    public function product_category() {
        return $this->belongsTo(ProductCategory::class,'productCategoryRunning_id');
    }
}
