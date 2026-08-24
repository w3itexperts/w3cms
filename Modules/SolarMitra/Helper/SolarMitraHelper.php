<?php
namespace Modules\SolarMitra\Helper;
use Modules\SolarMitra\App\Models\City;
use Modules\SolarMitra\App\Models\State;
use Modules\SolarMitra\App\Models\Country;
use Modules\SolarMitra\App\Models\Contact;
use Modules\SolarMitra\App\Models\Project;
use Modules\SolarMitra\App\Models\MaterialUnit;
use Modules\SolarMitra\App\Models\MaterialCategory;
use Modules\SolarMitra\App\Models\MaterialCompany;
use Modules\SolarMitra\App\Models\Attachment;
use Modules\SolarMitra\App\Models\MaterialLibrary;
use Modules\SolarMitra\App\Models\TransactionType;
use Modules\SolarMitra\App\Models\ConfigMaster;
use Modules\SolarMitra\App\Models\BusinessConfigMaster;
use Modules\SolarMitra\App\Models\BusinessRole;
use Modules\SolarMitra\App\Models\Invoice;
use Modules\SolarMitra\App\Models\Quotation;

class SolarMitraHelper
{
    
    public static function getCitiesList() {
        $cities = City::where('state_id',config('solarmitra.state_id_rajasthan'))->get()->pluck('name','id')->toArray();
        return $cities;

    }

    public static function getStatesList() {
        $cities = State::where('country_id',config('solarmitra.country_id_india'))->get()->pluck('name','id')->toArray();
        return $cities;

    }

    public static function getCountriesList() {
        $cities = Country::where('id',config('solarmitra.country_id_india'))->get()->pluck('name','id')->toArray();
        return $cities;

    }

    public static function getContactTypes($id) {
        $contact_types = [];
        $contact = Contact::find($id);
        
        if (@$contact->client) {
            $contact_types[] = 'client';
        }
        if (@$contact->supplier) {
            $contact_types[] = 'supplier';
        }
        if (@$contact->investor) {
            $contact_types[] = 'investor';
        }
        if (@$contact->contractor) {
            $contact_types[] = 'contractor';
        }
        if (@$contact->partner) {
            $contact_types[] = 'partner';
        }
        if (@$contact->staff) {
            $contact_types[] = 'staff';
        }

        return $contact_types;

    }

    public static function getItemUnitsArr() {
        return $units = MaterialUnit::select('id','title')->get()->pluck('title','id')->toArray();
    }

    public static function getItemCategoryArr() {
        return $units = MaterialCategory::select('id','title')->get()->pluck('title','id')->toArray();
    }

    public static function getContactsList($type=null,$projectId=null,$selectedConId=null) {
        $query = Contact::query()->where('business_id',app('currentBusinessId'));

        if ($projectId) {
            $query->where('project_id',$projectId);
        }

        if ($type && !is_array($type) && in_array($type, array_keys(config('solarmitra.business_user_types')))) {
            $query->whereHas(\Str::singular($type ?? ''));
        }

        return $contacts = $query->get()->pluck('name','id')->toArray();
    }

