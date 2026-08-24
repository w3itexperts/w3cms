<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SolarMitra\Database\factories\SolarProjectPhaseFactory;
use Modules\SolarMitra\Helper\SolarMitraHelper;
use Carbon\Carbon;

class SolarProjectPhase extends AppModel
{
    use HasFactory;

    protected $table = 'solar_project_phases';
    public $timestamps = false;


    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'project_id',
        'project_phase_id'
    ];
    
    protected static function newFactory(): SolarProjectPhaseFactory
    {
        //return SolarProjectPhaseFactory::new();
    }

    public function getCreatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getUpdatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }
}
