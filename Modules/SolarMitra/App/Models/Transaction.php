<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SolarMitra\Database\factories\TransactionFactory;
use Carbon\Carbon;

class Transaction extends AppModel
{
    use HasFactory;

    protected $table = 'transactions';
    protected $casts  = ['date' => 'datetime'];
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
            'business_id',
            'project_id',
            'transaction_type_id',
            'sender_party_id',
            'reciever_party_id',
            'transaction_number',
            'amount',
            'description',
            'date',
            'transfer_mode',
            'transfer_type',
            'payment_for',
            'reference_id',
            'reference_type',
        ];
    
    protected static function newFactory(): TransactionFactory
    {
        //return TransactionFactory::new();
    }

    public function transaction_type() 
    {
        return $this->hasOne(TransactionType::class, 'id', 'transaction_type_id');
    }

    public function sender() 
    {
        return $this->hasOne(Contact::class, 'id', 'sender_party_id')->withoutGlobalScope('hide_business_contacts');
    }

    public function receiver() 
    {
        return $this->hasOne(Contact::class, 'id', 'reciever_party_id')->withoutGlobalScope('hide_business_contacts');
    }

    public function attachments()
    {
        return $this->belongsToMany(Attachment::class, 'transactions_attachments', 'transaction_id', 'attachment_id');
    }

    public function getDateAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function setDateAttribute( $value ) {
        $this->attributes['date'] = Carbon::createFromFormat(config('solarmitra.date_time_format'),$value)->format('Y-m-d H:i:s');
    }

    public function getCreatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getUpdatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

}
