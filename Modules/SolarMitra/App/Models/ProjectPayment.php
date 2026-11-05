<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SolarMitra\Database\factories\ProjectFactory;
use Carbon\Carbon;

class ProjectPayment extends AppModel
{
    use HasFactory;

    protected $table = 'project_payments';
    
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['project_id','status','remark','amount',];
    
    protected static function newFactory(): ProjectPaymentFactory
    {
        //return ProjectPaymentFactory::new();
    }

    public function getCreatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getUpdatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }
}
