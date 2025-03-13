<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ayat extends Model
{


    protected $fillable =[
        'ayat-ar',
        'ayat-en',
        'status',
    ];

    public function emotion_alls()
    {
        return $this->hasMany(EmotionAll::class);
    }
}
