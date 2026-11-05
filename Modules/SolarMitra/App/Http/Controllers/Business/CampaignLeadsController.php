<?php

namespace Modules\SolarMitra\App\Http\Controllers\Business;

use Modules\SolarMitra\App\Models\Campaign;
use Modules\SolarMitra\App\Models\CampaignLead;
use Modules\SolarMitra\App\Models\Lead;
use Modules\SolarMitra\App\Models\Source;
use Modules\SolarMitra\App\Models\Contact;
use Modules\SolarMitra\App\Models\CampaignActivities;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CampaignLeadsController extends Controller
{
    public function index(Request $request, Campaign $campaign)
    {
        $page_title = __('Campaign Leads');

        $leads = $campaign->leads()
            ->with(['lead', 'activity', 'source', 'assignedUser'])
            ->when($request->filled('full_name'), function ($query) use ($request) {
                $query->whereHas('lead', function ($q) use ($request) {
                    $q->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%' . $request->full_name . '%']);
                });
            })
            ->when($request->filled('campaign_activity_id'), function ($query) use ($request) {
                $query->whereIn('campaign_activity_id', $request->campaign_activity_id);
            })
            ->when($request->filled('source_id'), function ($query) use ($request) {
                $query->whereIn('source_id', $request->source_id);
            })
            ->when($request->filled('is_primary'), function ($query) use ($request) {
                $query->where('is_primary', $request->is_primary);
            })
            ->when($request->filled('assigned_user_id'), function ($query) use ($request) {
                $query->whereIn('assigned_user_id', $request->assigned_user_id);
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

        $activities = $campaign->activities()->pluck('name', 'id');
        $sources = Source::visibleToBusiness()->active()->pluck('name', 'id');

        if ($request->ajax()) {
            return response()->json([
                'responce_for' => 'campaign_leads',
                'CampaignLeadsTableContent' => view('solarmitra::business.campaign_leads.list_view',compact('leads','campaign'))->render(),
            ]);
        }

        return view('solarmitra::business.campaign_leads.index', compact('campaign', 'leads', 'activities','page_title', 'sources'));
    }

    public function create(Campaign $campaign)
    {
        $leads = Lead::where('business_id', app('currentBusinessId'))
            ->whereNotIn('id', CampaignLead::where('campaign_id', $campaign->id)->pluck('lead_id'))
            ->select('id', 'first_name', 'last_name', 'phone', 'email')
            ->get()
            ->mapWithKeys(function ($lead) {
                return [$lead->id => $lead->full_name . ' - ' . $lead->phone . ($lead->email ? ' - ' . $lead->email : '')];
            })
            ->toArray();

        $activities = $campaign->activities()->pluck('name', 'id');
        $sources = Source::visibleToBusiness()->active()->pluck('name', 'id');
        $staff = Contact::where('business_id', app('currentBusinessId'))
            ->whereHas('staff')
            ->whereHas('user')
            ->with('user:id,name')
            ->get()
            ->pluck('user.name', 'user.id')
            ->toArray();

        return view('solarmitra::business.campaign_leads.modal', compact('campaign', 'leads', 'activities', 'sources', 'staff'));
    }

    public function edit(Campaign $campaign, CampaignLead $lead)
    {
        $activities = $campaign->activities()->pluck('name', 'id');
        $sources = Source::visibleToBusiness()->active()->pluck('name', 'id');
        $staff = Contact::where('business_id', app('currentBusinessId'))
            ->whereHas('staff')
            ->whereHas('user')
            ->with('user:id,name')
            ->get()
            ->pluck('user.name', 'user.id')
            ->toArray();

        return view('solarmitra::business.campaign_leads.modal', compact('campaign', 'lead', 'activities', 'sources', 'staff'));
    }

    public function multiDestroy(Request $request, Campaign $campaign)
    {
        $request->validate([
            'selected_leads' => 'required|array|min:1',
            'selected_leads.*' => 'integer|exists:campaign_leads,id',
        ]);

        $campaign->leads()->whereIn('id', $request->selected_leads)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Leads removed from campaign successfully.',
            'reload' => true,
        ]);
    }

    public function store(Request $request, Campaign $campaign)
    {
        $request->validate([
            'lead_id' => 'required|array|min:1',
            'lead_id.*' => 'integer|exists:leads,id',
            'campaign_activity_id' => 'nullable|integer|exists:campaign_activities,id',
            'source_id' => 'nullable|integer|exists:sources,id',
            'assigned_user_id' => 'nullable|integer|exists:users,id',
            'is_primary' => 'boolean',
        ]);

        $added = 0;
        foreach ($request->lead_id as $leadId) {
            if ($request->is_primary) {
                CampaignLead::where('lead_id', $leadId)->where('is_primary', true)->update(['is_primary' => false]);
            }

            $lead = CampaignLead::firstOrCreate([
                'campaign_id' => $campaign->id,
                'lead_id' => $leadId,
            ], [
                'campaign_activity_id' => $request->campaign_activity_id,
                'source_id' => $request->source_id,
                'assigned_user_id' => $request->assigned_user_id ?? auth('business')->id(),
                'is_primary' => $request->is_primary ?? false,
                'created_by' => auth('business')->id(),
            ]);

            if ($lead->wasRecentlyCreated) {
                $added++;
            }
        }

        return response()->json([
            'status' => true,
            'message' => $added . ' lead(s) assigned to campaign.',
            'reload' => true,
        ]);
    }

    public function update(Request $request, Campaign $campaign, CampaignLead $lead)
    {
        $request->validate([
            'campaign_activity_id' => 'nullable|integer|exists:campaign_activities,id',
            'source_id' => 'nullable|integer|exists:sources,id',
            'assigned_user_id' => 'nullable|integer|exists:users,id',
            'is_primary' => 'boolean',
        ]);

        if ($request->is_primary) {
             CampaignLead::where('lead_id', $lead->lead_id)
                 ->where('id', '!=', $lead->id)
                 ->where('is_primary', true)
                 ->update(['is_primary' => false]);
         }

        $lead->update($request->only(['campaign_activity_id', 'source_id', 'assigned_user_id', 'is_primary']));

        return response()->json([
            'status' => true,
            'message' => 'Lead updated successfully.',
            'reload' => true,
        ]);
    }

    public function destroy(Request $request, Campaign $campaign, CampaignLead $lead)
    {
        $lead->delete();

        return response()->json([
            'status' => true,
            'message' => 'Lead removed from campaign.',
            'reload' => true,
        ]);
    }

    public function bulkAssign(Request $request, Campaign $campaign)
    {
        $request->validate([
            'selected_leads' => 'required|array|min:1',
            'selected_leads.*' => 'integer|exists:leads,id',
            'campaign_activity_id' => 'nullable|integer|exists:campaign_activities,id',
            'source_id' => 'nullable|integer|exists:sources,id',
            'assigned_user_id' => 'nullable|integer|exists:users,id',
            'is_primary' => 'boolean',
        ]);

        $added = 0;
        foreach ($request->selected_leads as $leadId) {
            if ($request->is_primary) {
                CampaignLead::where('lead_id', $leadId)->where('is_primary', true)->update(['is_primary' => false]);
            }

            $lead = CampaignLead::firstOrCreate([
                'campaign_id' => $campaign->id,
                'lead_id' => $leadId,
            ], [
                'campaign_activity_id' => $request->campaign_activity_id,
                'source_id' => $request->source_id,
                'assigned_user_id' => $request->assigned_user_id ?? auth('business')->id(),
                'is_primary' => $request->is_primary ?? false,
                'created_by' => auth('business')->id(),
            ]);

            if ($lead->wasRecentlyCreated) {
                $added++;
            }
        }

        return response()->json([
            'status' => true,
            'message' => $added . ' lead(s) assigned to campaign.',
            'reload' => true,
        ]);
    }
}