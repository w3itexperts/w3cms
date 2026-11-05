<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SolarMitra\Database\factories\ClientGroupFactory;
use Carbon\Carbon;

class ClientGroup extends AppModel
{
    use HasFactory;

    protected $table = 'client_groups';


    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'title',
        'business_id',
    ];
    
    protected static function newFactory(): ClientGroupFactory
    {
        //return ClientGroupFactory::new();
    }

    public function getCreatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getUpdatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }
}
