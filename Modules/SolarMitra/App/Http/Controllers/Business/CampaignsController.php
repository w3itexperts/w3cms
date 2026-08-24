<?php

namespace Modules\SolarMitra\App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\SolarMitra\App\Models\Campaign;
use Modules\SolarMitra\App\Models\Channel;
use Modules\SolarMitra\App\Models\Source;
use App\Models\Notification;
use Carbon\Carbon;

class CampaignsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page_title = __('solarmitra::solarmitra.campaigns');
        $channels = Channel::visibleToBusiness()->active()->pluck('title','id')->toArray();
        $sources = Source::visibleToBusiness()->active()->pluck('name','id')->toArray();

        $baseQuery = Campaign::query()->where('business_id', app('currentBusinessId'))
                    ->when($request->filled('purpose'), function ($query) use ($request) {
                        $query->where('purpose','Like', '%'.$request->purpose.'%');
                    })
                    ->when($request->filled('channel_id'), function ($query) use ($request) {
                        $query->whereIn('channel_id', $request->channel_id);
                    })
                    ->when($request->filled('source_id'), function ($query) use ($request) {
                        $query->whereIn('source_id', $request->source_id);
                    });
        $campaigns = $baseQuery->paginate(config('Reading.nodes_per_page'));
        return view('solarmitra::business.campaigns.index',compact('page_title','campaigns','channels','sources'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $page_title = __('solarmitra::solarmitra.create_campaign');
        $channels = Channel::visibleToBusiness()->active()->pluck('title','id')->toArray();
        $sources = Source::visibleToBusiness()->active()->pluck('name','id')->toArray();

        if ($request->ajax()) {
            return view('solarmitra::business.campaigns.modal',compact('page_title','channels','sources'));
        }

        return view('solarmitra::business.campaigns.create',compact('page_title','channels','sources'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = [
            'purpose'  => 'required',
            'channel_id'  => 'required',
            'source_id'  => 'required',
        ];

        $messages = [
            'purpose.required' => __('solarmitra::solarmitra.purpose_required'),
            'channel_id.required' => __('solarmitra::solarmitra.please_select_channel'),
            'source_id.required' => __('solarmitra::solarmitra.please_select_source'),
        ];

        $validator = \Validator::make($request->all(), $validation,$messages);
        
        if ($request->ajax() && $validator->fails()) 
        {
            return response()->json(['errors' => $validator->errors()], 422);
        }else{
            $this->validate($request, $validation,$messages);
        }
        
        $campaignObj = new Campaign(); 
        $campaignObj->business_id   = app('currentBusinessId');
        $campaignObj->purpose       = $request->purpose;
        $campaignObj->channel_id    = $request->channel_id;
        $campaignObj->source_id     = $request->source_id;
        $campaignObj->start_at      = $request->start_at ?? Carbon::today();
        $campaignObj->end_at        = $request->end_at ?? Carbon::today();
        $campaignObj->status        = $request->status ?? 1;
        $campaignObj->created_by    = auth('business')->id();

        $res = $campaignObj->save();

        if ($res) {

            /* Send Event Notification */
            $notificationObj        = new Notification();
            $notificationObj->notification_entry('CAMPAIGN-ANC', $campaignObj->id, auth('business')->id(), config('constants.superadmin'));
            /* End Send Event Notification */

            if ($request->ajax()) {
                return response()->json(['status' => true,'reload' => true,'message' => __('solarmitra::solarmitra.campaign_created_text')]);
            }
            return redirect()->route('business.solarmitra.campaigns.index');
        }

        return redirect()->back()->with('error', __('solarmitra::solarmitra.something_went_wrong'));
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('solarmitra::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request,$id)
    {
        
        $page_title = __('solarmitra::solarmitra.edit_campaign');
        $channels = Channel::visibleToBusiness()->active()->pluck('title','id')->toArray();
        $sources = Source::visibleToBusiness()->active()->pluck('name','id')->toArray();
        $campaign = Campaign::findOrFail($id);

        if ($request->ajax()) {
            return view('solarmitra::business.campaigns.modal',compact('page_title','channels','sources','campaign'));
        }

        return view('solarmitra::business.campaigns.edit',compact('page_title','channels','sources','campaign'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validation = [
            'purpose'  => 'required',
            'channel_id'  => 'required',
            'source_id'  => 'required',
        ];

        $messages = [
            'purpose.required' => __('solarmitra::solarmitra.purpose_required'),
            'channel_id.required' => __('solarmitra::solarmitra.please_select_channel'),
            'source_id.required' => __('solarmitra::solarmitra.please_select_source'),
        ];

        $validator = \Validator::make($request->all(), $validation, $messages);
        
        if ($request->ajax() && $validator->fails()) 
        {
            return response()->json(['errors' => $validator->errors()], 422);
        }else{
            $this->validate($request, $validation, $messages);
        }
        
        $campaignObj = Campaign::findOrFail($id); 
        $campaignObj->business_id   = app('currentBusinessId');
        $campaignObj->purpose       = $request->purpose;
        $campaignObj->channel_id    = $request->channel_id;
        $campaignObj->source_id     = $request->source_id;
        $campaignObj->start_at      = $request->start_at ?? Carbon::today();
        $campaignObj->end_at        = $request->end_at ?? Carbon::today();
        $campaignObj->status        = $request->status ?? 1;

        $res = $campaignObj->save();

        if ($res) {
            
            /* Send Event Notification */
            $notificationObj        = new Notification();
            $notificationObj->notification_entry('CAMPAIGN-UC', $campaignObj->id, auth('business')->id(), config('constants.superadmin'));
            /* End Send Event Notification */

            if ($request->ajax()) {
                return response()->json(['status' => true,'reload' => true,'message' => __('solarmitra::solarmitra.campaign_created_text')]);
            }
            return redirect()->route('business.solarmitra.campaigns.index');
        }

        return redirect()->back()->with('error', __('solarmitra::solarmitra.something_went_wrong'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $campaign = Campaign::findOrFail($id);
        
        /* Send Event Notification */
        $notificationObj        = new Notification();
        $notificationObj->notification_entry('CAMPAIGN-DC', $campaign->id, auth('business')->id(), config('constants.superadmin'));
        /* End Send Event Notification */

        $campaign->delete();
        return redirect()->back()->with('success', __('solarmitra::solarmitra.campaign_deleted_text'));
    }
}
