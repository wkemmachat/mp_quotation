<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockRealTime extends Model
{
    protected $fillable = [ 'product_running_id','amount','transfer_in_out_id' ];

    public function product() {
        return $this->belongsTo(Product::class,'product_running_id');
    }
    public function transfer_in_out() {
        return $this->belongsTo(TransferInOut::class,'transfer_in_out_id');
    }

}
