<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SolarMitra\Database\factories\SourceFactory;
use Carbon\Carbon;

class Source extends AppModel
{
    use HasFactory;

    protected $table = 'sources';


    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'name',
        'slug',
        'type',
        'channel_id',
        'is_active',
        'business_id',
    ];
    
    protected static function newFactory(): SourceFactory
    {
        //return SourceFactory::new();
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class, 'channel_id');
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
