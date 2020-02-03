<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    protected $fillable = [ 'customerName','customerAddress1','customerAddress2'
    ,'customerAddress3','customerContactPerson','customerTaxId','customerTel','customerMail','user_key_in_id','remark' ];

    public function user_key_in() {
        return $this->belongsTo(User::class);
    }

    public function quotations() {
        return $this->hasMany(Quotation::class,'customer_running_id');
    }
}