    public static function getContactDropdown($type=null,$projectId=null,$selectedConId=null) {
        
        $selectedContact = Contact::find($selectedConId);
        $query = Contact::query()->where('business_id',app('currentBusinessId'))->whereNot('type',1);

        if ($projectId) {
            $query->where('project_id',$projectId);
        }

        if ($type && !is_array($type) && in_array($type, array_keys(config('solarmitra.business_user_types')))) {
            $query->whereHas(\Str::singular($type ?? ''));
        }

        $contacts = $query->get();
        $form_url = @$type ? route('business.solarmitra.contacts.create',['type'=>@$type]) : route('business.solarmitra.contacts.create') ;
        $singularType = @$type ? \Str::singular($type ?? '') : 'contact';

        $idId = \Str::studly($singularType)."Id";  /* By Rahul Sharma  */
        $idTitle = \Str::studly($singularType)."Title";  /* By Rahul Sharma  */

        $html = '<div class="dropdown-slt contact-dropdown">
            <label class="form-label ">'.__('solarmitra::solarmitra.select').' '.__('solarmitra::solarmitra.'.($singularType)).' <span class="text-danger">*</span></label>
            <input class="form-control w-100 p-2 border rounded on-dropdown-name-input" name="'.($singularType).'_name" id="'.($idTitle).'" data-dropdown-target=".'.(\Str::studly($singularType)).'Dropdown" type="text" readonly="" value="'.@$selectedContact->name.'" placeholder="'.__('solarmitra::solarmitra.select').' '.__('solarmitra::solarmitra.'.($singularType)).'">
            <input name="'.($singularType).'_id" id="'.($idId).'" class="on-dropdown-id-input" type="hidden" value="'.@$selectedContact->id.'">
            <div class="dropdown-list border rounded mt-2 p-2 on-dropdown-menu '.(\Str::studly($singularType)).'Dropdown" style="display: none;">
                <input class="form-control w-100 p-2 border rounded on-dropdown-name-search" name="name_dropdown_search" type="search" placeholder="Search Here ...">';
                $html .= '<div class="dropdown-items-scroll">';
                foreach ($contacts as $contact){

                    $nameParts = explode(' ', $contact->name, 2);
                    $p1 = $nameParts[0] ?? '';  
                    $p2 = $nameParts[1] ?? '';
                    $contactType = \Str::studly(implode(', ', self::getContactTypes($contact->id))) ?: __('solarmitra::solarmitra.'.$singularType);
                    
                    $html .= '<div class="party-item d-flex align-items-center p-2 border-bottom pointer gap-2 on-dropdown-item '. (@$selectedContact->id == $contact->id ? 'bg-primary-subtle' : '') .'" data-id="'.$contact->id.'" data-name="'.$contact->name.'">
                        <div class="bg-primary text-white rounded-circle width40 height40 d-flex align-items-center gap-1 justify-content-center fw-medium">'.substr(@$p1, 0,1).substr(@$p2, 0,1).'</div>

                        <div class="flex-grow-1 d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-semibold text-black">'.$contact->name.'</div>
                                <span class="fs-12">'.$contact->phone.'</span>
                            </div>
                            <div>
                                <div>'. $contactType .'</div>
                            </div>
                        </div>
                    </div>';
                }
                $html .= '</div>';

                $html .= '<button class="btn btn-outline-primary w-100 mt-2 AjaxOffCanvasShow"  href="'.$form_url.'" >'.__('solarmitra::solarmitra.create').' '.\Str::headline(\Str::studly($singularType)).'</button>
            </div>
        </div>';

        return $html;

    }
    
    public static function getItemCompanyArr($idsArr=[]) {

        return $units = MaterialCompany::select('id','title')->get()->pluck('title','id')->toArray();
    }

    public static function getCompaniesByCategoryArr($catId = null) {
       
        $companiesArr = [];

        if (is_array($catId)) {
            $categories = MaterialCategory::with('companies')->whereIn('id', $catId)->get();
            return $categories->pluck('companies')->collapse()->pluck('title', 'id')->toArray();

        } else {
            $category = MaterialCategory::where('id',$catId)->first();
            if ($category) {
                return $category->companies->pluck('title', 'id')->toArray();
            }
        }
        
        return [];
    }

    public static function getMaterialItemsByBrandArr($companyIds = null) {
       
        return MaterialLibrary::when(is_array($companyIds), function ($q) use($companyIds){
                            return $q->whereIn('material_company_id', $companyIds);
                        })->
                        when(!empty($companyIds) && !empty($companyIds), function ($q) use($companyIds){
                            return $q->where('material_company_id', $companyIds);
                        })->get()->pluck('title', 'id')->toArray();
    }

