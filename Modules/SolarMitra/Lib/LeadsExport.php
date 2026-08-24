<?php

namespace Modules\SolarMitra\Lib;


// use Maatwebsite\Excel\Concerns\FromCollection;
use Modules\SolarMitra\App\Models\Lead;
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize
};


class LeadsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    public function collection()
    {
        return Lead::with(['address','follow_ups','source','lead_stage','added_by_user'])->get();
    }

    public function headings(): array
    {
        return [
            'First Name',
            'Last Name',
            'Email',
            'Phone',
            'Abbreviation',
            'Lead Source',
            'Lead Stage',
            'Potential',

            'Follow Up Date',
            'Repeat Follow Up',
            'Follow Up Note',

            'Address Title',
            'Address',
            'City ID',
            'State ID',
            'Country ID'
        ];
    }

    public function map($lead): array
    {
        // Get first followup (or latest if you prefer)
        $followup = optional($lead)->last_follow_up;

        // Get primary address
        $address = optional($lead)->address;

        return [
            optional($lead)->first_name,
            optional($lead)->last_name,
            optional($lead)->email,
            optional($lead)->phone,
            optional($lead)->abbreviation,
            optional(optional($lead)->source)->slug,
            optional(optional($lead)->lead_stage)->slug,
            optional($lead)->potential,

            optional($followup)->date_time ?? null,
            optional($followup)->repeat_followup ?? null,
            optional($followup)->note ?? null,

            optional($address)->address_title ?? null,
            optional($address)->address ?? null,
            optional($address)->city_id ?? null,
            optional($address)->state_id ?? null,
            optional($address)->country_id ?? null,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['argb' => 'FFE5E5E5'],
                ],
            ],
        ];
    }

}
