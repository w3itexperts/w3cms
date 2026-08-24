<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SolarMitra\Database\factories\CampaignActivitiesFactory;
use Carbon\Carbon;

class CampaignActivities extends AppModel
{
    use HasFactory;

    protected $table = 'campaign_activities';


    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'campaign_id',
        'channel_id',
        'source_id',
        'name',
        'external_ref',
        'cost',
        'lead_count',
        'impression',
        'clicks',
    ];
    
    protected static function newFactory(): CampaignActivitiesFactory
    {
        //return CampaignActivitiesFactory::new();
    }

    public function getCreatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getUpdatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }
}
