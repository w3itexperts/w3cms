<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
use Modules\SolarMitra\Database\factories\PartnerFactory;

class Partner extends AppModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'business_id',
        'contact_id',
        'partner_type',
        'commission_percent',
        'partnership_start_date',
        'partnership_end_date',
        'region',
        'sales_target',
        'status',
    ];
    
    protected static function newFactory(): PartnerFactory
    {
        //return PartnerFactory::new();
    }

    public function setPartnershipStartDateAttribute( $value ) {
        $this->attributes['partnership_start_date'] = Carbon::createFromFormat(config('solarmitra.date_time_format'),$value)->format('Y-m-d H:i:s');
    }

    public function getPartnershipStartDateAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function setPartnershipEndDateAttribute( $value ) {
        $this->attributes['partnership_end_date'] = Carbon::createFromFormat(config('solarmitra.date_time_format'),$value)->format('Y-m-d H:i:s');
    }

    public function getPartnershipEndDateAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }
}
