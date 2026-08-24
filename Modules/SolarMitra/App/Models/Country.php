<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SolarMitra\Database\factories\CountryFactory;

class Country extends AppModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['title', 'slug', 'code', 'is_active'];
    
    protected static function newFactory(): CountryFactory
    {
        //return CountryFactory::new();
    }
}
