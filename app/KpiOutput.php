<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KpiOutput extends Model
{
    protected $fillable = [ 'input_date','remark','user_id','user_key_in_id'
                            ,'role_id','total_amount','total_defect'  ];


    protected $dates = ['input_date'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function user_key_in() {
        return $this->belongsTo(User::class);
    }

    public function role() {
        return $this->belongsTo(Role::class);
    }
}
