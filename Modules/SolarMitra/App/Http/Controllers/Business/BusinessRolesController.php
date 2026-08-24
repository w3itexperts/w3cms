<?php

namespace Modules\SolarMitra\App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Modules\SolarMitra\App\Models\BusinessRole;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BusinessRolesController extends Controller
{

    public function dashboard(Request $request)
    {

        $page_title = __('solarmitra::solarmitra.roles_dashboard');
        
        return view('solarmitra::business.roles.dashboard',compact('page_title'));

    }

    public function index(Request $request)
    {

        $page_title = __('solarmitra::solarmitra.business_roles');
        
        $businessRoles = BusinessRole::withoutGlobalScope('active')->when($request->filled('name'), function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->name . '%');
        })
        ->get();

        $business_roles    = $this->paginate(collect($this->flattenRoles($businessRoles)), config('Reading.nodes_per_page'));

        return view('solarmitra::business.roles.index',compact('page_title','business_roles'));

    }

    public function create(Request $request)
    {

        $page_title = __('solarmitra::solarmitra.create').' '.__('solarmitra::solarmitra.business_role');
        $staff_role = BusinessRole::where('name','Business Staff')->first();
        $business_roles = array_column((new BusinessRole)->generateCategoryTreeArray(optional($staff_role)->id, "- ", ['id', 'name']), 'name', 'id');
        if ($request->ajax()) {
            return view('solarmitra::business.roles.modal',compact('page_title','business_roles'));
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
        $staff_role = BusinessRole::where('name','Business Staff')->first();
        
        $businessRoleObj = new BusinessRole(); 
        $businessRoleObj->business_id           = $request->business_id ?? null; 
        $businessRoleObj->guard_name           = 'business'; 
        $businessRoleObj->parent_id             = $request->parent_id ?? optional($staff_role)->id; 
        $businessRoleObj->name             = $request->name;
        $businessRoleObj->role_type             = $request->role_type; 
        $businessRoleObj->description           = $request->description; 
        $businessRoleObj->level             = $request->level ?? 0; 
        $businessRoleObj->status                = $request->status ?? 1; 
        $res = $businessRoleObj->save();

        if ($res) {

            if ($request->ajax()) {
                return response()->json(['status' => true,'redirect' => route('business.solarmitra.business_roles.index'),'message' => __('solarmitra::solarmitra.business_role_created_text')]);
            }
            return redirect()->route('business.solarmitra.business_roles.index');
        }

        return redirect()->back()->with('error', __('solarmitra::solarmitra.something_went_wrong'));

    }

    public function edit(Request $request,$id)
    {

        $page_title = __('solarmitra::solarmitra.create').' '.__('solarmitra::solarmitra.business_role');
        $staff_role = BusinessRole::where('name','Business Staff')->first();
        $business_roles = array_column((new BusinessRole)->generateCategoryTreeArray(optional($staff_role)->id, "- ", ['id', 'name']), 'name', 'id');
        
        if (isset($business_roles[$id])) unset($business_roles[$id]) ;

        $business_role = BusinessRole::withoutGlobalScope('active')->find($id);
        if ($request->ajax()) {
            return view('solarmitra::business.roles.modal',compact('page_title','business_role','business_roles'));
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

        $staff_role = BusinessRole::where('name','Business Staff')->first();
        $businessRoleObj = BusinessRole::withoutGlobalScope('active')->findOrFail($id); 
        $businessRoleObj->guard_name           = 'business'; 
        $businessRoleObj->parent_id             = $request->parent_id ?? optional($staff_role)->id; 
        $businessRoleObj->name                  = $request->name;
        $businessRoleObj->role_type             = $request->role_type; 
        $businessRoleObj->description           = $request->description; 
        $businessRoleObj->level                 = $request->level ?? 0; 
        $businessRoleObj->status                = $request->status ?? 1; 
        $res = $businessRoleObj->save();

        if ($res) {


            if ($request->ajax()) {
                return response()->json(['status' => true,'redirect' => route('business.solarmitra.business_roles.index'),'message' => __('solarmitra::solarmitra.business_role_updated_text')]);
            }
            return redirect()->route('business.solarmitra.business_roles.index')->with('success', __('solarmitra::solarmitra.business_role_updated_text'));
        }

        return redirect()->back()->with('error', __('solarmitra::solarmitra.something_went_wrong'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $BusinessRole = BusinessRole::withoutGlobalScope('active')->findOrFail($id);


        $BusinessRole->delete();
        return redirect()->back()->with('success', __('solarmitra::solarmitra.business_role_deleted_text'));
    }

    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        $options =  array(
                        'path' => LengthAwarePaginator::resolveCurrentPath(),
                        'pageName' => 'page',
                    );
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    private function flattenRoles($roles, $parentId = null, $level = 0, &$result = [])
    {
        $children = $roles->where('parent_id', $parentId);

        foreach ($children as $role) {
            $role->name = str_repeat('- ', $level) . $role->name;
            $result[] = $role;

            $this->flattenRoles($roles, $role->id, $level + 1, $result);
        }

        return $result;
    }


    
}
