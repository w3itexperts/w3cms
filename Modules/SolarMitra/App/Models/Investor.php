<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
use Modules\SolarMitra\Database\factories\InvestorFactory;

class Investor extends AppModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'business_id',
        'contact_id',
        'investment_type',
        'investment_amount',
        'equity_percent',
        'investment_date',
        'expected_roi',
        'payout_frequency',
        'contract_document',
        'status',
    ];
    
    protected static function newFactory(): InvestorFactory
    {
        //return InvestorFactory::new();
    }

    public function setInvestmentDateAttribute( $value ) {
        $this->attributes['investment_date'] = Carbon::createFromFormat(config('solarmitra.date_time_format'),$value)->format('Y-m-d H:i:s');
    }

    public function getInvestmentDateAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }
}
