<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmotionAll extends Model
{


    protected $fillable =[
        'emotion_id',
        'ayat_id',
        'ad3ya_id',
        'ahadeth_id',
        'azkar_id'
    ];

    public function emotion()
    {
        return $this->belongsTo(Emotion::class);
    }

    public function ayat()
    {
        return $this->belongsTo(Ayat::class);
    }

    public function ad3ya()
    {
        return $this->belongsTo(Ad3ya::class);
    }

    public function ahadeth()
    {
        return $this->belongsTo(Ahadeth::class);
    }

    public function azkar()
    {
        return $this->belongsTo(Azkar::class);
    }
}
