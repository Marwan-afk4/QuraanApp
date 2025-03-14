<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ahadeth extends Model
{


    protected $fillable =[
        'ahadeth-ar',
        'ahadeth-en',
        'status',
        'note'
    ];

    public function emotion_alls()
    {
        return $this->hasMany(EmotionAll::class);
    }
}
