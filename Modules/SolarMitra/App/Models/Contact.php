<?php

namespace Modules\SolarMitra\App\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\SolarMitra\App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SolarMitra\Database\factories\ContactFactory;
use App\Models\User;
use Carbon\Carbon;

class Contact extends AppModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'business_id',
        'name',
        'company_name',
        'phone_number',
        'type',
        'email',
        'aadhar_no',
        'pan_no',
        'gst_no',
        'zip',
    ];

    /* 
    * To hide Business Contact from Listing.
    * To get Business Contacts also in listing use:
    * Contact::withoutGlobalScope('hide_business_contacts')->get();
    *
    */
    protected static function booted()
    {
        static::addGlobalScope('hide_business_contacts', function (Builder $builder) {
            $builder->where('type', '!=', 1);
        });
    }
    
    protected static function newFactory(): ContactFactory
    {
        //return ContactFactory::new();
    }

    public function client()
    {
        return $this->hasOne(Client::class, 'contact_id', 'id');
    }

    public function supplier()
    {
        return $this->hasOne(Supplier::class, 'contact_id', 'id');
    }

    public function investor()
    {
        return $this->hasOne(Investor::class, 'contact_id', 'id');
    }

    public function contractor()
    {
        return $this->hasOne(Contractor::class, 'contact_id', 'id');
    }

    public function partner()
    {
        return $this->hasOne(Partner::class, 'contact_id', 'id');
    }

    public function staff()
    {
        return $this->hasOne(Staff::class, 'contact_id', 'id');
    }

    public function bank_account()
    {
        return $this->hasOne(BankAccount::class, 'contact_id', 'id');
    }

    public function address()
    {
        return $this->hasOne(Address::class, 'contact_id', 'id');
    }

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id', 'id');
    }


    // Imp : Currently We are not Add user with Contact Adjust in Future
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function transactions_sender()
    {
        return $this->hasMany(Transaction::class, 'sender_party_id', 'id');
    }

    public function transactions_reciever()
    {
        return $this->hasMany(Transaction::class, 'reciever_party_id', 'id');
    }

    public function getCreatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getUpdatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }
}
