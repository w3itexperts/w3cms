<?php

namespace Modules\SolarMitra\App\Http\Controllers\Admin;

use Modules\SolarMitra\App\Models\ConfigMaster;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ConfigMasterController extends Controller
{
    /**
     * Display a listing of the all configuration fields with pagination.
     */
    public function index(Request $request)
    {
        $page_title = __('solarmitra::solarmitra.config_master');
        $configurations = ConfigMaster::when(!empty($request->title), function ($q) use ($request) {
                $q->where('display_title', 'LIKE', '%' . $request->title . '%');
            })->when(!empty($request->module_code), function ($q) use ($request) {
                $q->where('module_code', $request->module_code );
            })->paginate(config('Reading.nodes_per_page'));
        
        return view('solarmitra::admin.config_master.index',compact('page_title','configurations'));
    }

    /**
     * form created by added config fields
     */
    public function manage(Request $request,$module='global')
    {
        if($request->isMethod('post'))
        {
            foreach ($request->ConfigMaster as $config) {

                $id = $config['id'];
                $key = collect($config)->except('id')->keys()->first();
                $value = isset($config[$key]) ? $config[$key] : null;
                
                ConfigMaster::where('id' , $id)->update(['field_value' => $value]);

            }

            return redirect()->back()->with('success', __('solarmitra::solarmitra.configs_saved'));
        }
        $page_title = __('solarmitra::solarmitra.'.$module) . " " . __('solarmitra::solarmitra.configurations');
        $configurations = ConfigMaster::where('module_code',$module)->paginate(config('Reading.nodes_per_page'));
        
        return view('solarmitra::admin.config_master.manage',compact('page_title','module','configurations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $page_title = __('solarmitra::solarmitra.add') . " " . __('solarmitra::solarmitra.config_master');
        if ($request->ajax()) {
            return view('solarmitra::admin.config_master.config_modal',compact('page_title'));
        }
        return view('solarmitra::admin.config_master.create',compact('page_title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,$id=null)
    {
        if($request->isMethod('post'))
        {
            $validation = [
                'configuration.display_title'       => 'required',
                'configuration.module_code'       => 'required',
                'configuration.field_key'        => 'required|unique:config_master,field_key',
                'configuration.field_type'      => 'required',
                'configuration.options_json'      => 'nullable|json',
                'configuration.validation_rules_json'      => 'nullable|json',
            ];
            
            $request->merge([
                'configuration.display_order' => $request->configuration['display_order'] ?? ConfigMaster::count()
            ]);

            $validationMsg = [
                'configuration.display_title.required' => __('solarmitra::solarmitra.display_title_required'),
                'configuration.module_code.required' => __('solarmitra::solarmitra.module_code_required'),
                'configuration.field_key.required' => __('solarmitra::solarmitra.field_key_required'),
                'configuration.field_key.unique' => __('solarmitra::solarmitra.field_key_unique'),
                'configuration.field_type.required' => __('solarmitra::solarmitra.field_type_required'),
                'configuration.options_json.json' => __('solarmitra::solarmitra.options_json_invalid'),
                'configuration.validation_rules_json.json' => __('solarmitra::solarmitra.validation_rules_json_invalid'),
            ];

            $validator = \Validator::make($request->all(), $validation,$validationMsg);
            
            if ($request->ajax() && $validator->fails()) 
            {
                return response()->json(['errors' => $validator->errors()], 422);
            }else{
                $this->validate($request, $validation,$validationMsg);
            }

            $config_master = ConfigMaster::create($request->configuration);

            if ($request->ajax()) 
            {
                return response()->json([
                    'status' => true,
                    'message' => __('solarmitra::solarmitra.config_add_success'),
                    'reload' => true,
                ]);
            }
            
            return redirect()->route('admin.solarmitra.config_master.index')->with('success', __('solarmitra::solarmitra.config_add_success'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request,$id)
    {
        $page_title = __('solarmitra::solarmitra.edit') . " " . __('solarmitra::solarmitra.config_master');
        $config_master = ConfigMaster::findOrFail($id);
        if ($request->ajax()) {
            return view('solarmitra::admin.config_master.config_modal',compact('page_title','config_master'));
        }
        return view('solarmitra::admin.config_master.edit',compact('page_title','config_master'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if($request->isMethod('post'))
        {
            $validation = [
                'configuration.display_title'       => 'required',
                'configuration.module_code'       => 'required',
                'configuration.field_key'        => 'required|unique:config_master,field_key,' . $id,
                'configuration.field_type'      => 'required',
                'configuration.options_json'      => 'nullable|json',
                'configuration.validation_rules_json'      => 'nullable|json',
            ];

            $validationMsg = [
                'configuration.display_title.required' => __('solarmitra::solarmitra.display_title_required'),
                'configuration.module_code.required' => __('solarmitra::solarmitra.module_code_required'),
                'configuration.field_key.required' => __('solarmitra::solarmitra.field_key_required'),
                'configuration.field_key.unique' => __('solarmitra::solarmitra.field_key_unique'),
                'configuration.field_type.required' => __('solarmitra::solarmitra.field_type_required'),
                'configuration.options_json.json' => __('solarmitra::solarmitra.options_json_invalid'),
                'configuration.validation_rules_json.json' => __('solarmitra::solarmitra.validation_rules_json_invalid'),
            ];


            $validator = \Validator::make($request->all(), $validation,$validationMsg);
            
            if ($request->ajax() && $validator->fails()) 
            {
                return response()->json(['errors' => $validator->errors()], 422);
            }else{
                $this->validate($request, $validation,$validationMsg);
            }

            $config_master = ConfigMaster::where('id' , $id)->update($request->configuration);

            if ($request->ajax()) 
            {
                return response()->json([
                    'status' => true,
                    'message' => __('solarmitra::solarmitra.config_update_success'),
                    'reload' => true,
                ]);
            }
            
            return redirect()->route('admin.solarmitra.config_master.index')->with('success', __('solarmitra::solarmitra.config_update_success'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $business = Business::findorFail($id);
        if($business->delete()) 
        {
            return redirect()->back()->with('success', __('solarmitra::solarmitra.business_delete_success'));
        } else {
            return redirect()->back()->with('error', __('solarmitra::solarmitra.problem_in_form_submition'));
        }
    }

}
