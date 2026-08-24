<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Modules\SolarMitra\Database\factories\ChannelFactory;
use Carbon\Carbon;

class Channel extends AppModel
{

    protected $table = 'channels';


    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'title',
        'slug',
        'description',
        'is_active',
        'business_id',
    ];
    
    protected static function newFactory(): ChannelFactory
    {
        //return ChannelFactory::new();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    // Global channels (NULL or 0 business_id) that are active
    public function scopeGlobal($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('business_id')
              ->orWhere('business_id', 0);
        })->active();
    }

    // Channels visible to a business
    public function scopeVisibleToBusiness($query, $businessId = null)
    {
        $businessId ??= app('currentBusinessId');

        return $query->where(function ($q) use ($businessId) {
            $q->where('business_id', $businessId)
              ->orWhere(function ($sub) {
                  $sub->global();
              });
        });
    }

    public function getCreatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getUpdatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }
}
