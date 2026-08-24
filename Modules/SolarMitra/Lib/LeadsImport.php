<?php

namespace Modules\SolarMitra\Lib;
use Maatwebsite\Excel\Concerns\{
    ToModel,
    WithHeadingRow,
    WithValidation,
    WithChunkReading,
    SkipsOnFailure,
    SkipsFailures,
    Failure,
    
};
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\SolarMitra\App\Models\Lead;
use Modules\SolarMitra\App\Models\Source;
use Modules\SolarMitra\App\Models\Channel;
use Modules\SolarMitra\App\Models\ClientGroup;
use Modules\SolarMitra\App\Models\LeadStage;
use Modules\SolarMitra\App\Models\LeadAddress;
use Modules\SolarMitra\App\Models\Address;
use Modules\SolarMitra\App\Models\LeadFollowUp;
use Illuminate\Support\Str;

class LeadsImport implements ToModel,WithHeadingRow,WithValidation,WithChunkReading,SkipsOnFailure
{
    use SkipsFailures;
    protected $lead_stages;
    protected $lead_sources;
    public $duplicateCount = 0; 
    public $importedCount = 0;

    public function __construct()
    {
        $this->lead_stages = LeadStage::orderBy('order', 'asc')->pluck('id','slug')->toArray();
        $this->lead_sources = Source::visibleToBusiness()->where('is_active',1)->pluck('id','slug')->toArray();
    }

    public function model(array $row)
    {
        // Skip duplicate email
        if (Lead::where('business_id', app('currentBusinessId'))->where('phone', $row['phone'])->exists()) {
            $this->duplicateCount++; 
            return null;
        }

        $this->importedCount++;
        $lead = Lead::create([
            'business_id'      => app('currentBusinessId'),
            'lead_added_by_id'      => auth('business')->user()->id,
            'first_name'      => $row['first_name'],
            'last_name'       => $row['last_name'],
            'email'           => $row['email'],
            'phone'           => $row['phone'],
            'abbreviation'      => $row['abbreviation'],
            'client_group_id'   => request()->client_group ?? 0,
            'lead_source_id'    => $this->lead_sources[$row['lead_source']] ?? 1,
            'lead_stage_id'        => $this->lead_stages[$row['lead_stage']] ?? 1,
            'potential'         => $row['potential'],
        ]);

        // Create FollowUp (if date exists)
        if (!empty($row['follow_up_date'])) {

            LeadFollowUp::create([
                'lead_id' => $lead->id,
                'assigned_to' =>  request()->assign_to ?? $row['assigned_to'],
                'date_time' => $row['follow_up_date'] ?? Carbon::today(),
                'note' => $row['follow_up_note'] ?? null,
                'repeat_followup' => 0
            ]);
        }

        // Create Address (if address exists)
        if (!empty($row['address'])) {

            $address = Address::create([
                'business_id' => 0,
                'contact_id'  => 0,
                'project_id'  => 0,
                'address_title' => $row['address_title'] ?? 'Primary',
                'address'     => $row['address'],
                'city_id'     => $row['city_id'] ?? null,
                'state_id'    => $row['state_id'] ?? null,
                'country_id'  => $row['country_id'] ?? null,
                'is_primary'  => 1
            ]);

            LeadAddress::create([
                'lead_id' => $lead->id,
                'address_id' => $address->id
            ]);
        }

        return $lead;
    }

    public function rules(): array
    {
        return [
            '*.first_name' => 'required',
            '*.phone' => 'required|digits:10|unique:leads',
        ];
    }

    public function chunkSize(): int
    {
        return 300;
    }
}

