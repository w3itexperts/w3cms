<?php

namespace Modules\SolarMitra\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\SolarMitra\App\Models\MaterialLibrary;
use Modules\SolarMitra\App\Models\MaterialUnit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MaterialUnitsController extends Controller
{
    public function list(Request $request, $id=null)
    {

        $page_title = __('solarmitra::solarmitra.material_unit');

        $materialUnitObj       = MaterialUnit::firstOrNew(['id' =>  $id]);
        $material_units       = MaterialUnit::when(!empty($request->search),function($q)use($request){
                                    $q->where('title','Like','%'.$request->search.'%');
                                })->paginate(config('Reading.nodes_per_page'));

        if($request->isMethod('post'))
        {

            $validation = [
                'title'             => 'required',
            ];

            $validationMsg = [
                'title.required'    => __('solarmitra::solarmitra.title_required'),
            ];

            $this->validate($request, $validation,$validationMsg);

                
            $materialUnitObj->title          = $request->title;
            $res                        = $materialUnitObj->save();

            if($res)
            {
                if (!$materialUnitObj->wasRecentlyCreated) {
                    $notificationObj        = new Notification();
                    $notificationObj->notification_entry('MATERIALUNIT-UMU', $materialUnitObj->id, auth()->id(), config('constants.superadmin'));
                }else{
                    $notificationObj        = new Notification();
                    $notificationObj->notification_entry('MATERIALUNIT-ANMU', $materialUnitObj->id, auth()->id(), config('constants.superadmin'));
                }

                if ($materialUnitObj->exists) {
                    return redirect()->route('admin.solarmitra.material_units.list')->with('success', __('solarmitra::solarmitra.material_unit_saved_successfully'));
                }
                return redirect()->back()->with('success', __('solarmitra::solarmitra.material_unit_saved_successfully'));
            }
            return redirect()->back()->with('error', __('solarmitra::solarmitra.something_went_wrong'));
        }
        return view('solarmitra::admin.materials.material_units',compact('page_title','materialUnitObj','material_units'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $materialUnit = MaterialUnit::findOrFail($id);

        /* Send Event Notification */
        $notificationObj        = new Notification();
        $notificationObj->notification_entry('MATERIALUNIT-DMU', $materialUnit->id, auth()->id(), config('constants.superadmin'));
        /* End Send Event Notification */
        
        $materialUnit->delete();
        return redirect()->back()->with('success', __('solarmitra::solarmitra.material_unit_deleted_successfully'));
    }
    
}
