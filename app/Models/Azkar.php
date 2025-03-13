<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Azkar extends Model
{


    protected $fillable =[
        'azkar-ar',
        'azkar-en',
        'status',
    ];

    public function emotion_alls()
    {
        return $this->hasMany(EmotionAll::class);
    }

}
