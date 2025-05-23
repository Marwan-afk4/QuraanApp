<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emotion extends Model
{


    protected $fillable =[
        'emotion_name',
        'emotion_limit',
        'emotion_name_ar'
    ];

    public function emotion_alls()
    {
        return $this->hasMany(EmotionAll::class);
    }
}
