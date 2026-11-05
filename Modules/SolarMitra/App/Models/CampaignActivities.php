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

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    public function leads()
    {
        return $this->hasMany(CampaignLead::class, 'campaign_activity_id');
    }

    public function syncLeadCount(): int
    {
        $count = $this->leads()->count();
        $this->update(['lead_count' => $count]);
        return $count;
    }

    public function getCplAttribute(): ?float
    {
        return $this->lead_count > 0 && $this->cost > 0
            ? round($this->cost / $this->lead_count, 2)
            : null;
    }

    public function getCtrAttribute(): ?float
    {
        return $this->impression > 0 && $this->clicks > 0
            ? round(($this->clicks / $this->impression) * 100, 2)
            : null;
    }

    public function getCpcAttribute(): ?float
    {
        return $this->clicks > 0 && $this->cost > 0
            ? round($this->cost / $this->clicks, 2)
            : null;
    }

    public function getCreatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getUpdatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }
}
