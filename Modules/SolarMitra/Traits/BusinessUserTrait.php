<?php
namespace Modules\SolarMitra\Traits;

use Modules\Business\Models\Business;
use Modules\Business\Models\Contact;

trait BusinessUserTrait
{
    public function businesses()
    {
        return $this->hasMany(Business::class, 'user_id');
    }

    public function contact()
    {
        return $this->hasOne(Contact::class, 'user_id');
    }

    public function hasVerifiedMobile(): bool
    {
        return (bool) $this->is_mobile_verified;
    }
}
