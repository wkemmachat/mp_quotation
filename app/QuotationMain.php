<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuotationMain extends Model
{
    protected $fillable = [ 'customer_running_id'
                            ,'PI_number','PI_date','shippingCostInPI','specialDiscount'
                            ,'depositPercentOrValue','depositAmountPercentOrValue','remarkInPI' ];


    public function user_key_in() {
        return $this->belongsTo(User::class);
    }

    public function quotation_details() {
        return $this->hasMany(QuotationDetail::class,'quotation_main_running_id');
    }

    public function customer() {
        return $this->belongsTo(Customer::class,'customer_running_id');
    }
}
