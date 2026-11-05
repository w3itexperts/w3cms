<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SolarMitra\Database\factories\MaterialLibraryFactory;
use Carbon\Carbon;

class MaterialLibrary extends AppModel
{
    use HasFactory;

    protected $table = 'materials_library';
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['title', 'slug', 'material_category_id', 'material_company_id', 'unit_id', 'purchase_price', 'selling_price', 'weight_per_piece', 'panel_wattage', 'gst', 'hsn_sac'];
    
    protected static function newFactory(): MaterialLibraryFactory
    {
        //return MaterialLibraryFactory::new();
    }

    public function material_category()
    {
        return $this->hasOne(MaterialCategory::class, 'id', 'material_category_id');
    }

    public function material_company()
    {
        return $this->hasOne(MaterialCompany::class, 'id', 'material_company_id');
    }

    public function material_unit()
    {
        return $this->hasOne(MaterialUnit::class, 'id', 'unit_id');
    }

    public function getCreatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getUpdatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }
}
