<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{


    protected $fillable =[
        'user_id',
        'amount',
        'plan_name',
        'status',
        'end_date'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
