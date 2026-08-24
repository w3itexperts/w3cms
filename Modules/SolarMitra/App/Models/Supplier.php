<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
use Modules\SolarMitra\Database\factories\SupplierFactory;

class Supplier extends AppModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'business_id',
        'contact_id',
        'supplier_category',
        'brand_name',
        'gst_no',
        'pan_no',
        'payment_terms',
        'delivery_time_days',
        'service_area',
        'rating',
        'status',
    ];
    
    protected static function newFactory(): SupplierFactory
    {
        //return SupplierFactory::new();
    }
}
