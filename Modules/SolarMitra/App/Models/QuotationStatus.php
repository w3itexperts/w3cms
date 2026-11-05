<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SolarMitra\Database\factories\QuotationStatusFactory;
use Modules\SolarMitra\Helper\SolarMitraHelper;
use Carbon\Carbon;

class QuotationStatus extends AppModel
{
    use HasFactory;

    protected $table = 'quotation_statuses';
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'slug',
        'title',
        'order_no',
        'is_public',
        'can_edit',
        'can_convert',
        'is_final',
    ];
    
    protected static function newFactory(): QuotationStatusFactory
    {
        //return QuotationStatusFactory::new();
    }

    public function getCreatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getUpdatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }
}
