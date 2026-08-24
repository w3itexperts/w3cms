<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SolarMitra\Database\factories\QuotationFactory;
use Carbon\Carbon;
use App\Models\User;

class Quotation extends AppModel
{
    use HasFactory;

    protected $table = 'quotations';
    protected $appends = ['status_name'];
    public $statusStr  = null;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'business_id',
        'project_id',
        'quotation_number',
        'title',
        'client_id',
        'date',
        'sub_total',
        'tax',
        'created_by',
        'aditional_charges',
        'discount',
        'total_amount',
        'valid_till_date',
        'quotation_status_id',
        'description',
        'invoice_generated',
    ];


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->statusStr = config('solarmitra.quotations_status')[$this->quotation_status_id] ?? 'Unknown';
    }

    
    protected static function newFactory(): QuotationFactory
    {
        //return QuotationFactory::new();
    }

    public function project() 
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function client() 
    {
        return $this->belongsTo(Contact::class, 'client_id');
    }

    public function creator() 
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function items() 
    {
        return $this->hasMany(QuotationItem::class, 'quotation_id', 'id');
    }

    public function status() 
    {
        return $this->hasOne(QuotationStatus::class,'id', 'quotation_status_id');
    }

    public function getStatusNameAttribute()
    {
        return config('solarmitra.projects_status')[$this->quotation_status_id] ?? 'Unknown';
    }


    public function setDateAttribute( $value ) {
        $this->attributes['date'] = Carbon::createFromFormat(config('solarmitra.date_time_format'),$value)->format('Y-m-d H:i:s');
    }

    public function getDateAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function setValidTillDateAttribute( $value ) {
        $this->attributes['valid_till_date'] = Carbon::createFromFormat(config('solarmitra.date_time_format'),$value)->format('Y-m-d H:i:s');
    }

    public function getValidTillDateAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getCreatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getUpdatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }


}
