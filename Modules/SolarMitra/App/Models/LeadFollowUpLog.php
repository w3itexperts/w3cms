<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SolarMitra\Database\factories\LeadFollowUpLogFactory;
use Carbon\Carbon;

class LeadFollowUpLog extends AppModel
{
    use HasFactory;

    protected $table = 'lead_followup_logs';
    protected $casts  = ['scheduled_at' => 'datetime','completed_at' => 'datetime'];


    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'lead_id',
        'followup_id',
        'scheduled_at',
        'completed_at',
        'status',
        'remarks',
    ];
    
    protected static function newFactory(): LeadFollowUpLogFactory
    {
        //return LeadFollowUpLogFactory::new();
    }

    public function getScheduledAtAttribute( $value ) {
        if (!$value) return null;
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function setScheduledAtAttribute( $value ) {
        if ($value) {
            $this->attributes['scheduled_at'] = Carbon::createFromFormat(config('solarmitra.date_time_format'),$value)->format('Y-m-d H:i:s');
        }else{
            $this->attributes['scheduled_at'] = null;
        }
    }

    public function getCompletedAtAttribute( $value ) {
        if (!$value) return null;
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function setCompletedAtAttribute( $value ) {
        if ($value) {
            $this->attributes['completed_at'] = Carbon::createFromFormat(config('solarmitra.date_time_format'),$value)->format('Y-m-d H:i:s');
        }else{
            $this->attributes['completed_at'] = null;
        }

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
