<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SolarMitra\Database\factories\StateFactory;

class State extends AppModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['title', 'slug', 'country_id', 'is_active'];
    
    protected static function newFactory(): StateFactory
    {
        //return StateFactory::new();
    }
}
