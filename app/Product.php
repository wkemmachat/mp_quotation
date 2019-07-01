<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [ 'remark','productId','productName'
                            ,'user_key_in_id'  ];

    // protected $dates = ['input_date'];

    public function user_key_in() {
        return $this->belongsTo(User::class);
    }
}
