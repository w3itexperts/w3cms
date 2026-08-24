<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SolarMitra\Database\factories\CampaignAssignmentFactory;
use Carbon\Carbon;

class CampaignAssignment extends AppModel
{
    use HasFactory;

    protected $table = 'campaign_assignments';


    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'campaign_id',
        'user_id',
    ];
    
    protected static function newFactory(): CampaignAssignmentFactory
    {
        //return CampaignAssignmentFactory::new();
    }

    public function getCreatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getUpdatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }
}
