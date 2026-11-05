<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SolarMitra\Database\factories\LeadFactory;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Lead extends AppModel
{
    use HasFactory,SoftDeletes;

    protected $table = 'leads';
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'business_id' ,
        'lead_added_by_id',
        'abbreviation',
        'first_name',
        'last_name',
        'email',
        'phone',
        'client_group_id',
        'lead_source_id',
        'email_opt_out',
        'lead_stage_id',
        'potential',
        'do_not_followup',
    ];
    
    protected static function newFactory(): LeadFactory
    {
        //return LeadFactory::new(); 
    }

    public function added_by_user() 
    {
        return $this->hasOne(User::class, 'id', 'lead_added_by_id');
    }

    public function client_group() 
    {
        return $this->hasOne(ClientGroup::class, 'id', 'client_group_id');
    }

    public function source() 
    {
        return $this->belongsTo(Source::class, 'lead_source_id');
    }

    public function lead_stage() 
    {
        return $this->hasOne(LeadStage::class, 'id', 'lead_stage_id');
    }

    public function lead_tags()
    {
        return $this->belongsToMany(Tag::class, 'lead_tags', 'lead_id', 'tag_id');
    }

    public function follow_ups() 
    {
        return $this->hasMany(LeadFollowUp::class, 'lead_id', 'id');
    }

    public function last_follow_up() 
    {
        return $this->hasOne(LeadFollowUp::class, 'lead_id')->latestOfMany('date_time');
    }

    public function last_followup_log()
    {
        return $this->hasOne(LeadFollowUpLog::class, 'lead_id')
            ->latest('id');
    }

    public function address()
    {
        return $this->hasOneThrough(
            Address::class,        // Final model
            LeadAddress::class,    // Intermediate model
            'lead_id',             // FK on lead_addresses ? leads
            'id',                  // FK on addresses
            'id',                  // PK on leads
            'address_id'           // FK on lead_addresses ? addresses
        );
    }

    public function getFullNameAttribute()
    {
        return trim($this->abbreviation . ' '.$this->first_name . ' ' . $this->last_name);
    }

    public function getDeletedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getCreatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getUpdatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

}
