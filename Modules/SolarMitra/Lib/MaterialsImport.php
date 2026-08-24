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
use Modules\SolarMitra\App\Models\MaterialLibrary;
use Modules\SolarMitra\App\Models\MaterialCategory;
use Modules\SolarMitra\App\Models\MaterialUnit;
use Modules\SolarMitra\App\Models\MaterialCompany;
use Illuminate\Support\Str;

class MaterialsImport implements ToModel,WithHeadingRow,WithValidation,WithChunkReading,SkipsOnFailure
{
    use SkipsFailures;
    protected $categories = [];
    protected $companies = [];
    protected $units = [];
    public $duplicateCount = 0; 
    public $importedCount = 0;

    public function __construct()
    {
        $this->companies = MaterialCompany::pluck('id','title')->toArray();
        $this->categories = MaterialCategory::pluck('id','title')->toArray();
        $this->units = MaterialUnit::pluck('id','title')->toArray();
    }

    public function model(array $row)
    {
        $existingMaterial = MaterialLibrary::where('title', $row['title'])->first();

        if ($existingMaterial) {
            $this->duplicateCount++; // count duplicate

            $material = $existingMaterial; // update this
        } else {
            $this->importedCount++;
            $material = new MaterialLibrary(); // create new
        }

        $companyTitle = trim($row['company']);
        $categoryTitle = trim($row['category']);
        $unitTitle = trim($row['unit']);

        // Company
        if (!isset($this->companies[$companyTitle])) {
            $company = MaterialCompany::create(['title' => $companyTitle]);
            $this->companies[$companyTitle] = $company->id;
        }
        $companyId = $this->companies[$companyTitle];

        // Category
        if (!isset($this->categories[$categoryTitle])) {
            $category = MaterialCategory::create([
                'title' => $categoryTitle,
                'slug' => Str::slug($categoryTitle),
                'order' => (count($this->categories) + 1)
            ]);
            $this->categories[$categoryTitle] = $category->id;
        }
        $categoryId = $this->categories[$categoryTitle];

        // Unit
        if (!isset($this->units[$unitTitle])) {
            $unit = MaterialUnit::create(['title' => $unitTitle]);
            $this->units[$unitTitle] = $unit->id;
        }
        $unitId = $this->units[$unitTitle];

        // Assign values (update OR create)
        $material->material_company_id  = $companyId;
        $material->material_category_id = $categoryId;
        $material->unit_id              = $unitId;
        $material->title                = $row['title'];
        $material->slug                 = Str::slug($row['title']);
        $material->selling_price        = $row['selling_price'] ?? $row['purchase_price'];
        $material->purchase_price       = $row['purchase_price'];
        $material->gst                  = $row['gst'];
        $material->search_tags          = $row['search_tags'];
        $material->hsn_sac              = $row['hsn_sac'];
        $material->description          = $row['description'];

        $material->save();

        // Sync company-category relation
        $company = MaterialCompany::find($companyId);
        $company->categories()->syncWithoutDetaching([$categoryId]);

        return $material;
    }

    public function rules(): array
    {
        return [
            '*.title' => 'required',
            '*.company' => 'required',
            '*.category' => 'required',
            '*.unit' => 'required',
            '*.purchase_price' => 'required',
        ];
    }

    public function chunkSize(): int
    {
        return 500;
    }
}

