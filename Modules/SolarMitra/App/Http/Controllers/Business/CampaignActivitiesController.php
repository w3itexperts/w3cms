<?php

namespace Modules\SolarMitra\App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Modules\SolarMitra\App\Models\Campaign;
use Modules\SolarMitra\App\Models\CampaignActivities;
use Modules\SolarMitra\App\Models\Source;
use Modules\SolarMitra\App\Models\Channel;
use Modules\SolarMitra\App\Models\CampaignLead;
use Illuminate\Http\Request;

class CampaignActivitiesController extends Controller
{
    public function index(Request $request, Campaign $campaign)
    {
        $page_title = __('Campaign Activities');
        
        $activities = $campaign->activities()
            ->with(['channel', 'source'])
            ->when($request->filled('name'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->name . '%');
            })
            ->when($request->filled('channel_id'), function ($query) use ($request) {
                $query->whereIn('channel_id', $request->channel_id);
            })
            ->when($request->filled('source_id'), function ($query) use ($request) {
                $query->whereIn('source_id', $request->source_id);
            })
            ->when($request->filled('sort_by'), function ($query) use ($request) {
                $sort = $request->sort_by;
                if ($sort === 'name_asc') $query->orderBy('name', 'asc');
                elseif ($sort === 'name_desc') $query->orderBy('name', 'desc');
                elseif ($sort === 'created_asc') $query->orderBy('created_at', 'asc');
                elseif ($sort === 'created_desc') $query->orderBy('created_at', 'desc');
                elseif ($sort === 'modified_asc') $query->orderBy('updated_at', 'asc');
                elseif ($sort === 'modified_desc') $query->orderBy('updated_at', 'desc');
            }, function ($query) {
                $query->latest();
            })
            ->paginate(config('Reading.nodes_per_page'));

        $channels = Channel::visibleToBusiness()->active()->pluck('title', 'id');
        $sources = Source::visibleToBusiness()->active()->pluck('name', 'id');
        
        if ($request->ajax()) {
            return response()->json([
                'responce_for' => 'campaign_activities',
                'CampaignActivitiesTableContent' => view('solarmitra::business.campaign_activities.list_view',compact('activities','campaign'))->render(),
            ]);
        }

        return view('solarmitra::business.campaign_activities.index', compact('campaign', 'activities', 'channels', 'sources', 'page_title'));
    }

    public function multiDestroy(Request $request, Campaign $campaign)
    {
        $request->validate([
            'selected_leads' => 'required|array|min:1',
            'selected_leads.*' => 'integer|exists:campaign_activities,id',
        ]);

        $campaign->activities()->whereIn('id', $request->selected_leads)->delete();

        return response()->json([
            'status' => true,
            'message' => __('solarmitra::solarmitra.activities_deleted_successfully'),
            'reload' => true,
        ]);
    }

    public function create(Campaign $campaign)
    {
        $channels = Channel::visibleToBusiness()->active()->pluck('title', 'id');
        $sources = Source::visibleToBusiness()->active()->pluck('name', 'id');
        
        return view('solarmitra::business.campaign_activities.modal', compact('campaign', 'channels', 'sources'));
    }

    public function store(Request $request, Campaign $campaign)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'channel_id' => 'required|exists:channels,id',
            'source_id' => 'nullable|exists:sources,id',
            'cost' => 'nullable|numeric|min:0',
            'impression' => 'nullable|integer|min:0',
            'clicks' => 'nullable|integer|min:0',
        ]);

        $activity = $campaign->activities()->create([
            'name' => $request->name,
            'channel_id' => $request->channel_id,
            'source_id' => $request->source_id,
            'cost' => $request->cost ?? 0,
            'impression' => $request->impression ?? 0,
            'clicks' => $request->clicks ?? 0,
            'lead_count' => 0,
        ]);

        if ($request->ajax()) {
            return response()->json(['status' => true, 'message' => __('solarmitra::solarmitra.activity_added_successfully'),'reload' => true]);
        }
        return redirect()->back()->with('success', __('solarmitra::solarmitra.activity_added_successfully'));
    }

    public function edit(Campaign $campaign, CampaignActivities $activity)
    {
        $channels = Channel::visibleToBusiness()->active()->pluck('title', 'id');
        $sources = Source::visibleToBusiness()->active()->pluck('name', 'id');
        
        return view('solarmitra::business.campaign_activities.modal', compact('campaign', 'activity', 'channels', 'sources'));
    }

    public function update(Request $request, Campaign $campaign, CampaignActivities $activity)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'channel_id' => 'required|exists:channels,id',
            'source_id' => 'nullable|exists:sources,id',
            'cost' => 'nullable|numeric|min:0',
            'impression' => 'nullable|integer|min:0',
            'clicks' => 'nullable|integer|min:0',
        ]);

        $activity->update($request->only(['name', 'channel_id', 'source_id', 'cost', 'impression', 'clicks']));
        if ($request->ajax()) {
            return response()->json(['status' => true,'message' => __('solarmitra::solarmitra.activity_updated_successfully'),'reload' => true]);
        }
        return redirect()->back()->with('success', __('solarmitra::solarmitra.activity_updated_successfully'));
    }

    public function destroy(Campaign $campaign, CampaignActivities $activity)
    {
        $activity->delete();
        if (request()->ajax()) {
            return response()->json(['status' => true, 'message' => __('solarmitra::solarmitra.activity_deleted'),'reload' => true]);
        }
        return redirect()->back()->with('success', __('solarmitra::solarmitra.activity_deleted'));
    }

    public function syncLeadCount(Campaign $campaign)
    {
        $campaign->activities()->each(function ($activity) {
            $count = CampaignLead::where('campaign_activity_id', $activity->id)->count();
            $activity->update(['lead_count' => $count]);
        });

        return response()->json(['status' => true, 'message' => __('solarmitra::solarmitra.lead_counts_synced')]);
    }
}