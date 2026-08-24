<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SolarMitra\Database\factories\MaterialCompanyFactory;
use Carbon\Carbon;

class MaterialCompany extends AppModel
{
    use HasFactory;

    protected $table = 'material_companies';
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',         
        'description',
    ];

    public function categories()
    {
        return $this->belongsToMany(
            MaterialCategory::class,
            'material_companies_material_categories',
            'material_company_id',
            'material_category_id'
        );
    }

    public function material_items()
    {
        return $this->hasMany(MaterialLibrary::class, 'material_company_id');
    }
    
    protected static function newFactory(): MaterialCompanyFactory
    {
        //return MaterialCompanyFactory::new();
    }

    public function getCreatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getUpdatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }
}
