<?php

namespace Modules\SolarMitra\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\SolarMitra\App\Models\MaterialLibrary;
use Modules\SolarMitra\App\Models\MaterialCategory;
use Modules\SolarMitra\App\Models\Project;

class MaterialsController extends Controller
{

    // Get Category with company
    public function get_category_with_company(Request $request, $project_id = null)
    {
        
        $project = $project_id ? Project::findOrFail($project_id) : null;

        $isSolarKit =
            $request->boolean('is_solar_kit_project') ||
            optional($project)->is_solar_kit_project;

        $projectType =
            $request->project_type ??
            optional($project)->project_type;

        $query = MaterialCategory::with('companies')
            ->where('display_on_invoice', 1);

        if ($isSolarKit) {
            $query->where('include_in_solar_kit', '!=', 1);
        } else {
            $query->where('slug', '!=', 'solar-kit');
        }

        if ($projectType === 'On-Grid' ) {
            $query->where('slug', '!=', 'battery');
        }

        $categories = $query->orderBy('order', 'asc')->get();
 
        return response()->json([
            'status' => true,
            'data'   => $categories
        ]);
    }


    // Get Companies by Category
    public function get_companies_by_category($category_id)
    {
        $category = MaterialCategory::findOrFail($category_id);

        $companies = $category->companies()
            ->select('material_companies.id', 'title', 'description', 'attach_logo_id')
            ->orderBy('title')
            ->get();

        return response()->json([
            'status' => true,
            'data'   => $companies
        ]);
    }


    // Get Items by Company
    public function get_items_by_company_and_category($company_id,$category_id)
    {
        $items = MaterialLibrary::with('material_unit:id,title')
            ->where('material_company_id', $company_id)
            ->where('material_category_id', $category_id)
            ->orderBy('title')
            ->get();

        return response()->json([
            'status' => true,
            'data'   => $items
        ]);
    }

    // Get Items by category
    public function get_item_by_category($category_id)
    {
        $materials = MaterialLibrary::with('material_unit:id,title')->where('material_category_id',$category_id)->get();

        return response()->json([
            'status' => true,
            'data'   => $materials
        ]);
    }


}