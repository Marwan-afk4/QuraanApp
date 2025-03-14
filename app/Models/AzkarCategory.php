<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AzkarCategory extends Model
{


    protected $fillable = [
        'category_name',
    ];

    public function azkars()
    {
        return $this->hasMany(Azkar::class);
    }
}
