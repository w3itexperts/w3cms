<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SolarMitra\Database\factories\BusinessConfigMasterFactory;
use Carbon\Carbon;

class BusinessConfigMaster extends AppModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'config_master_id',
        'business_id',
        'display_title',
        'field_key',
        'field_value',
    ];
    
    protected $table = 'business_config_master';
    
    protected static function newFactory(): BusinessConfigMasterFactory
    {
        //return BusinessConfigMasterFactory::new();
    }
    
    public function config_master()
    {
        return $this->hasOne(ConfigMaster::class, 'id', 'config_master_id');
    }
    

    public function getCreatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getUpdatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }
}
