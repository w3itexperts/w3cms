<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SolarMitra\Database\factories\LeadFollowUpFactory;
use Carbon\Carbon;

class LeadFollowUp extends AppModel
{
    use HasFactory;

    protected $table = 'lead_followups';
    protected $casts  = ['date_time' => 'datetime'];


    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'lead_id',
        'date_time',
        'assigned_to',
        'repeat_followup',
        'note',
        'is_active',
        'created_by',
    ];
    
    protected static function newFactory(): LeadFollowUpFactory
    {
        //return LeadFollowUpFactory::new();
    }

    public function assigned_user() 
    {
        return $this->hasOne(Contact::class, 'id','assigned_to');
    }

    public function lead() 
    {
        return $this->hasOne(Lead::class, 'id','lead_id');
    }

    public function followup_logs() 
    {
        return $this->hasMany(LeadFollowUpLog::class, 'followup_id','id');
    }

    public function setDateTimeAttribute( $value ) {
        if ($value) {
            $this->attributes['date_time'] = Carbon::createFromFormat(config('solarmitra.date_time_format'),$value)->format('Y-m-d H:i:s');
        }else{
            $this->attributes['date_time'] = null;
        }
    }

    public function getDateTimeAttribute( $value ) {
        if (!$value) return null;
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getCreatedAtAttribute( $value ) {
        if (!$value) return null;
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getUpdatedAtAttribute( $value ) {
        if (!$value) return null;
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }
}
