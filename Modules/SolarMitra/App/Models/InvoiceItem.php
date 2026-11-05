<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SolarMitra\Database\factories\InvoiceItemFactory;
use Carbon\Carbon;

class InvoiceItem extends AppModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'invoice_id',
        'item_id',
        'material_company_id',
        'material_category_id',
        'item_title',
        'item_unit',
        'item_quantity',
        'rates_per_units',
        'gst',
        'discount',
        'amount',
        'description',
    ];
    
    protected static function newFactory(): InvoiceItemFactory
    {
        //return InvoiceItemFactory::new();
    }
    public function material_item()
    {
        return $this->belongsTo(MaterialLibrary::class, 'item_id');
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function getCreatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getUpdatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }
}
