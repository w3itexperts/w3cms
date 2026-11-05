<?php

namespace Modules\SolarMitra\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\SolarMitra\App\Models\ProjectPhase;

class ProjectsController extends Controller
{

    /**
     * Remove the specified resource from storage.
     */
    public function project_phases(Request $request,$id=null)
    {
        $page_title = __('solarmitra::solarmitra.project_phases');

        $projectPhaseObj       = ProjectPhase::firstOrNew(['id' =>  $id]);
        $project_phases       = ProjectPhase::paginate(config('Reading.nodes_per_page'));

        if($request->isMethod('post'))
        {

            $validation = [
                'title'             => 'required',
            ];

            $validationMsg = [
                'title.required'    => __('solarmitra::solarmitra.title_required'),
            ];

            $this->validate($request, $validation,$validationMsg);

                
            $projectPhaseObj->title           = $request->title;
            $projectPhaseObj->description    = $request->description;
            $res                        = $projectPhaseObj->save();

            if($res)
            {
                /* Send Event Notification */
                if (!$projectPhaseObj->wasRecentlyCreated) {
                    $notificationObj        = new Notification();
                    $notificationObj->notification_entry('PROJECTPHASE-UPP', $projectPhaseObj->id, auth()->id(), config('constants.superadmin'));
                    /* End Send Event Notification */
                }else{
                    $notificationObj        = new Notification();
                    $notificationObj->notification_entry('PROJECTPHASE-ANPP', $projectPhaseObj->id, auth()->id(), config('constants.superadmin'));
                }
                /* End Send Event Notification */

                if ($projectPhaseObj->exists) {
                    return redirect()->route('admin.solarmitra.projects.project_phases')->with('success', __('solarmitra::solarmitra.project_phases_saved_text'));
                }
                return redirect()->back()->with('success', __('solarmitra::solarmitra.project_phases_saved_text'));
            }
            return redirect()->back()->with('error', __('solarmitra::solarmitra.something_went_wrong'));
        }
        return view('solarmitra::admin.projects.project_phases',compact('page_title','projectPhaseObj','project_phases'));
    }

    public function destory_project_phase($id)
    {
        $ProjectPhase = ProjectPhase::findOrFail($id);

        /* Send Event Notification */
        $notificationObj        = new Notification();
        $notificationObj->notification_entry('PROJECTPHASE-DPP', $ProjectPhase->id, auth()->id(), config('constants.superadmin'));
        /* End Send Event Notification */

        $ProjectPhase->delete();

        if(request()->ajax())
        {
            return response()->json(['status' => true,'message' => __('solarmitra::solarmitra.project_phase_deleted_text')]);
        }
        return redirect()->back()->with('success', __('solarmitra::solarmitra.project_phase_deleted_text'));
    }

    public function project_phases_view(Request $request,$id=null)
    {
        $page_title = __('solarmitra::solarmitra.project_phases');

        $project_phases       = ProjectPhase::paginate(config('Reading.nodes_per_page'));

        return view('solarmitra::admin.projects.project_phases_view',compact('page_title','project_phases'));
    }
}
