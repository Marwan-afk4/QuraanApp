<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Azkar extends Model
{


    protected $fillable =[
        'azkar_ar',
        'azkar_en',
        'status',
        'note'
    ];

    public function emotion_alls()
    {
        return $this->hasMany(EmotionAll::class);
    }

}
