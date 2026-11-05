<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SolarMitra\Database\factories\ProjectPhaseFactory;
use Carbon\Carbon;

class ProjectPhase extends AppModel
{
    use HasFactory;

    protected $table = 'project_phases';


    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'title',
        'description'
    ];
    
    protected static function newFactory(): ProjectPhaseFactory
    {
        //return ProjectPhaseFactory::new();
    }

    public function getCreatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getUpdatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }
}
