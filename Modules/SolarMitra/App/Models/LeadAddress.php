<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SolarMitra\Database\factories\LeadAddressFactory;

class LeadAddress extends AppModel
{
    use HasFactory;

    protected $table = 'lead_addresses';
    public $timestamps = false;


    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'lead_id',
        'address_id',
    ];
    
    protected static function newFactory(): LeadAddressFactory
    {
        //return LeadAddressFactory::new();
    }
}
