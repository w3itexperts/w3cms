<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SolarMitra\Database\factories\CampaignFactory;
use Carbon\Carbon;

class Campaign extends AppModel
{
    use HasFactory;

    protected $table = 'campaigns';
    protected $casts  = ['start_at' => 'datetime','end_at' => 'datetime'];


    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'business_id',
        'purpose',
        'channel_id',
        'source_id',
        'start_at',
        'end_at',
        'status',
        'created_by',
    ];
    
    protected static function newFactory(): CampaignFactory
    {
        //return CampaignFactory::new();
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class, 'channel_id');
    }

    public function source()
    {
        return $this->belongsTo(Source::class, 'source_id');
    }

    public function activities()
    {
        return $this->hasMany(CampaignActivities::class);
    }

    public function assignments()
    {
        return $this->hasMany(CampaignAssignment::class);
    }

    public function leads()
    {
        return $this->hasMany(CampaignLead::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'campaign_tags', 'campaign_id', 'tag_id');
    }

    public function campaignTags()
    {
        return $this->hasMany(CampaignTag::class, 'campaign_id');
    }

    public function getActivitiesCountAttribute(): int
    {
        return $this->activities()->count();
    }

    public function getLeadsCountAttribute(): int
    {
        return $this->leads()->count();
    }

    public function getTotalCostAttribute(): float
    {
        return $this->activities()->sum('cost');
    }

    public function getStartAtAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getEndAtAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getCreatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getUpdatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getTotalLeadsAttribute(): int
    {
        return $this->leads()->count();
    }

    public function getAvgCplAttribute(): ?float
    {
        $totalCost = $this->activities()->sum('cost');
        $totalLeads = $this->leads()->count();
        return $totalLeads > 0 ? round($totalCost / $totalLeads, 2) : null;
    }

    public function getAssignmentsCountAttribute(): int
    {
        return $this->assignments()->count();
    }

    public function getTagsCountAttribute(): int
    {
        return $this->tags()->count();
    }
}
