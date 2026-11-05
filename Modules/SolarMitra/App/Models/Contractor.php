<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
use Modules\SolarMitra\Database\factories\ContractorFactory;

class Contractor extends AppModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'business_id',
        'contact_id',
        'contractor_type',
        'team_size',
        'skill_category',
        'labor_rate_per_kw',
        'service_area',
        'experience_years',
        'license_no',
        'availability_status',
        'rating',
    ];
    
    protected static function newFactory(): ContractorFactory
    {
        //return ContractorFactory::new();
    }
}
