<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ad3ya extends Model
{


    protected $fillable =[
        'ad3ya-ar',
        'ad3ya-en',
        'status',
        'note'
    ];

    public function emotion_alls()
    {
        return $this->hasMany(EmotionAll::class);
    }
}
