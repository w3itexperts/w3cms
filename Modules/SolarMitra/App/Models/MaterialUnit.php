<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SolarMitra\Database\factories\MaterialUnitFactory;
use Carbon\Carbon;

class MaterialUnit extends AppModel
{
    use HasFactory;

    protected $table = 'material_units';
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['title'];
    
    protected static function newFactory(): MaterialUnitFactory
    {
        //return MaterialUnitFactory::new();
    }

    public function getCreatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getUpdatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }
}
