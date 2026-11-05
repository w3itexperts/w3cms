<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SolarMitra\Database\factories\BankAccountFactory;
use Carbon\Carbon;

class BankAccount extends AppModel
{
    use HasFactory;

    protected $table = 'bank_accounts';
    
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['id','business_id','contact_id','account_holder','account_number','ifsc_code','bank_name','bank_address','iban_number','upi_number','payment_barcode'];
    
    protected static function newFactory(): BankAccountFactory
    {
        //return BankAccountFactory::new();
    }

    public function attachment()
    {
        return $this->hasOne(Attachment::class, 'id','payment_barcode');
    }

    public function business()
    {
        return $this->hasOne(Business::class, 'id','business_id');
    }

    public function contact()
    {
        return $this->hasOne(Contact::class, 'id','contact_id')->withoutGlobalScope('hide_business_contacts');
    }

    public function getCreatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getUpdatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }
}
