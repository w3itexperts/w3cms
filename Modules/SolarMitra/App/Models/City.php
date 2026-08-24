<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Modules\SolarMitra\Database\factories\CityFactory;

class City extends AppModel
{

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['title', 'slug', 'state_id', 'country_id', 'is_active'];
    
    protected static function newFactory(): CityFactory
    {
        //return CityFactory::new();
    }
}
