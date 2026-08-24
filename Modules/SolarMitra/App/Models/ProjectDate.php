<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SolarMitra\Database\factories\ProjectFactory;
use Carbon\Carbon;

class ProjectDate extends AppModel
{
    use HasFactory;

    protected $table = 'project_dates';
    
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['project_id','document_varify_date','name_correction_date','name_transfer_date','subsidi_registration_date','loan_doc_submit_date','bank_verification_date','loan_disberment_date','panel_work_date','cabling_work_date','civil_work_date','handover_date'];
    
    protected static function newFactory(): ProjectDateFactory
    {
        //return ProjectDateFactory::new();
    }

    public function getDocumentVarifyDateAttribute( $value ) {
        if (empty($value)) {
            return null; 
        }
        return Carbon::parse($value)->format(config('solarmitra.date_time_format'));
    }

    public function getNameCorrectionDateAttribute( $value ) {
        if (empty($value)) {
            return null; 
        }
        return Carbon::parse($value)->format(config('solarmitra.date_time_format'));
    }

    public function getNameTransferDateAttribute( $value ) {
        if (empty($value)) {
            return null; 
        }
        return Carbon::parse($value)->format(config('solarmitra.date_time_format'));
    }

    public function getSubsidiRegistrationDateAttribute( $value ) {
        if (empty($value)) {
            return null; 
        }
        return Carbon::parse($value)->format(config('solarmitra.date_time_format'));
    }

    public function getLoanDocSubmitDateAttribute( $value ) {
        if (empty($value)) {
            return null; 
        }
        return Carbon::parse($value)->format(config('solarmitra.date_time_format'));
    }

    public function getBankVerificationDateAttribute( $value ) {
        if (empty($value)) {
            return null; 
        }
        return Carbon::parse($value)->format(config('solarmitra.date_time_format'));
    }

    public function getLoanDisbermentDateAttribute( $value ) {
        if (empty($value)) {
            return null; 
        }
        return Carbon::parse($value)->format(config('solarmitra.date_time_format'));
    }

    public function getPanelWorkDateAttribute( $value ) {
        if (empty($value)) {
            return null; 
        }
        return Carbon::parse($value)->format(config('solarmitra.date_time_format'));
    }

    public function getCablingWorkDateAttribute( $value ) {
        if (empty($value)) {
            return null; 
        }
        return Carbon::parse($value)->format(config('solarmitra.date_time_format'));
    }

    public function getCivilWorkDateAttribute( $value ) {
        if (empty($value)) {
            return null; 
        }
        return Carbon::parse($value)->format(config('solarmitra.date_time_format'));
    }

    public function getHandoverDateAttribute( $value ) {
        if (empty($value)) {
            return null; 
        }
        return Carbon::parse($value)->format(config('solarmitra.date_time_format'));
    }

    public function getCreatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getUpdatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }
}
