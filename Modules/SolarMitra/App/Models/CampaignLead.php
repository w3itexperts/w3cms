<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Modules\SolarMitra\Database\factories\CampaignLeadFactory;
use Carbon\Carbon;

class CampaignLead extends AppModel
{

    protected $table = 'campaign_leads';


    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'lead_id',
        'compaign_activity_id',
        'campaign_id',
        'source_id',
        'assigned_user_id',
        'is_primary',
        'created_by',
    ];
    
    protected static function newFactory(): CampaignLeadFactory
    {
        //return CampaignLeadFactory::new();
    }

    public function getCreatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getUpdatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }
}
