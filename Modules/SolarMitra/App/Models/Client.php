<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
use Modules\SolarMitra\Database\factories\ClientFactory;

class Client extends AppModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'business_id',
        'contact_id',
        'client_code',
        'client_type',
        'customer_since',
        'account_manager_id',
        'credit_limit',
        'payment_terms',
        'preferred_contact_method',
        'priority_level',
        'status',
        'notes',
    ];
    
    protected static function newFactory(): ClientFactory
    {
        //return ClientFactory::new();
    }

    public function setCustomerSinceAttribute( $value ) {
        $this->attributes['customer_since'] = Carbon::createFromFormat(config('solarmitra.date_time_format'),$value)->format('Y-m-d H:i:s');
    }

    public function getCustomerSinceAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }
}
