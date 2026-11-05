<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SolarMitra\Database\factories\AppFeedbackFactory;
use App\Models\User;
use Carbon\Carbon;

class AppFeedback extends AppModel
{
    use HasFactory;

    protected $table = 'app_feedbacks';


    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'business_id',
        'user_id',
        'feedback_type',
        'subject',
        'description',
        'attachment',
        'priority',
        'status',
        'module_name',
        'page_url',
        'browser',
        'operating_system',
        'app_version',
        'ip_address',
        'admin_remark',
    ];
    
    protected static function newFactory(): AppFeedbackFactory
    {
        //return AppFeedbackFactory::new();
    }

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getCreatedAtAttribute($value)
    {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getUpdatedAtAttribute($value)
    {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

}
