<?php

namespace Modules\SolarMitra\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\SolarMitra\App\Models\MaterialLibrary;
use Modules\SolarMitra\App\Models\MaterialCategory;
use Modules\SolarMitra\App\Models\MaterialUnit;
use Modules\SolarMitra\App\Models\MaterialCompany;

/**
 * Seeds the materials table (plus companies / categories / units) from the
 * bundled materials.json export of materials-org.xlsx.
 *
 * Logic mirrors Modules\SolarMitra\Lib\MaterialsImport::model():
 *  - find-or-create Company / Category / Unit by (case-insensitive) title
 *  - update the MaterialLibrary row if a material with the same title
 *    already exists, otherwise create it (title match is case-insensitive)
 *  - keep the Company <-> Category pivot in sync
 *
 * Rows are processed in chunks (see $chunkSize) so this stays memory-safe
 * even if materials.json grows to many thousands of rows: each chunk runs
 * in its own DB transaction and the query log / lookup arrays are kept
 * lean instead of accumulating for the whole run.
 *
 * Place materials.json alongside this seeder at:
 *   database/seeders/data/materials.json
 * (or adjust $jsonPath below to wherever you keep it)
 */
class MaterialsSeeder extends Seeder
{
    /** How many rows to process per DB transaction / batch. */
    protected int $chunkSize = 300;

    // Lookup maps, keyed by lowercased-trimmed title => id
    protected array $companies = [];
    protected array $categories = [];
    protected array $units = [];
    protected array $materials = [];

    protected int $importedCount = 0;
    protected int $duplicateCount = 0;

    public function run(): void
    {
        $jsonPath = module_path('SolarMitra', 'Database/data/materials.json');

        if (!file_exists($jsonPath)) {
            $this->command?->error("Materials JSON file not found at: {$jsonPath}");
            return;
        }

        $rows = json_decode(file_get_contents($jsonPath), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->command?->error('Failed to parse materials.json: ' . json_last_error_msg());
            return;
        }

        // Avoid Laravel's query log growing unbounded over thousands of rows.
        DB::connection()->disableQueryLog();

        $this->loadLookups();

        $chunks = array_chunk($rows, $this->chunkSize);
        $totalChunks = count($chunks);

        foreach ($chunks as $index => $chunk) {
            DB::transaction(function () use ($chunk) {
                foreach ($chunk as $row) {
                    $this->importRow($row);
                }
            });

            $this->command?->info(sprintf(
                'Processed chunk %d/%d (%d rows)',
                $index + 1,
                $totalChunks,
                count($chunk)
            ));

            // Free memory between chunks on very large files.
            unset($chunk);
            gc_collect_cycles();
        }

        $this->command?->info("Materials seeding complete. Created: {$this->importedCount}, Updated (duplicates): {$this->duplicateCount}");
    }

    protected function loadLookups(): void
    {
        $this->companies = MaterialCompany::pluck('id', 'title')
            ->mapWithKeys(fn ($id, $title) => [strtolower(trim($title)) => $id])
            ->toArray();

        $this->categories = MaterialCategory::pluck('id', 'title')
            ->mapWithKeys(fn ($id, $title) => [strtolower(trim($title)) => $id])
            ->toArray();

        $this->units = MaterialUnit::pluck('id', 'title')
            ->mapWithKeys(fn ($id, $title) => [strtolower(trim($title)) => $id])
            ->toArray();

        // Case-insensitive title map for duplicate detection, same idea as
        // the company/category/unit maps above, so we never issue a
        // per-row `WHERE title = ?` query (and it's case-insensitive).
        $this->materials = MaterialLibrary::pluck('id', 'title')
            ->mapWithKeys(fn ($id, $title) => [strtolower(trim($title)) => $id])
            ->toArray();
    }

    protected function importRow(array $row): void
    {
        // Required fields — skip incomplete rows defensively
        if (empty($row['title']) || empty($row['company']) || empty($row['category'])
            || empty($row['unit']) || !isset($row['purchase_price'])) {
            $this->command?->warn('Skipping row with missing required field: ' . json_encode($row));
            return;
        }

        $titleKey = strtolower(trim($row['title']));
        $existingMaterialId = $this->materials[$titleKey] ?? null;

        if ($existingMaterialId) {
            $this->duplicateCount++;
            $material = MaterialLibrary::find($existingMaterialId);

            // Safety net: if the id in our map is stale (e.g. row was
            // deleted mid-run by something else), fall back to creating.
            if (!$material) {
                $material = new MaterialLibrary();
                $this->importedCount++;
                $this->duplicateCount--;
            }
        } else {
            $this->importedCount++;
            $material = new MaterialLibrary();
        }

        $companyTitle  = trim($row['company']);
        $categoryTitle = trim($row['category']);
        $unitTitle     = trim($row['unit']);

        // Company
        if (!isset($this->companies[strtolower($companyTitle)])) {
            $company = MaterialCompany::create(['title' => $companyTitle]);
            $this->companies[strtolower($companyTitle)] = $company->id;
        }
        $companyId = $this->companies[strtolower($companyTitle)];

        // Category
        if (!isset($this->categories[strtolower($categoryTitle)])) {
            $category = MaterialCategory::create([
                'title' => $categoryTitle,
                'slug'  => Str::slug($categoryTitle),
                'order' => (count($this->categories) + 1),
            ]);
            $this->categories[strtolower($categoryTitle)] = $category->id;
        }
        $categoryId = $this->categories[strtolower($categoryTitle)];

        // Unit
        if (!isset($this->units[strtolower($unitTitle)])) {
            $unit = MaterialUnit::create(['title' => $unitTitle]);
            $this->units[strtolower($unitTitle)] = $unit->id;
        }
        $unitId = $this->units[strtolower($unitTitle)];

        // Assign values (update OR create)
        $material->material_company_id  = $companyId;
        $material->material_category_id = $categoryId;
        $material->unit_id              = $unitId;
        $material->title                = $row['title'];
        $material->slug                 = Str::slug($row['title']);
        $material->selling_price        = $row['selling_price'] ?? $row['purchase_price'];
        $material->purchase_price       = $row['purchase_price'];
        $material->gst                  = $row['gst'] ?? 0;
        $material->search_tags          = $row['search_tags'] ?? null;
        $material->hsn_sac              = $row['hsn_sac'] ?? null;
        $material->description          = $row['description'] ?? null;

        $material->save();

        // Register/update this title in the map (case-insensitive key) so
        // later rows with the same title — however cased — are treated as
        // duplicates and update this same record instead of creating a new one.
        $this->materials[$titleKey] = $material->id;

        // Sync company-category relation
        $company = MaterialCompany::find($companyId);
        $company->categories()->syncWithoutDetaching([$categoryId]);
    }
}
