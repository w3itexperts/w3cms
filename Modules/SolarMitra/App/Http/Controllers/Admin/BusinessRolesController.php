<?php

namespace Modules\SolarMitra\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\SolarMitra\App\Models\BusinessRole;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BusinessRolesController extends Controller
{
    public function index(Request $request)
    {

        $page_title = __('solarmitra::solarmitra.business_roles');
        $business_roles = BusinessRole::where('role_type','Business')->paginate(config('Reading.nodes_per_page'));
        
        return view('solarmitra::admin.roles.index',compact('page_title','business_roles'));

    }

    public function create(Request $request)
    {

        $page_title = __('solarmitra::solarmitra.create').' '.__('solarmitra::solarmitra.business_role');
        $business_roles = BusinessRole::get();
        if ($request->ajax()) {
            return view('solarmitra::admin.roles.modal',compact('page_title','business_roles'));
        }

    }

    public function store(Request $request)
    {

        $validation = [
            'name'  => 'required',
            'role_type'  => 'required',
        ];

        $validator = \Validator::make($request->all(), $validation);
        
        if ($request->ajax() && $validator->fails()) 
        {
            return response()->json(['errors' => $validator->errors()], 422);
        }else{
            $this->validate($request, $validation);
        }
        
        $businessRoleObj = new BusinessRole(); 
        $businessRoleObj->guard_name           = 'business'; 
        $businessRoleObj->parent_id             = $request->parent_id; 
        $businessRoleObj->name             = $request->name;
        $businessRoleObj->role_type             = $request->role_type; 
        $businessRoleObj->description           = $request->description; 
        $businessRoleObj->level             = $request->level ?? 0; 
        $businessRoleObj->status                = $request->status ?? 1; 
        $res = $businessRoleObj->save();

        if ($res) {

            if ($request->ajax()) {
                return response()->json(['status' => true,'reload' => true,'message' => __('solarmitra::solarmitra.business_role_created_text')]);
            }
            return redirect()->route('admin.solarmitra.business_roles.index');
        }

        return redirect()->back()->with('error', __('solarmitra::solarmitra.something_went_wrong'));

    }

    public function edit(Request $request,$id)
    {

        $page_title = __('solarmitra::solarmitra.create').' '.__('solarmitra::solarmitra.business_role');
        $business_roles = BusinessRole::get();
        $business_role = BusinessRole::find($id);
        if ($request->ajax()) {
            return view('solarmitra::admin.roles.modal',compact('page_title','business_role','business_roles'));
        }

    }

    public function update(Request $request,$id)
    {
        $validation = [
            'name'  => 'required',
            'role_type'  => 'required',
        ];

        $validator = \Validator::make($request->all(), $validation);
        
        if ($request->ajax() && $validator->fails()) 
        {
            return response()->json(['errors' => $validator->errors()], 422);
        }else{
            $this->validate($request, $validation);
        }

        $businessRoleObj = BusinessRole::findOrFail($id); 
        $businessRoleObj->guard_name           = 'business'; 
        $businessRoleObj->parent_id             = $request->parent_id; 
        $businessRoleObj->name             = $request->name;
        $businessRoleObj->role_type             = $request->role_type; 
        $businessRoleObj->description           = $request->description; 
        $businessRoleObj->level                 = $request->level ?? 0; 
        $businessRoleObj->status                = $request->status ?? 1; 
        $res = $businessRoleObj->save();

        if ($res) {


            if ($request->ajax()) {
                return response()->json(['status' => true,'reload' => true,'message' => __('solarmitra::solarmitra.business_role_updated_text')]);
            }
            return redirect()->route('admin.solarmitra.business_roles.index')->with('success', __('solarmitra::solarmitra.business_role_updated_text'));
        }

        return redirect()->back()->with('error', __('solarmitra::solarmitra.something_went_wrong'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $BusinessRole = BusinessRole::findOrFail($id);
        $BusinessRole->delete();
        return redirect()->back()->with('success', __('solarmitra::solarmitra.business_role_deleted_text'));
    }
    
}
