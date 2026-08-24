<?php

namespace Modules\SolarMitra\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\SolarMitra\App\Models\MaterialLibrary;
use Modules\SolarMitra\App\Models\MaterialCategory;
use Modules\SolarMitra\App\Models\MaterialUnit;
use Modules\SolarMitra\App\Models\MaterialCompany;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\SolarMitra\Lib\MaterialsExport;
use Modules\SolarMitra\Lib\MaterialsImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Notification;
use Illuminate\Support\Str;

class MaterialsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page_title = __('solarmitra::solarmitra.material_library');
        $materials = MaterialLibrary::when($request->filled('title'), function ($query) use ($request) {
                        $query->where('title','Like', '%'.$request->title.'%');
                    })
                    ->when($request->filled('material_category_id'), function ($query) use ($request) {
                        $query->where('material_category_id', $request->material_category_id);
                    })
                    ->when($request->filled('material_company_id'), function ($query) use ($request) {
                        $query->where('material_company_id', $request->material_company_id);
                    })
                    ->with('material_company','material_unit','material_category')
                    ->paginate(config('Reading.nodes_per_page'));
        return view('solarmitra::admin.materials.index',compact('page_title','materials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $page_title = __('solarmitra::solarmitra.material_library_create');
        $material_units = MaterialUnit::pluck('title','id')->toArray();
        $material_categories = MaterialCategory::select('id','title','unit_id','gst')->get();
        $material_companies = MaterialCompany::pluck('title','id')->toArray();

        if ($request->ajax()) {
            return view('solarmitra::admin.materials.material_modal',compact('material_companies','material_categories','material_units'));
        }

        return view('solarmitra::admin.materials.create',compact('material_companies','material_categories','material_units'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = [
            'title'  => 'required',
            'material_category_id'  => 'required',
            'selling_price'  => 'required',
            'purchase_price'  => 'required',
            'material_company_id'  => 'required',
            'unit_id'  => 'required',
            'hsn_sac' => ['nullable','regex:/^\d+(\.\d+)?$/'],
        ];

        $messages = [
            'title.required' => __('solarmitra::solarmitra.material_title_required'),
            'material_category_id.required' => __('solarmitra::solarmitra.select_material_category'),
            'selling_price.required' => __('solarmitra::solarmitra.selling_price_required'),
            'selling_price.numeric' => __('solarmitra::solarmitra.selling_price_must_be_number'),
            'purchase_price.required' => __('solarmitra::solarmitra.purchase_price_required'),
            'purchase_price.numeric' => __('solarmitra::solarmitra.purchase_price_must_be_number'),
            'material_company_id.required' => __('solarmitra::solarmitra.select_material_company'),
            'unit_id.required' => __('solarmitra::solarmitra.select_unit'),
            'hsn_sac.regex' => __('solarmitra::solarmitra.hsn_sac_valid_number'),
        ];

        $validator = \Validator::make($request->all(), $validation,$messages);
        
        if ($request->ajax() && $validator->fails()) 
        {
            return response()->json(['errors' => $validator->errors()], 422);
        }else{
            $this->validate($request, $validation,$messages);
        }
        
        $materialObj = new MaterialLibrary(); 
        $materialObj->material_company_id       = $request->material_company_id; 
        $materialObj->material_category_id      = $request->material_category_id; 
        $materialObj->unit_id                   = $request->unit_id; 
        $materialObj->title                     = $request->title; 
        $materialObj->slug                      = Str::slug($request->title);
        $materialObj->selling_price             = $request->selling_price; 
        $materialObj->purchase_price            = $request->purchase_price; 
        $materialObj->weight_per_piece          = $request->weight_per_piece ?? 0; 
        $materialObj->panel_wattage             = $request->panel_wattage ?? 0;
        $materialObj->gst                       = $request->gst; 
        $materialObj->search_tags               = $request->search_tags ? implode(',', array_column(json_decode($request->search_tags,true), 'value')) : ''; 
        $materialObj->hsn_sac                   = $request->hsn_sac; 
        $materialObj->description               = $request->description; 
        $res = $materialObj->save();

        if ($res) {

            /* Send Event Notification */
            $notificationObj        = new Notification();
            $notificationObj->notification_entry('MATERIAL-ANM', $materialObj->id, auth()->id(), config('constants.superadmin'));
            /* End Send Event Notification */

            if ($request->ajax()) {
                return response()->json(['status' => true,'reload' => true,'message' => __('solarmitra::solarmitra.material_created_text')]);
            }
            return redirect()->route('admin.solarmitra.materials.index');
        }

        return redirect()->back()->with('error', __('solarmitra::solarmitra.something_went_wrong'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request,$id)
    {
        $page_title = __('solarmitra::solarmitra.material_library_edit');
        $material = MaterialLibrary::findOrFail($id);
        $material_units = MaterialUnit::pluck('title','id')->toArray();
        $material_categories = MaterialCategory::pluck('title','id')->toArray();
        $material_companies = MaterialCompany::pluck('title','id')->toArray();

        if ($request->ajax()) {
            return view('solarmitra::admin.materials.material_modal',compact('page_title','material','material_companies','material_categories','material_units'));
        }

        return view('solarmitra::admin.materials.edit',compact('material','page_title','material_companies','material_categories','material_units'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validation = [
            'title'  => 'required',
            'material_category_id'  => 'required',
            'material_company_id'  => 'required',
            'unit_id'  => 'required',
            'selling_price'  => 'required',
            'purchase_price'  => 'required',
            'hsn_sac' => ['nullable','regex:/^\d+(\.\d+)?$/'],
        ];

        $messages = [
            'title.required' => __('solarmitra::solarmitra.material_title_required'),
            'material_category_id.required' => __('solarmitra::solarmitra.select_material_category'),
            'material_company_id.required' => __('solarmitra::solarmitra.select_material_company'),
            'unit_id.required' => __('solarmitra::solarmitra.select_unit'),
            'selling_price.required' => __('solarmitra::solarmitra.selling_price_required'),
            'selling_price.numeric' => __('solarmitra::solarmitra.selling_price_valid_number'),
            'purchase_price.required' => __('solarmitra::solarmitra.purchase_price_required'),
            'purchase_price.numeric' => __('solarmitra::solarmitra.purchase_price_valid_number'),
            'hsn_sac.regex' => __('solarmitra::solarmitra.hsn_sac_valid_number_with_decimals'),
        ];

        $validator = \Validator::make($request->all(), $validation,$messages);
        
        if ($request->ajax() && $validator->fails()) 
        {
            return response()->json(['errors' => $validator->errors()], 422);
        }else{
            $this->validate($request, $validation,$messages);
        }

        $materialObj = MaterialLibrary::findOrFail($id); 
        
        $materialObj->material_company_id       = $request->material_company_id;
        $materialObj->material_category_id      = $request->material_category_id;
        $materialObj->unit_id                   = $request->unit_id;
        $materialObj->title                     = $request->title;
        $materialObj->slug                      = Str::slug($request->title);
        $materialObj->selling_price             = $request->selling_price;
        $materialObj->purchase_price            = $request->purchase_price;
        $materialObj->weight_per_piece          = $request->weight_per_piece ?? 0;
        $materialObj->panel_wattage             = $request->panel_wattage ?? 0;
        $materialObj->gst                       = $request->gst;
        $materialObj->search_tags               = $request->search_tags ? implode(',', array_column(json_decode($request->search_tags,true), 'value')) : '';
        $materialObj->hsn_sac                   = $request->hsn_sac;
        $materialObj->description               = $request->description;
        $res = $materialObj->save();

        if ($res) {

            /* Send Event Notification */
            $notificationObj        = new Notification();
            $notificationObj->notification_entry('MATERIAL-UM', $materialObj->id, auth()->id(), config('constants.superadmin'));
            /* End Send Event Notification */

            if ($request->ajax()) {
                return response()->json(['status' => true,'reload' => true,'message' => __('solarmitra::solarmitra.material_updated_text')]);
            }
            return redirect()->route('admin.solarmitra.materials.index')->with('success', __('solarmitra::solarmitra.material_updated_text'));
        }

        return redirect()->back()->with('error', __('solarmitra::solarmitra.something_went_wrong'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $material = MaterialLibrary::findOrFail($id);

        /* Send Event Notification */
        $notificationObj        = new Notification();
        $notificationObj->notification_entry('MATERIAL-DM', $material->id, auth()->id(), config('constants.superadmin'));
        /* End Send Event Notification */

        $material->delete();
        return redirect()->back()->with('success', __('solarmitra::solarmitra.material_deleted_text'));
    }

    public function get_unit_by_category(Request $request)
    {
        $category = MaterialCategory::find($request->category_id);
        return response()->json(['status' => true,'unit_id' => @$category->unit_id]);

    }
}
