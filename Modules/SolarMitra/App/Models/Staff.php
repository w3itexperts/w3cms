<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
use Modules\SolarMitra\Database\factories\StaffFactory;

class Staff extends AppModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'business_id',
        'contact_id',
        'employee_code',
        'department',
        'designation',
        'joining_date',
        'employment_type',
        'salary_type',
        'salary_amount',
        'reporting_manager_id',
        'work_location',
        'status',
        'work_responsibilities',
        'special_note',
    ];
    
    protected static function newFactory(): StaffFactory
    {
        //return StaffFactory::new();
    }

    public function setJoiningDateAttribute( $value ) {
        $this->attributes['joining_date'] = Carbon::createFromFormat(config('solarmitra.date_time_format'),$value)->format('Y-m-d H:i:s');
    }

    public function getJoiningDateAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }
}
