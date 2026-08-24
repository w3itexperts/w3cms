<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SolarMitra\Database\factories\LeadStageFactory;
use Carbon\Carbon;

class LeadStage extends AppModel
{
    use HasFactory;

    protected $table = 'lead_stages';


    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'name',
        'slug',
        'order',
        'color',
        'is_final',
        'is_success',
    ];
    
    protected static function newFactory(): LeadStageFactory
    {
        //return LeadStageFactory::new();
    }

    public function getCreatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getUpdatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }
}
