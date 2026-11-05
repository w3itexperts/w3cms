<?php

namespace Modules\SolarMitra\App\Http\Controllers\Business;

use Modules\SolarMitra\App\Models\Campaign;
use Modules\SolarMitra\App\Models\CampaignTag;
use Modules\SolarMitra\App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CampaignTagsController extends Controller
{
    public function index(Request $request, Campaign $campaign)
    {
        $page_title = __('Campaign Tags');
        
        $tags = $campaign->campaignTags()
            ->with('tag')
            ->when($request->filled('tag_name'), function ($query) use ($request) {
                $query->whereHas('tag', function ($q) use ($request) {
                    $q->where('title', 'like', '%' . $request->tag_name . '%');
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

        $availableTags = Tag::orderBy('title')->pluck('title','id');

        return view('solarmitra::business.campaign_tags.index', compact('campaign', 'tags', 'availableTags', 'page_title'));
    }

    public function create(Campaign $campaign)
    {
        $availableTags = Tag::orderBy('title')->pluck('title','id');

        return view('solarmitra::business.campaign_tags.modal', compact('campaign', 'availableTags'));
    }

    public function multiDestroy(Request $request, Campaign $campaign)
    {
        $request->validate([
            'selected_tags' => 'required|array|min:1',
            'selected_tags.*' => 'integer|exists:campaign_tags,id',
        ]);

        $campaign->campaignTags()->whereIn('id', $request->selected_tags)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Tags removed from campaign successfully.',
            'reload' => true,
        ]);
    }

    public function store(Request $request, Campaign $campaign)
    {
        $request->validate([
            'tag_id' => 'required|integer|exists:tags,id',
        ]);

        $campaign->tags()->syncWithoutDetaching([$request->tag_id]);

        return response()->json([
            'status' => true,
            'message' => 'Tag added to campaign.',
            'reload' => true,
        ]);
    }

    public function destroy(Request $request, Campaign $campaign, CampaignTag $tag)
    {
        $tag->delete();

        return redirect()->back()->with('success', __('Tag removed from campaign.'));
    }
}