    public static function getMaterialItemsByCategoryArr($categoryTitle = null) {
       
        return MaterialLibrary::when(!empty($categoryTitle) && is_array($categoryTitle), function ($q) use($categoryTitle){
                            $q->whereHas('material_category', function($sub_q) use($categoryTitle){
                                $sub_q->whereIn('title', $categoryTitle);
                            });

                        })
                        ->when(!empty($categoryTitle) && !is_array($categoryTitle), function ($q) use($categoryTitle){
                            $q->whereHas('material_category', function($sub_q) use($categoryTitle){
                                $sub_q->where('title', $categoryTitle);
                            });
                        })->get()->pluck('title', 'id')->toArray();
    }

    public static function getItemsByBrandAndCategory($categoryIds = null,$companyIds = null) {
       
        return MaterialLibrary::when(is_array($categoryIds), function ($q) use($categoryIds){
                            return $q->whereIn('material_category_id', $categoryIds);
                        })->
                        when(!empty($categoryIds) && !empty($categoryIds), function ($q) use($categoryIds){
                            return $q->where('material_category_id', $categoryIds);
                        })->
                        when(is_array($companyIds), function ($q) use($companyIds){
                            return $q->whereIn('material_company_id', $companyIds);
                        })->
                        when(!empty($companyIds) && !empty($companyIds), function ($q) use($companyIds){
                            return $q->where('material_company_id', $companyIds);
                        })->
                        get()->pluck('title', 'id')->toArray();
    }

    public static function getAttachmentImage($attachment_id, $attachment = null) {
        if (!$attachment) {
            $attachment = Attachment::find($attachment_id);
        }
       
        if ($attachment) {

            if (!empty($attachment->business_id) && !empty($attachment->project_id) && is_file(storage_path('app/public/solarmitra-attachments/business_'.($attachment->business_id).'/project_'.$attachment->project_id.'/'.@$attachment->file_name))) {
                return asset('storage/solarmitra-attachments/business_'.($attachment->business_id).'/project_'.$attachment->project_id.'/'.$attachment->file_name);
            }elseif(!empty($attachment->business_id) && is_file(storage_path('app/public/solarmitra-attachments/business_'.($attachment->business_id).'/'.@$attachment->file_name))){
                return asset('storage/solarmitra-attachments/business_'.($attachment->business_id).'/'.$attachment->file_name);
            }else{
                return asset('images/noimage.jpg');
            }
        }
        return asset('images/noimage.jpg');
    }

    public static function getAttachment($attachment_id) {
        $attachment = Attachment::find($attachment_id);
        if(!$attachment){
            return null;
        }
        $attachment->file_url = self::getAttachmentImage($attachment_id, $attachment);
        return $attachment;
    }

    public static function getContactById($id) {
        return Contact::find($id);
    }

