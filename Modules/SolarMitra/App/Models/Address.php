<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SolarMitra\Database\factories\AddressFactory;
use Modules\SolarMitra\App\Models\City;
use Modules\SolarMitra\App\Models\State;
use Modules\SolarMitra\App\Models\Country;
use Carbon\Carbon;

class Address extends AppModel
{
    use HasFactory;

    protected $table = 'addresses';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'business_id',
        'contact_id',
        'project_id',
        'address_title',
        'address',
        'city_id',
        'state_id',
        'country_id',
        'address_type',
        'is_primary',
    ];
    
    protected static function newFactory(): AddressFactory
    {
        //return AddressFactory::new();
    }

    public function city()
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }

    public function state()
    {
        return $this->hasOne(State::class, 'id', 'state_id');
    }

    public function country()
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }

    public function business()
    {
        return $this->hasOne(Business::class, 'id','business_id');
    }

    public function contact()
    {
        return $this->hasOne(Contact::class, 'id','contact_id')->withoutGlobalScope('hide_business_contacts');
    }

    public function getCreatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getUpdatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }
}
