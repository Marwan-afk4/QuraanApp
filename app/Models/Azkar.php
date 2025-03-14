<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Azkar extends Model
{


    protected $fillable =[
        'azkar_ar',
        'azkar_en',
        'status',
        'note',
        'azkar_count',
        'category_id'
    ];

    public function emotion_alls()
    {
        return $this->hasMany(EmotionAll::class);
    }

    public function azkar_category()
    {
        return $this->belongsTo(AzkarCategory::class,'category_id');
    }

}
