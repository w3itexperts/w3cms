<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SolarMitra\Database\factories\LeadAttributionFactory;
use Carbon\Carbon;

class LeadAttribution extends AppModel
{
    use HasFactory;

    protected $table = 'lead_attributions';


    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'lead_id',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_content',
        'utm_term',
        'referrer_url',
        'landing_page',
        'user_agent',
        'ip_address',
        'captured_at',
    ];
    
    protected static function newFactory(): LeadAttributionFactory
    {
        //return LeadAttributionFactory::new();
    }

    public function getCapturedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getCreatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getUpdatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }
}
