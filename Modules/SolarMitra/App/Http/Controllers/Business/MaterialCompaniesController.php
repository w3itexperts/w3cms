<?php

namespace Modules\SolarMitra\App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Modules\SolarMitra\App\Models\MaterialLibrary;
use Modules\SolarMitra\App\Models\MaterialCategory;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Modules\SolarMitra\App\Models\MaterialUnit;
use Modules\SolarMitra\App\Models\MaterialCompany;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Notification;

class MaterialCompaniesController extends Controller
{
    
    public function index(Request $request)
    {

        $page_title = __('solarmitra::solarmitra.material_companies');
        $material_companies = MaterialCompany::query()->withCount('categories')->withCount('material_items')->when($request->has('title'), function ($query) use ($request) {
                                    $query->where('title','Like', '%'.$request->title.'%');
                                })->paginate(config('Reading.nodes_per_page'));
        return view('solarmitra::business.material-companies.index',compact('page_title','material_companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function ajax_modal(Request $request, $id = null)
    {

        $company = null;
        $selectedCategoryIds = [];

        if ($id) {
            $company = MaterialCompany::with('categories')->find($id);
            if ($company) {
                $selectedCategoryIds = $company->categories->pluck('id')->toArray();
            }
        }

        if (!$company) {
            $company = new MaterialCompany();
        }

        if ($request->ajax()) {
            return view('solarmitra::business.material-companies.modal',compact('company','selectedCategoryIds'));
        }

        return view('solarmitra::business.material-companies.ajax_modal');
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'title'          => 'required',
            'material_category_id'   => 'array',
            'material_category_id.*' => 'exists:material_categories,id',
        ]);

        $company = MaterialCompany::create([
            'title'          => $request->title,
            'description'    => $request->description,
        ]);

       $company->categories()->sync($request->material_category_id);

        /* Send Event Notification */
        $notificationObj        = new Notification();
        $notificationObj->notification_entry('MATERIALCOMPANY-ANMC', $company->id, auth('business')->id(), config('constants.superadmin'));
        /* End Send Event Notification */
    
        if ($request->ajax()) {
            return response()->json(['status' => true,'reload' => true,'message' => __('solarmitra::solarmitra.material_company_added_text')]);
        }
        return redirect()->route('business.solarmitra.material_companies.index');
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $company = MaterialCompany::findOrFail($id);

        $request->validate([
            'title' => 'required',
            'material_category_id' => 'array',
            'material_category_id.*' => 'exists:material_categories,id',
        ]);

        $company->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        $company->categories()->sync($request->material_category_id ?? []);

        /* Send Event Notification */
        $notificationObj        = new Notification();
        $notificationObj->notification_entry('MATERIALCOMPANY-UMC', $company->id, auth('business')->id(), config('constants.superadmin'));
        /* End Send Event Notification */

        if ($request->ajax()) {
            return response()->json(['status' => true,'reload' => true,'message' => __('solarmitra::solarmitra.material_company_updated_text')]);
        }
        return redirect()->route('business.solarmitra.material_companies.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $materialCompany = MaterialCompany::findOrFail($id);

        /* Send Event Notification */
        $notificationObj        = new Notification();
        $notificationObj->notification_entry('MATERIALCOMPANY-DMC', $materialCompany->id, auth('business')->id(), config('constants.superadmin'));
        /* End Send Event Notification */
        
        $materialCompany->delete();
        return redirect()->back()->with('success', __('solarmitra::solarmitra.material_company_deleted_text'));
    }
}
