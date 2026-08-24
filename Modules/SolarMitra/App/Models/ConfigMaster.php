<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SolarMitra\Database\factories\ConfigMasterFactory;
use Carbon\Carbon;

class ConfigMaster extends AppModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'module_code',
        'field_key',
        'display_title',
        'description',
        'industry_code',
        'config_group',
        'value_type',
        'field_type',
        'options_json',
        'field_value',
        'validation_rules_json',
        'is_required',
        'is_readonly',
        'is_hidden',
        'is_multiple',
        'min_value',
        'max_value',
        'step_value',
        'regex_pattern',
        'depends_on_key',
        'depends_on_value',
        'display_order',
        'help_text',
        'is_active',
        'created_at',
        'updated_at',
    ];
    protected $table = 'config_master';
    
    protected static function newFactory(): ConfigMasterFactory
    {
        //return ConfigMasterFactory::new();
    }
    
    public function business_config_master()
    {
        return $this->hasOne(BusinessConfigMaster::class, 'config_master_id');
    }

    public function getCreatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getUpdatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }
}
