<?php

namespace Modules\SolarMitra\App\Models;

use App\Models\User;
use Modules\SolarMitra\App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SolarMitra\Database\factories\BusinessFactory;
use Modules\SolarMitra\App\Models\Address;
use Modules\SolarMitra\Traits\HasUniqueUuid;
use Carbon\Carbon;

class Business extends AppModel
{
    use HasFactory,HasUniqueUuid;

    protected $table = 'businesses';
    protected $uuidColumn = 'business_uuid';
    
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['business_uuid','user_id','company_name','contact_person','about','phone','gst_no','pan_no','logo'];
    
    protected static function newFactory(): BusinessFactory
    {
        //return BusinessFactory::new();
    }


    /* ----- Relations ----- */

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function contact()
    {
        return $this->hasOne(Contact::class, 'business_id', 'id')->where('type',1)->withoutGlobalScope('hide_business_contacts');
    }
    public function addresses()
    {
        return $this->hasMany(Address::class, 'business_id', 'id')->where('contact_id', 0)->where('project_id', 0)->whereNot('business_id', 0);
    }

    public function bank_accounts()
    {
        return $this->hasMany(BankAccount::class, 'business_id')->where('contact_id', 0)->whereNot('business_id', 0);
    }

    public function getCreatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getUpdatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

}
