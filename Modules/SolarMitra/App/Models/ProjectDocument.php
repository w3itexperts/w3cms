<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SolarMitra\Database\factories\ProjectFactory;
use Carbon\Carbon;

class ProjectDocument extends AppModel
{
    use HasFactory;

    protected $table = 'project_documents';
    
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'project_id',
        'government_subsidy',
        'selected_subsidy_type',
        'electricity_bill',
        'electricity_bill_verification_status',
        'adhar_card',
        'adhar_card_backside',
        'adhar_card_verification_status',
        'pancard',
        'pancard_verification_status',
        'bank_passbook',
        'bank_passbook_verification_status',
        'name_correction_new_name',
        'name_correction_new_name_status',
        'noc_name_transfer',
        'noc_name_transfer_status',
        'property_patta_evidence',
        'property_patta_evidence_verification_status',
        'subsidi_registration_status',
        'loan_doc_submit_status',
        'bank_verification_status',
        'loan_disberment_status',
        'structure_work_status',
        'panel_work_status',
        'cabling_work_status',
        'civil_work_status',
        'netmeter_file_submission',
        'netmeter_site_visited',
        'netmeter_depamd_note_generated',
        'netmeter_depamd_note_paid',
        'netmeter_installed',
        'netmeter_photo',
        'netmeter_plant_on',
        'netmeter_plant_photo',
        'handover_confirmation_signature',
        'handover_status',
    ];
    
    protected static function newFactory(): ProjectDocumentFactory
    {
        //return ProjectDocumentFactory::new();
    }
    

    public function getCreatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getUpdatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }
}
