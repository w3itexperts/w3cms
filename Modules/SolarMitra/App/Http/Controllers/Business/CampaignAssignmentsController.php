<?php

namespace Modules\SolarMitra\App\Http\Controllers\Business;

use Modules\SolarMitra\App\Models\Campaign;
use Modules\SolarMitra\App\Models\CampaignAssignment;
use Modules\SolarMitra\App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CampaignAssignmentsController extends Controller
{
    public function index(Request $request, Campaign $campaign)
    {
        $page_title = __('Campaign Assignments');
        $assignments = $campaign->assignments()
            ->with('user')
            ->when($request->filled('user_name'), function ($query) use ($request) {
                $query->whereHas('user', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->user_name . '%');
                });
            })
            ->when($request->filled('sort_by'), function ($query) use ($request) {
                $sort = $request->sort_by;
                if ($sort === 'name_asc') $query->orderBy('id', 'asc');
                elseif ($sort === 'name_desc') $query->orderBy('id', 'desc');
                elseif ($sort === 'created_asc') $query->orderBy('created_at', 'asc');
                elseif ($sort === 'created_desc') $query->orderBy('created_at', 'desc');
                elseif ($sort === 'modified_asc') $query->orderBy('updated_at', 'asc');
                elseif ($sort === 'modified_desc') $query->orderBy('updated_at', 'desc');
            }, function ($query) {
                $query->latest();
            })
            ->paginate(config('Reading.nodes_per_page'));

        $staff = Contact::where('business_id', app('currentBusinessId'))
            ->whereHas('staff')
            ->whereHas('user')
            ->with('user:id,name')
            ->get()
            ->pluck('user.name', 'user.id')
            ->toArray();

        if ($request->ajax()) {
            return response()->json([
                'responce_for' => 'campaign_assignments',
                'CampaignAssignmentsTableContent' => view('solarmitra::business.campaign_assignments.list_view',compact('assignments','campaign'))->render(),
            ]);
        }

        return view('solarmitra::business.campaign_assignments.index', compact('campaign', 'assignments', 'staff', 'page_title'));
    }

    public function create(Campaign $campaign)
    {
        $staff = Contact::where('business_id', app('currentBusinessId'))
            ->whereHas('staff')
            ->whereHas('user')
            ->with('user:id,name')
            ->get()
            ->pluck('user.name', 'user.id')
            ->toArray();

        return view('solarmitra::business.campaign_assignments.modal', compact('campaign', 'staff'));
    }

    public function multiDestroy(Request $request, Campaign $campaign)
    {
        $request->validate([
            'selected_leads' => 'required|array|min:1',
            'selected_leads.*' => 'integer|exists:campaign_assignments,id',
        ]);

        $campaign->assignments()->whereIn('id', $request->selected_leads)->delete();

        return response()->json([
            'status' => true,
            'message' => __('solarmitra::solarmitra.assignments_deleted_successfully'),
            'reload' => true,
        ]);
    }

    public function store(Request $request, Campaign $campaign)
    {
        $request->validate([
            'user_id' => 'required|array|min:1',
            'user_id.*' => 'integer|exists:users,id',
        ]);

        $added = 0;
        foreach ($request->user_id as $userId) {
            $assignment = $campaign->assignments()->firstOrCreate([
                'user_id' => $userId,
            ]);
            if ($assignment->wasRecentlyCreated) {
                $added++;
            }
        }

        return response()->json([
            'status' => true,
            'message' => $added . ' assignment(s) added.',
            'reload' => true,
        ]);
    }

    public function destroy(Request $request, Campaign $campaign, CampaignAssignment $assignment)
    {
        $assignment->delete();

        if ($request->ajax()) {
            return response()->json([
                'status' => true,
                'message' => __('solarmitra::solarmitra.assignment_removed'),
                'reload' => true,
            ]);
        }
        return redirect()->back()->with('success', __('solarmitra::solarmitra.assignment_removed'));
    }
}