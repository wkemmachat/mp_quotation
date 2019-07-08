<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransferInOut extends Model
{
    protected $fillable = [ 'remark','product_running_id','amount'
                            ,'user_key_in_id','document_reference_id','in_or_out'  ];

    protected $dates = ['input_date'];

    public function user_key_in() {
        return $this->belongsTo(User::class);
    }

    public function product_running() {
        return $this->belongsTo(Product::class);
    }
}
