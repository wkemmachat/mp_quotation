<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuotationDetail extends Model
{
    protected $fillable = [ 'product_running_id','amount','remarkByProduct'
                            ,'discountPercentByProduct','quotation_main_running_id'];

    public function product() {
        return $this->belongsTo(Product::class,'product_running_id');
    }

    public function quotation_main() {
        return $this->belongsTo(QuotationMain::class,'quotation_main_running_id');
    }

}
