<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Modules\SolarMitra\Database\factories\ProjectFactory;
use Carbon\Carbon;

class Project extends AppModel
{

    protected $casts  = ['start_date' => 'datetime','end_date' => 'datetime'];
    protected $table = 'projects';
    
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'business_id',
        'client_id',
        'start_date',
        'end_date',
        'capacity',
        'capacity_unit',
        'capacity_int',
        'is_solar_kit_project',
        'project_type',
        'kit',
        'location',
        'change_note',
        'status',
    ];
    
    protected static function newFactory(): ProjectFactory
    {
        //return ProjectFactory::new();
    }


    public function addresses()
    {
        return $this->hasMany(Address::class, 'project_id', 'id')->where('contact_id', 0)->where('business_id', 0)->whereNot('project_id', 0);
    }

    public function project_payments()
    {
        return $this->hasMany(ProjectPayment::class, 'project_id');
    }

    public function project_documents()
    {
        return $this->hasOne(ProjectDocument::class, 'project_id');
    }

    public function project_dates()
    {
        return $this->hasOne(ProjectDate::class, 'project_id');
    }

    public function client_feedback()
    {
        return $this->hasOne(ClientFeedback::class, 'project_id');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'project_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'project_id', 'id');
    }

    public function project_attachments()
    {
        return $this->hasMany(ProjectAttachment::class, 'project_id');
    }

    public function quotation()
    {
        return $this->hasOne(Quotation::class, 'project_id');
    }

    public function project_assign()
    { 
        return $this->hasOne( ProjectAssign::class, 'project_id' );
    }

    public function project_member()
    {
        return $this->hasOneThrough(
            Contact::class,
            ProjectAssign::class,
            'project_id', // FK on projects_assign
            'id',         // FK on contacts
            'id',         // local key on projects
            'staff_id'    // local key on projects_assign
        );
    }

    public function client() 
    {
        return $this->hasOne(Contact::class, 'id', 'client_id');
    }

    public function phases()
    {
        return $this->belongsToMany(
            ProjectPhase::class,
            'solar_project_phases',
            'project_id',
            'project_phase_id'
        );
    }


    public function setStartDateAttribute( $value ) {
        $this->attributes['start_date'] = Carbon::createFromFormat(config('solarmitra.date_time_format'),$value)->format('Y-m-d H:i:s');
    }

    public function getStartDateAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function setEndDateAttribute( $value ) {
        $this->attributes['end_date'] = Carbon::createFromFormat(config('solarmitra.date_time_format'),$value)->format('Y-m-d H:i:s');
    }

    public function getEndDateAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getCreatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getUpdatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }
    
}
