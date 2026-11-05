<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SolarMitra\Database\factories\InvoiceFactory;
use Carbon\Carbon;

class Invoice extends AppModel
{
    use HasFactory;

    protected $table = 'invoices';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'client_id',
        'quotation_id',
        'project_id',
        'business_id',
        'invoice_number',
        'title',
        'paid_amount',
        'due_amount',
        'date',
        'sub_total',
        'tax',
        'aditional_charges',
        'discount',
        'total_amount',
        'due_date',
        'status',
        'description',
    ];

    public function items() 
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id', 'id');
    }
    public function client() 
    {
        return $this->belongsTo(Contact::class, 'client_id');
    }

    public function quotation() 
    {
        return $this->belongsTo(Quotation::class, 'quotation_id');
    }

    public function project() 
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function getDateAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function setDateAttribute( $value ) {
        $this->attributes['date'] = Carbon::createFromFormat(config('solarmitra.date_time_format'),$value)->format('Y-m-d H:i:s');
    }

    public function getDueDateAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }
    
    public function setDueDateAttribute( $value ) {
        $this->attributes['due_date'] = Carbon::createFromFormat(config('solarmitra.date_time_format'),$value)->format('Y-m-d H:i:s');
    }

    public function getCreatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getUpdatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }
}
