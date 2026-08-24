<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Modules\SolarMitra\Database\factories\CampaignTagFactory;

class CampaignTag extends AppModel
{

    protected $table = 'campaign_tags';


    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'compaign_id',
        'tag_id',
    ];
    
    protected static function newFactory(): CampaignTagFactory
    {
        //return CampaignTagFactory::new();
    }
}
