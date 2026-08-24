<?php

namespace Modules\SolarMitra\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\SolarMitra\App\Models\Source;
use Modules\SolarMitra\App\Models\Lead;
use Modules\SolarMitra\App\Models\ClientGroup;
use Modules\SolarMitra\App\Models\LeadStage;
use Modules\SolarMitra\App\Models\LeadAddress;
use Modules\SolarMitra\App\Models\Address;
use Modules\SolarMitra\App\Models\LeadFollowUp;
use Modules\CustomField\Entities\CustomField;
use Modules\SolarMitra\Helper\SolarMitraHelper;
use Illuminate\Validation\Rule;
use Modules\SolarMitra\App\Models\LeadFollowUpLog;
use Carbon\Carbon;
use DB;

class LeadsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       
        $perPage = $request->query('per_page', config('Reading.nodes_per_page'));
        $businessId = app('currentBusinessId');
        
        $leads = Lead::where('business_id', $businessId)->with('address','last_follow_up.assigned_user','source','lead_stage','added_by_user','follow_ups.followup_logs')
            
            ->when(optional(auth()->user())->id && !auth()->user()->hasRole('Business'), function ($query) use ($request) {
                $query->where('lead_added_by_id', optional(auth()->user())->id);
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->query('search'); 
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', '%' . $search . '%')
                        ->orWhere('last_name', 'like', '%' . $search . '%')
                        ->orWhere('phone', 'like', '%' . $search . '%');
                });
            })
            ->when($request->filled('added_by'), function ($query) use ($request) {
                $added_by = $request->query('added_by');
                $query->where('lead_added_by_id', $added_by);
            })
            ->when($request->filled('lead_stage_id'), function ($query) use ($request) {
                $lead_stage_id = $request->query('lead_stage_id');
                $query->where('lead_stage_id', $lead_stage_id);
            })
            ->when(!empty($request->assigned_to), function ($q) use ($request) {
                    $q->whereHas('follow_ups', function ($query) use ($request) {
                        $query->where('assigned_to', $request->assigned_to);
                    });
                })
            ->when($request->filled('date_from'), function ($query) use ($request) {
                $query->whereDate('created_at', '>=', $request->date_from);
            })
            ->when($request->filled('date_to'), function ($query) use ($request) {
                $query->whereDate('created_at', '<=', $request->date_to);
            })
            ->latest()        
            ->paginate($perPage);

        return response()->json([
            'status'  => true,
            'data'    => $leads
        ]);
    }

    public function lead_resources(Request $request)
    {
        $businessId = app('currentBusinessId');
        $sources = Source::visibleToBusiness()->where('is_active',1)->pluck('name','id')->toArray();
        $client_groups = ClientGroup::where('business_id', $businessId)->pluck('title','id')->toArray();
        $lead_stages = LeadStage::orderBy('order', 'asc')->pluck('name','id')->toArray();

        return response()->json([
            'status'  => true,
            'data'    => [
                    'sources'       => $sources,
                    'client_groups' => $client_groups,
                    'lead_stages'   => $lead_stages,
                    'cities'    => SolarMitraHelper::getCitiesList(),
                    'states'    => SolarMitraHelper::getStatesList(),
                    'countries' => SolarMitraHelper::getCountriesList(),
                ]
        ]);
    }

    public function save_lead(Request $request,$id=null)
    {
        $validation = [
            'first_name'  => 'required',
            'lead_source_id'  => 'required',
            'address_title'  => 'required',
            'address'  => 'required',
            'email' => [
                'nullable', 'email',
                Rule::unique('leads')->where(fn($q) => $q->where('business_id', $request->business_id))->ignore($id, 'id'),
            ],
            'phone' => [
                'required','numeric','digits:10',
                Rule::unique('leads')->where(fn($q) => $q->where('business_id', $request->business_id))->ignore($id, 'id'),
            ],
            
        ];

        $messages = [
            'first_name.required' => __('solarmitra::solarmitra.first_name_is_required'),
            'lead_source_id.required' => __('solarmitra::solarmitra.please_select_a_lead_source'),
            'phone.required' => __('solarmitra::solarmitra.phone_number_is_required'),
            'phone.digits' => __('solarmitra::solarmitra.phone_number_must_be_exactly_10_digits'),
            'assigned_to.required' => __('solarmitra::solarmitra.please_assign_this_lead_to_someone'),

            'no_follow_up_reason.required_if' => __('solarmitra::solarmitra.please_provide_a_reason_for_no_follow_up'),
            'follow_up_note.required_unless' => __('solarmitra::solarmitra.follow_up_note_is_required_unless_marked_as_no_follow_up'),
        ];

        $this->validate($request, $validation,$messages);
        
        $businessId = app('currentBusinessId');
        $leadObj = Lead::firstOrNew(['id' =>  $id]);
        $leadObj->business_id           = $businessId;
        $leadObj->lead_added_by_id      = auth()->id();
        $leadObj->email                 = $request->email;
        $leadObj->phone                 = $request->phone;
        $leadObj->client_group_id       = $request->client_group_id;
        $leadObj->abbreviation          = $request->abbreviation;
        $leadObj->first_name            = $request->first_name;
        $leadObj->last_name             = $request->last_name;
        $leadObj->lead_source_id        = $request->lead_source_id;
        $leadObj->email_opt_out         = $request->email_opt_out;
        $leadObj->lead_stage_id         = $request->lead_stage_id ?? 1;
        $leadObj->potential             = $request->potential;
        $leadObj->do_not_followup       = $request->do_not_follow_up ?? 0;
        $res = $leadObj->save();
            
        if ($leadObj->wasRecentlyCreated && !empty($request->assigned_to)) 
        {    
            $leadFollowUpObj = new LeadFollowUp();
            $leadFollowUpObj->lead_id           = $leadObj->id;
            $leadFollowUpObj->assigned_to       = $request->assigned_to;
            $leadFollowUpObj->created_by        = auth('api')->id();
            
            if ($request->do_not_follow_up) {    
                $leadFollowUpObj->note              = $request->no_follow_up_reason;
                $leadFollowUpObj->date_time         = Carbon::now()->format(config('solarmitra.date_time_format'));
                $leadFollowUpObj->repeat_followup   = 1;
                $leadFollowUpObj->is_active         = 0;
                $leadFollowUpObj->save();
            }else{
                $leadFollowUpObj->is_active         = 1;
                $leadFollowUpObj->date_time         = $request->filled('follow_up_date') ? Carbon::parse($request->follow_up_date)->format(config('solarmitra.date_time_format')) : Carbon::now()->format(config('solarmitra.date_time_format'));
                $leadFollowUpObj->note              = $request->follow_up_note;
                $leadFollowUpObj->repeat_followup   = $request->repeat_followup ?? 1;
                $leadFollowUpObj->save();

                LeadFollowUpLog::create([
                    'lead_id'       => $leadObj->id,
                    'followup_id'   => $leadFollowUpObj->id,
                    'scheduled_at'  => $request->filled('follow_up_date') ? Carbon::parse($request->follow_up_date)->format(config('solarmitra.date_time_format')) : Carbon::now()->format(config('solarmitra.date_time_format')),
                    'completed_at'  => null,
                    'status'        => $leadFollowUpObj->status == 1 ? 2 : 1, // if no repeat then current log is done (1=pending, 2=done, 3=missed)
                    'remarks'       => $request->follow_up_note,
                ]);
            }
        }

        $tagIds = [];
            
        if (!empty($request->tags) && !empty(json_decode($request->tags,true))) {
            $lead_tags = array_column(json_decode($request->tags,true), 'value');
            foreach ($lead_tags as $tagTitle) {
                $tag = Tag::firstOrCreate(
                    ['title' => $tagTitle],
                    [
                        'slug' => \Str::slug($tagTitle),
                        'created_by' => auth('business')->id()
                    ]
                );

                $tagIds[] = $tag->id;
            }

            $leadObj->lead_tags()->sync($tagIds);
        }

        if ($request->city_id || $request->state_id || $request->country_id || $request->address) {
            $address = Address::updateOrCreate(
                [
                    'id' => optional($leadObj->address)->id
                ],
                [
                    'business_id'   => 0,
                    'contact_id'    => 0,
                    'project_id'    => 0,
                    'address_title' => $request->address_title,
                    'address'       => $request->address,
                    'city_id'       => $request->city_id,
                    'state_id'      => $request->state_id,
                    'country_id'    => $request->country_id,
                    'is_primary'    => 1,
                ]
            );

            LeadAddress::updateOrCreate(
                ['lead_id' => $leadObj->id],
                ['address_id' => $address->id]
            );
            
            if ($leadObj->lead_stage_id == 11) {
                $leadObj->lead_stage_id = 1;
                $leadObj->save();
            }
        }

        $leadObj->load('address');
        $leadObj->load('last_follow_up');
        $leadObj->load('source');
        $leadObj->load('lead_stage');
        $leadObj->load('added_by_user');

        return response()->json([
            'status'  => true,
            'message' => __('solarmitra::solarmitra.lead_saved_successfully'),
            'data'    => $leadObj
        ]);
    }

    public function destroy($id)
    {
        $lead = Lead::findOrFail($id);
        $lead->address()->delete();
        $lead->follow_ups()->delete();
        $lead->delete();
        
        return response()->json([
            'status'  => true,
            'message' => __('solarmitra::solarmitra.lead_deleted_text'),
        ]);
    }

    public function save_multiple(Request $request)
    {
        // Validate array structure
        $request->validate([
            'leads' => 'required|array|min:1',
            'leads.*.business_id' => 'required',
            'leads.*.first_name' => 'required|string|max:255',
            'leads.*.lead_source_id' => 'required|integer|exists:sources,id',
            'leads.*.email' => 'nullable|email',
            'leads.*.phone' => 'nullable|string|max:20',
            'leads.*.last_name' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        $lead_ids = [];
        try {

            foreach ($request->leads as $leadData) {

                $lead = new Lead();
                $lead->lead_added_by_id = auth()->id(); // or from request
                $lead->business_id      = $leadData['business_id'];
                $lead->first_name       = $leadData['first_name'];
                $lead->potential        = $leadData['potential'];
                $lead->last_name        = $leadData['last_name'] ?? null;
                $lead->email            = $leadData['email'] ?? null;
                $lead->phone            = $leadData['phone'] ?? null;
                $lead->lead_source_id   = $leadData['lead_source_id'];
                $lead->lead_stage_id    = $leadData['lead_stage_id'] ?? 11;
                $lead->save();

                $lead_ids[] = $lead->id;
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => __('solarmitra::solarmitra.leads_saved_successfully')
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function assign_lead(Request $request,$lead_id)
    {
        $validation = [
            'staff_id'  => 'required',
            'follow_up_date'  => 'required_unless:do_not_follow_up,1',
            'no_follow_up_reason'  => 'required_if:do_not_follow_up,1',
            'follow_up_note' => 'required_unless:do_not_follow_up,1',
        ];

        $validationMsg = [
            'staff_id.required' => __('solarmitra::solarmitra.please_select_a_staff_member'),
            'no_follow_up_reason.required_if' => __('solarmitra::solarmitra.please_provide_a_reason_for_no_follow_up'),
            'follow_up_note.required_unless' => __('solarmitra::solarmitra.follow_up_note_is_required_unless_marked_as_no_follow_up'),
        ];

        $request->validate($validation,$validationMsg);
        

        $lead = Lead::with('last_follow_up','last_followup_log','follow_ups')->find($lead_id);
            

        $lastFollowUp = $lead->last_follow_up;
        $lastFollowUpLog = $lead->last_followup_log;

        
        if ($request->do_not_follow_up) 
        {
            $lead->update(['do_not_followup' => 1]);
            optional($lastFollowUp)->update(['is_active' => 0,'note' => $request->no_follow_up_reason]);
            optional($lastFollowUpLog)->update(['status' => 4]);

        }else{

            $isChanged = !$lastFollowUp ||
            $lastFollowUp->repeat_followup != $request->repeat_followup ||
            $lastFollowUp->assigned_to != $request->staff_id;
            $request_follow_up_date = $request->filled('follow_up_date') ? Carbon::parse($request->follow_up_date)->format(config('solarmitra.date_time_format')) : Carbon::now()->format(config('solarmitra.date_time_format'));

            if ($isChanged) {

                $lead->follow_ups()->update(['is_active' => 0]);
                optional($lastFollowUpLog)->update(['status' => 4,'completed_at' => now()->format(config('solarmitra.date_time_format'))]);

                $newFollowUp = LeadFollowUp::create([
                    'lead_id'         => $lead_id,
                    'assigned_to'     => $request->staff_id,
                    'repeat_followup' => $request->repeat_followup,
                    'date_time'       => $request_follow_up_date,
                    'is_active'       => 1,
                    'note'            => $request->follow_up_note,
                    'created_by'      => auth('business')->id(),
                ]);

                $followupId = $newFollowUp->id;

            } else {
                optional($lastFollowUpLog)->update(['status' => 4,'completed_at' => now()->format(config('solarmitra.date_time_format'))]);
                optional($lastFollowUp)->update(['note'=>$request->follow_up_note,'date_time' => $request_follow_up_date]);
                $followupId = $lastFollowUp->id;
            }

            LeadFollowUpLog::create([
                'lead_id'      => $lead_id,
                'followup_id'  => $followupId,
                'scheduled_at' => $request_follow_up_date ?? now()->format(config('solarmitra.date_time_format')),
                'status'       => 1,
                'remarks'      => $request->follow_up_note
            ]);
        }

        $lead->load('follow_ups.followup_logs');

        return response()->json(['status' => true,'message' => __('solarmitra::solarmitra.lead_follow_up_saved_successfully'),'data' => $lead]);
    }

}
