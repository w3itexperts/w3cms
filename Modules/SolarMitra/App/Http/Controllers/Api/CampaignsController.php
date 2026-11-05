<?php

namespace Modules\SolarMitra\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Modules\SolarMitra\App\Models\Campaign;
use Modules\SolarMitra\App\Models\CampaignActivities;
use Modules\SolarMitra\App\Models\CampaignAssignment;
use Modules\SolarMitra\App\Models\CampaignLead;
use Modules\SolarMitra\App\Models\CampaignTag;
use Modules\SolarMitra\App\Models\Source;
use Modules\SolarMitra\App\Models\Channel;
use Modules\SolarMitra\Helper\SolarMitraHelper;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\Response;

class CampaignsController extends Controller
{
    public function index(Request $request)
    {
        $businessId = app('currentBusinessId');
        
        $campaigns = Campaign::where('business_id', $businessId)
            ->when($request->filled('purpose'), function ($query) use ($request) {
                $query->where('purpose', 'like', '%' . $request->purpose . '%');
            })
            ->when($request->filled('channel_id'), function ($query) use ($request) {
                $query->whereIn('channel_id', $request->channel_id);
            })
            ->when($request->filled('source_id'), function ($query) use ($request) {
                $query->whereIn('source_id', $request->source_id);
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->whereIn('status', $request->status);
            })
            ->latest()
            ->paginate(config('Reading.nodes_per_page', 15));

        return response()->json([
            'status' => true,
            'data' => $campaigns,
        ]);
    }

    public function store(Request $request)
    {
        $validation = [
            'purpose' => 'required|string|max:255',
            'channel_id' => 'required|integer|exists:channels,id',
            'source_id' => 'required|integer|exists:sources,id',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
            'status' => 'integer|in:1,2,3,4',
        ];

        $this->validate($request, $validation);

        $campaign = Campaign::create([
            'business_id' => app('currentBusinessId'),
            'purpose' => $request->purpose,
            'channel_id' => $request->channel_id,
            'source_id' => $request->source_id,
            'start_at' => $request->start_at ?? now(),
            'end_at' => $request->end_at ?? now(),
            'status' => $request->status ?? 1,
            'created_by' => auth('api')->id(),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Campaign created successfully.',
            'data' => $campaign,
        ], 201);
    }

    public function show($id)
    {
        $campaign = Campaign::with(['activities', 'assignments.user', 'leads.lead', 'tags'])
            ->where('business_id', app('currentBusinessId'))
            ->findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $campaign,
        ]);
    }

    public function update(Request $request, $id)
    {
        $campaign = Campaign::where('business_id', app('currentBusinessId'))->findOrFail($id);

        $validation = [
            'purpose' => 'sometimes|required|string|max:255',
            'channel_id' => 'sometimes|required|integer|exists:channels,id',
            'source_id' => 'sometimes|required|integer|exists:sources,id',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
            'status' => 'sometimes|integer|in:1,2,3,4',
        ];

        $this->validate($request, $validation);

        $campaign->update($request->only(['purpose', 'channel_id', 'source_id', 'start_at', 'end_at', 'status']));

        return response()->json([
            'status' => true,
            'message' => 'Campaign updated successfully.',
            'data' => $campaign,
        ]);
    }

    public function destroy($id)
    {
        $campaign = Campaign::where('business_id', app('currentBusinessId'))->findOrFail($id);
        $campaign->delete();

        return response()->json([
            'status' => true,
            'message' => 'Campaign deleted successfully.',
        ]);
    }

    public function roi($id)
    {
        $campaign = Campaign::with('activities')->where('business_id', app('currentBusinessId'))->findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => SolarMitraHelper::getCampaignROI($id),
        ]);
    }

    public function activities($id)
    {
        $campaign = Campaign::where('business_id', app('currentBusinessId'))->findOrFail($id);

        $activities = $campaign->activities()
            ->with(['channel', 'source'])
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'data' => $activities->map(function ($a) {
                return [
                    'id' => $a->id,
                    'name' => $a->name,
                    'channel' => $a->channel?->title,
                    'source' => $a->source?->name,
                    'cost' => $a->cost,
                    'lead_count' => $a->lead_count,
                    'impression' => $a->impression,
                    'clicks' => $a->clicks,
                    'cpl' => $a->cpl,
                    'ctr' => $a->ctr,
                    'cpc' => $a->cpc,
                ];
            }),
        ]);
    }

    public function assignments($id)
    {
        $campaign = Campaign::where('business_id', app('currentBusinessId'))->findOrFail($id);

        $assignments = $campaign->assignments()
            ->with('user')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $assignments,
        ]);
    }

    public function leads($id)
    {
        $campaign = Campaign::where('business_id', app('currentBusinessId'))->findOrFail($id);

        $leads = $campaign->leads()
            ->with(['lead', 'activity', 'source', 'assignedUser'])
            ->get();

        return response()->json([
            'status' => true,
            'data' => $leads,
        ]);
    }

    public function tags($id)
    {
        $campaign = Campaign::where('business_id', app('currentBusinessId'))->findOrFail($id);

        $tags = $campaign->tags()->get();

        return response()->json([
            'status' => true,
            'data' => $tags,
        ]);
    }
}