    public static function getProjectStep($projectId)
    {
        $project = Project::with('project_documents')->find($projectId);

        $doc = @$project->project_documents;

        $hasDocuments = @$doc->electricity_bill && 
            @$doc->adhar_card && 
            @$doc->adhar_card_backside &&
            (@$doc->government_subsidy == 1 ? (@$doc->pancard && @$doc->bank_passbook) : true);

        $verificationDone = !empty(@$doc->electricity_bill_verification_status) &&
            !empty(@$doc->adhar_card_verification_status) &&
            (!empty(@$doc->name_correction_new_name) ? !empty(@$doc->name_correction_new_name_status) : true) &&
            (!empty(@$doc->noc_name_transfer) ? !empty(@$doc->noc_name_transfer_status) : true) &&
            (!empty(@$doc->property_patta_evidence) ? !empty(@$doc->property_patta_evidence_verification_status) : true) &&
            (!empty(@$doc->government_subsidy)
            ? (!empty(@$doc->pancard_verification_status) && !empty(@$doc->bank_passbook_verification_status))
            : true);

        $subsidyDone = !empty(@$doc->government_subsidy)
            ? !empty(@$doc->subsidi_registration_status)
            : true;

        $structureDone = !empty(@$doc->structure_work_status) &&
            !empty(@$doc->panel_work_status) &&
            !empty(@$doc->cabling_work_status) &&
            !empty(@$doc->civil_work_status);

        $netMeterDone = !empty(@$doc->netmeter_file_submission) &&
            !empty(@$doc->netmeter_site_visited) &&
            !empty(@$doc->netmeter_demand_note_generated) &&
            !empty(@$doc->netmeter_demand_note_paid) &&
            !empty(@$doc->netmeter_installed) &&
            !empty(@$doc->netmeter_photo) &&
            !empty(@$doc->netmeter_plant_on) &&
            !empty(@$doc->netmeter_plant_photo);

        $handoverDone = !empty(@$doc->handover_confirmation_signature) &&
            !empty(@$doc->handover_status);

        $step = 'documents';

        if ($hasDocuments) {
            $step = 'verification';
            // Auto-change status from Draft to Running when documents are complete
            if ($project->status == config('solarmitra.projects_status_keys.Draft')) {
                $project->status = config('solarmitra.projects_status_keys.Running');
                $project->save();
            }
        }

        if ($hasDocuments && $verificationDone && !empty(@$doc->government_subsidy)) {
            $step = 'subsidy';
        }

        if ($hasDocuments && $verificationDone && $subsidyDone) {
            $step = 'structure';
        }

        if ($hasDocuments && $verificationDone && $subsidyDone && $structureDone) {
            $step = 'netmeter';
        }

        if ($hasDocuments && $verificationDone && $subsidyDone && $structureDone && $netMeterDone) {
            $step = 'handover';
        }

        if ($hasDocuments && $verificationDone && $subsidyDone && $structureDone && $netMeterDone && @$handoverDone) {
            $step = 'done';
        }

        return $step;
    }

    public static function getIncomeHead() {

        $transactionTypeObj = new TransactionType();
        return $transaction_type_arr = $transactionTypeObj->generateTreeArray(config('solarmitra.transaction_type.income'),'_',['id', 'title', 'slug']);
    }

    public static function getExpenseHead() {

        $transactionTypeObj = new TransactionType();
        return $transaction_type_arr = $transactionTypeObj->generateTreeArray(config('solarmitra.transaction_type.expense'),'_',['id', 'title', 'slug']);
    }

    public static function getBusinessConfig($key, $default = null)
    {
        $businessId = app()->bound('currentBusinessId')
            ? app('currentBusinessId')
            : null;

        $config = ConfigMaster::query()
            ->leftJoin('business_config_master as bcm', function ($join) use ($businessId) {
                $join->on('config_master.id', '=', 'bcm.config_master_id')
                    ->where('bcm.business_id', $businessId);
            })
            ->where('config_master.field_key', $key)
            ->selectRaw('
                config_master.field_value as default_value,
                COALESCE(bcm.field_value, config_master.field_value) as value
            ')
            ->first();
            
        if (!$config || is_null($config->value)) {
            return $default;
        }

        return is_numeric($config->value)
            ? $config->value + 0
            : $config->value;
    }

    public static function setBusinessConfig($key,$value) {
        
        $ConfigMaster = ConfigMaster::where('field_key',$key)->first();

        if (!$ConfigMaster) return;

        $BusinessConfigMaster = BusinessConfigMaster::updateOrCreate(
            [
                'config_master_id' => $ConfigMaster->id,
                'business_id' => app('currentBusinessId'),
            ],
            [
                'display_title' => $ConfigMaster->display_title,
                'field_key' => $ConfigMaster->field_key,
                'field_value' => $value,
            ]
        );

        return $BusinessConfigMaster;
    }


    public static function format_number($number, $decimals = 2)
    {
        if (!empty($decimals)) {
            $decimals = Self::getBusinessConfig('decimal_precision', $decimals);
        }
        $format = Self::getBusinessConfig('number_format', 'indian');

        switch ($format) {

            case 'indian':
                return Self::indian_number_format($number, $decimals);

            case 'international':
                return number_format($number, $decimals, '.', ',');

            case 'plain':
                return number_format($number, $decimals, '.', '');

            case 'space_separator':
                return number_format($number, $decimals, '.', ' ');

            default:
                return number_format($number, $decimals, '.', ',');
        }
    }


    public static function indian_number_format($number, $decimals = 2)
    {
        $number = round($number, $decimals);

        $parts = explode('.', number_format($number, $decimals, '.', ''));

        $integerPart = $parts[0];
        $decimalPart = $parts[1] ?? '';

        $lastThree = substr($integerPart, -3);

        $restUnits = substr($integerPart, 0, -3);

        if ($restUnits != '') {
            $restUnits = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $restUnits);
            $formatted = $restUnits . ',' . $lastThree;
        } else {
            $formatted = $lastThree;
        }

        return $formatted . ($decimals ? '.' . $decimalPart : '');
        
    }

