<?php

namespace Modules\SolarMitra\Lib;


// use Maatwebsite\Excel\Concerns\FromCollection;
use Modules\SolarMitra\App\Models\MaterialLibrary;
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize,
    WithStyles
};
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class MaterialsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    public function collection()
    {
        return MaterialLibrary::with(['material_category','material_company','material_unit'])->get();
    }

    public function headings(): array
    {
        return [
            'Title',
            'Company',
            'Category',
            'Unit',
            'Selling Price',
            'Purchase Price',
            'gst',
            'Hsn Sac',
            'Search Tags',
            'Description',
            // 'Category Description',
            // 'Company Description',
        ];
    }

    public function map($material): array
    {
        $category = $material->material_category;
        $company = $material->material_company;
        $unit = $material->material_unit;

        return [
            $material->title,
            @$company->title,
            @$category->title,
            @$unit->title,
            $material->selling_price,
            $material->purchase_price,
            $material->gst,
            $material->hsn_sac,
            $material->search_tags,
            $material->description,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [ // Row 1 = Header
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFE5E5E5'],
                ],
            ],
        ];

    }

}