    /**
     * Generate a unique sequential number for quotation or invoice.
     *
     * Uses MAX numeric extraction instead of COUNT — safe even after record deletion.
     *
     * @param  string $type  'quotation' or 'invoice'
     * @return string        e.g. "QUO-1", "INV-1"
     */
    public static function generateDocumentNumber(string $type): string
    {
        $businessId = app('currentBusinessId');

        $prefix   = self::getBusinessConfig("{$type}_prefix", $type === 'invoice' ? 'Inv-' : 'QT-');
        $suffix   = self::getBusinessConfig("{$type}_suffix", '');
        $startNum = (int) self::getBusinessConfig("{$type}_start_number", 1);

        // Normalize: trim spaces + trailing dash, then add single trailing dash
        $numberPrefix = rtrim($prefix);

        $modelClass   = $type === 'invoice' ? Invoice::class : Quotation::class;
        $numberColumn = $type === 'invoice' ? 'invoice_number' : 'quotation_number';

        $maxNumber = $modelClass::where('business_id', $businessId)
            ->where($numberColumn, 'LIKE', $numberPrefix . '%')
            ->pluck($numberColumn)
            ->map(function ($num) use ($numberPrefix, $suffix) {
                $number = str_replace([$numberPrefix, $suffix], '', $num);
                return (int) $number;
            })
            ->max();

        $nextNumber = max(($maxNumber ?? 0) + 1, $startNum);

        return $numberPrefix . $nextNumber . $suffix;
    }

    /**
     * Get the title prefix for quotation or invoice (e.g. "INV -", "QUO -").
     *
     * @param  string $type  'quotation' or 'invoice'
     * @return string
     */
    public static function getDocumentTitlePrefix(string $type): string
    {
        $prefix = self::getBusinessConfig("{$type}_prefix", $type === 'invoice' ? 'Inv-' : 'QT-');
         $clean = preg_replace('/[_-][^_-]*\s*$/', '', trim($prefix));
        return ($clean ?: 'DOC') . ' - ';
    }

    public static function getBusinessRolesListArr()
    {
        $businessId = app('currentBusinessId');
        $business_roles = BusinessRole::where(function ($q) use ($businessId) {
                $q->where(function ($q) {
                    $q->whereNull('business_id')
                      ->where('name', 'Business Staff');
                })->orWhere(function ($q) use ($businessId) {
                    $q->where('business_id', $businessId)
                      ->whereNull('parent_id');
                });
            })
            ->with('childrenRecursive')
            ->get();

        return Self::flattenRoles($business_roles);
    }

    private static function flattenRoles($roles, int $level = 0, &$list = [])
    {
        foreach ($roles as $role) {
            $list[$role->id] = str_repeat('- ', $level) . $role->name;

            Self::flattenRoles($role->childrenRecursive, $level + 1, $list);
        }

        return $list;
    }

}