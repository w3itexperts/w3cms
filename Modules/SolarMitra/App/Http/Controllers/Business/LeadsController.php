<?php

namespace Modules\SolarMitra\App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\SolarMitra\App\Models\Lead;
use Modules\SolarMitra\App\Models\Source;
use Modules\SolarMitra\App\Models\Channel;
use Modules\SolarMitra\App\Models\ClientGroup;
use Modules\SolarMitra\App\Models\LeadStage;
use Modules\SolarMitra\App\Models\LeadAddress;
use Modules\SolarMitra\App\Models\Address;
use Modules\SolarMitra\App\Models\LeadFollowUp;
use Modules\SolarMitra\App\Models\LeadFollowUpLog;
use Modules\SolarMitra\App\Models\Tag;
use Carbon\Carbon;
use Modules\CustomField\Entities\CustomField;
use Modules\SolarMitra\Helper\SolarMitraHelper;
use Maatwebsite\Excel\Facades\Excel;
use Modules\SolarMitra\Lib\LeadsExport;
use Modules\SolarMitra\Lib\LeadsImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Modules\SolarMitra\App\Models\Contact;
use App\Models\Notification;

class LeadsController extends Controller
{

    public function index(Request $request)
    {
        $page_title = __('solarmitra::solarmitra.leads');
        $sources = Source::visibleToBusiness()->active()->pluck('name','id')->toArray();
        $client_groups = ClientGroup::where('business_id', app('currentBusinessId'))->pluck('title','id')->toArray();
        $lead_stages = LeadStage::orderBy('order', 'asc')->pluck('name','id')->toArray();
        $staff_list = Contact::where('business_id', app('currentBusinessId'))->whereHas('staff')->whereHas('user')->with('user:id,name')->get()->pluck('user')->unique('id')->values()->toArray();
        $resQuery = Lead::query()->where('business_id',app('currentBusinessId'))
                ->when(optional(auth('business')->user())->id && !auth('business')->user()->hasRole('Business'), function ($query) use ($request) {
                    $query->where('lead_added_by_id', optional(auth('business')->user())->id);
                })
                ->when($request->filled('full_name'), function ($query) use ($request) {
                    $search = $request->full_name;
                    $query->where(function ($q) use ($search) {
                        $q->where('first_name', 'like', '%' . $search . '%')
                          ->orWhere('last_name', 'like', '%' . $search . '%');
                    });
                })
                ->when(!empty($request->filled('phone')), function ($query) use ($request) {
                    $query->where('phone', 'Like', '%'.$request->phone.'%');
                })
                ->when($request->filled('lead_added_by_id') && is_array($request->lead_added_by_id), function ($query) use ($request) {
                    $query->whereIn('lead_added_by_id', $request->lead_added_by_id);
                })
                ->when($request->filled('client_group_id') && is_array($request->client_group_id), function ($query) use ($request) {
                    $query->whereIn('client_group_id', $request->client_group_id);
                })
                ->when($request->filled('lead_stage_id') && is_array($request->lead_stage_id), function ($query) use ($request) {
                    $query->whereIn('lead_stage_id', $request->lead_stage_id);
                })
                ->when($request->filled('lead_source_id') && is_array($request->lead_source_id), function ($query) use ($request) {
                    $query->whereIn('lead_source_id', $request->lead_source_id);
                })
                ->when($request->filled('lead_potential') && is_array($request->lead_potential), function ($query) use ($request) {
                    $query->whereIn('potential', $request->lead_potential);
                })
                ->when(!empty($request->assigned_to) && is_array($request->assigned_to), function ($q) use ($request) {
                    $q->whereHas('follow_ups', function ($query) use ($request) {
                        $query->whereIn('assigned_to', $request->assigned_to);
                    });
                });

        $sortMap = [
            'name_asc'      => ['first_name', 'asc'],
            'name_desc'     => ['first_name', 'desc'],
            'created_asc'   => ['created_at', 'asc'],
            'created_desc'  => ['created_at', 'desc'],
            'modified_asc'  => ['updated_at', 'asc'],
            'modified_desc' => ['updated_at', 'desc'],
        ];

        if ($request->filled('sort_by') && isset($sortMap[$request->sort_by])) {
            [$column, $direction] = $sortMap[$request->sort_by];
            $resQuery->orderBy($column, $direction);
        }

        $leads = $resQuery->paginate(config('Reading.nodes_per_page'));

        if ($request->ajax()) {
            return response()->json([
                'responce_for' => 'leads',
                'LeadsTableContent' => view('solarmitra::business.leads.list_view',compact('page_title','leads','sources','client_groups','lead_stages','staff_list'))->render(),
                'LeadsCardsContent' => view('solarmitra::business.leads.grid_view',compact('page_title','leads','sources','client_groups','lead_stages','staff_list'))->render(),
            ]);
        }
        return view('solarmitra::business.leads.index',compact('page_title','leads','sources','client_groups','lead_stages','staff_list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $page_title =  __('solarmitra::solarmitra.create') .' '. __('solarmitra::solarmitra.lead');
        $sources = Source::visibleToBusiness()->active()->pluck('name','id')->toArray();
        $abbreviations = config('solarmitra.abbreviations');
        $client_groups = ClientGroup::where('business_id', app('currentBusinessId'))->pluck('title','id')->toArray();
        $lead_stages = LeadStage::orderBy('order', 'asc')->pluck('name','id')->toArray();
        $lead_staff = Contact::where('business_id', app('currentBusinessId'))->whereHas('staff')->whereHas('user')->with('user:id,name')->get()->pluck('user')->unique('id')->values()->toArray();
        if ($request->ajax()) {
            return view('solarmitra::business.leads.modal',compact('page_title','sources','abbreviations','client_groups','lead_stages','lead_staff'));
        }

        return view('solarmitra::business.leads.create',compact('page_title','sources','abbreviations','client_groups','lead_stages','lead_staff'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = [
            'first_name'  => 'required',
            'lead_source_id'  => 'required',
            'email' => [
                'nullable', 'email',
                Rule::unique('leads')->where(fn($q) => $q->where('business_id', app('currentBusinessId'))),
            ],
            'phone' => [
                'required','numeric','digits:10',
                Rule::unique('leads')->where(fn($q) => $q->where('business_id', app('currentBusinessId'))),
            ],
            'assigned_to'  => 'required',
            'address_title'  => 'required',
            'address'  => 'required',
            'no_follow_up_reason'  => 'required_if:do_not_follow_up,1',
            'follow_up_note' => 'required_unless:do_not_follow_up,1',
        ];

        $messages = [
            'first_name.required' => __('solarmitra::solarmitra.first_name_required'),
            'lead_source_id.required' => __('solarmitra::solarmitra.please_select_lead_source'),
            'phone.required' => __('solarmitra::solarmitra.phone_number_required'),
            'phone.digits' => __('solarmitra::solarmitra.phone_number_must_be_10_digits'),
            'assigned_to.required' => __('solarmitra::solarmitra.please_assign_lead_to_user'),

            'no_follow_up_reason.required_if' => __('solarmitra::solarmitra.please_provide_reason_no_followup'),
            'follow_up_note.required_unless' => __('solarmitra::solarmitra.followup_note_required'),
        ];

        $validator = \Validator::make($request->all(), $validation,$messages);
        
        if ($request->ajax() && $validator->fails()) 
        {
            return response()->json(['errors' => $validator->errors()], 422);
        }else{
            $this->validate($request, $validation,$messages);
        }
        
        $leadObj = new Lead(); 
        $leadObj->business_id           = app('currentBusinessId');
        $leadObj->lead_added_by_id      = $request->lead_added_by_id ?? optional(auth('business')->user())->id;
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
        $leadObj->do_not_followup             = $request->do_not_follow_up ?? 0;
        $res = $leadObj->save();
        
        $leadFollowUpObj = new LeadFollowUp();
        $leadFollowUpObj->lead_id           = $leadObj->id;
        $leadFollowUpObj->assigned_to       = $request->assigned_to;
        $leadFollowUpObj->created_by       = optional(auth('business')->user())->id;
        
        if ($request->do_not_follow_up) {    
            $leadFollowUpObj->note              = $request->no_follow_up_reason;
            $leadFollowUpObj->date_time         = \Carbon\Carbon::now()->format(config('solarmitra.date_time_format'));
            $leadFollowUpObj->repeat_followup   = 1;
            $leadFollowUpObj->is_active         = 0;
            $leadFollowUpObj->save();
        }else{
            $leadFollowUpObj->is_active         = 1;
            $leadFollowUpObj->date_time         = $request->follow_up_date;
            $leadFollowUpObj->note              = $request->follow_up_note;
            $leadFollowUpObj->repeat_followup   = $request->repeat_followup;
            $leadFollowUpObj->save();

            LeadFollowUpLog::create([
                'lead_id'       => $leadObj->id,
                'followup_id'   => $leadFollowUpObj->id,
                'scheduled_at'  => $request->follow_up_date,
                'completed_at'  => null,
                'status'        => 1, // (1=pending, 2=done, 3=missed)
                'remarks'       => $request->follow_up_note,
            ]);
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
            $AddressObj = New Address;
            $AddressObj->business_id        = 0;
            $AddressObj->contact_id         = 0;
            $AddressObj->project_id         = 0;
            $AddressObj->address_title      = $request->address_title;
            $AddressObj->address            = $request->address;
            $AddressObj->city_id            = $request->city_id;
            $AddressObj->state_id           = $request->state_id;
            $AddressObj->country_id         = $request->country_id;
            $AddressObj->is_primary         = 1;
            $AddressObj->save();

            LeadAddress::firstOrCreate(
                ['lead_id' => $leadObj->id],
                ['address_id' => $AddressObj->id]
            );
        }

        $CustomFieldObj = new CustomField();
        $CustomFieldObj->update_custom_field($request, $leadObj->id);

        if ($res) {

            /* Send Event Notification */
            $notificationObj        = new Notification();
            $notificationObj->notification_entry('LEAD-ANL', $leadObj->id, auth('business')->id(), config('constants.superadmin'));
            /* End Send Event Notification */
        
            if ($request->ajax()) {
                return response()->json(['status' => true,'reload' => true,'message' => __('solarmitra::solarmitra.lead_saved_text')]);
            }
            return redirect()->route('business.solarmitra.leads.index')->with('success', __('solarmitra::solarmitra.lead_saved_text'));
        }

        return redirect()->back()->with('error', __('solarmitra::solarmitra.something_went_wrong'));
    }

    /**
     * Show the specified resource.
     */
    public function details($id)
    {
        $lead       = Lead::with('follow_ups.followup_logs')->findOrFail($id);
        return view('solarmitra::business.leads.details',compact('lead'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request,$id)
    {
        
        $page_title = __('solarmitra::solarmitra.edit') .' '. __('solarmitra::solarmitra.lead');
        $sources = Source::visibleToBusiness()->active()->pluck('name','id')->toArray();
        $abbreviations = config('solarmitra.abbreviations');
        $client_groups = ClientGroup::where('business_id', app('currentBusinessId'))->pluck('title','id')->toArray();
        $lead_stages = LeadStage::orderBy('order', 'asc')->pluck('name','id')->toArray();
        $lead       = Lead::firstOrNew(['id' =>  $id]);
        $lead_staff = Contact::where('user_id','!=', optional(auth('business')->user())->id)->where('business_id', app('currentBusinessId'))->whereHas('staff')->whereHas('user')->with('user:id,name')->get()->pluck('user')->unique('id')->values()->toArray();

        if ($request->ajax()) {
            return view('solarmitra::business.leads.modal',compact('page_title','sources','abbreviations','lead','client_groups','lead_stages','lead_staff'));
        }

        return view('solarmitra::business.leads.edit',compact('page_title','sources','abbreviations','lead','client_groups','lead_stages','lead_staff'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validation = [
            'first_name'  => 'required',
            'lead_source_id'  => 'required',
            'email' => [
                'nullable',
                'email',
                Rule::unique('leads')->where(fn($q) => $q->where('business_id', app('currentBusinessId')))->ignore($id, 'id'),
            ],
            'phone' => [
                'required','numeric','digits:10',
                Rule::unique('leads')->where(fn($q) => $q->where('business_id', app('currentBusinessId')))->ignore($id, 'id'),
            ],
            'assigned_to'  => 'nullable',
            'no_follow_up_reason'  => 'required_if:do_not_follow_up,1',
            'follow_up_note' => [
                function ($attribute, $value, $fail) use ($request) {
                    if (
                        $request->do_not_follow_up != 1 &&
                        $request->filled('assigned_to') &&
                        empty($value)
                    ) {
                        $fail(__('solarmitra::solarmitra.followup_note_required_when_assigned'));
                    }
                },
            ],
        ];

        $messages = [
            'first_name.required' => __('solarmitra::solarmitra.first_name_required'),
            'lead_source_id.required' => __('solarmitra::solarmitra.please_select_lead_source'),
            'phone.required' => __('solarmitra::solarmitra.phone_number_required'),
            'phone.digits' => __('solarmitra::solarmitra.phone_number_must_be_10_digits'),
            'assigned_to.required' => __('solarmitra::solarmitra.please_assign_lead_to_user'),

            'no_follow_up_reason.required_if' => __('solarmitra::solarmitra.please_provide_reason_no_followup'),
            'follow_up_note.required_unless' => __('solarmitra::solarmitra.followup_note_required'),
        ];

        $validator = \Validator::make($request->all(), $validation,$messages);
        
        if ($request->ajax() && $validator->fails()) 
        {
            return response()->json(['errors' => $validator->errors()], 422);
        }else{
            $this->validate($request, $validation,$messages);
        }
        
        $leadObj = Lead::firstOrNew(['id' =>  $id]);
        $leadObj->business_id           = app('currentBusinessId');
        $leadObj->lead_added_by_id      = $request->lead_added_by_id ?? optional(auth('business')->user())->id;
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
        $leadObj->do_not_followup             = $request->do_not_follow_up ?? 0;
        $res = $leadObj->save();
        
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
        }

        $CustomFieldObj = new CustomField();
        $CustomFieldObj->update_custom_field($request, $leadObj->id);
        
        if ($res) {

            /* Send Event Notification */
            $notificationObj        = new Notification();
            $notificationObj->notification_entry('LEAD-UL', $leadObj->id, auth('business')->id(), config('constants.superadmin'));
            /* End Send Event Notification */

            if ($request->ajax()) {
                return response()->json(['status' => true,'reload' => true,'message' => __('solarmitra::solarmitra.lead_saved_text')]);
            }
            return redirect()->route('business.solarmitra.leads.index')->with('success', __('solarmitra::solarmitra.lead_saved_text'));
        }

        return redirect()->back()->with('error', __('solarmitra::solarmitra.something_went_wrong'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $lead = Lead::findOrFail($id);
        
        /* Send Event Notification */
        $notificationObj        = new Notification();
        $notificationObj->notification_entry('LEAD-DL', $lead->id, auth('business')->id(), config('constants.superadmin'));
        /* End Send Event Notification */
        
        $lead->address()->delete();
        $lead->follow_ups()->delete();
        $lead->delete();


        return redirect()->back()->with('success', __('solarmitra::solarmitra.lead_deleted_text'));
    }

    public function assign_lead(Request $request,$lead_id)
    {
        if ($request->isMethod('post')) {
            $validation = [
                'staff_id'  => 'required',
                'follow_up_date'  => 'required_unless:do_not_follow_up,1',
                'no_follow_up_reason'  => 'required_if:do_not_follow_up,1',
                'follow_up_note' => 'required_unless:do_not_follow_up,1',
            ];

            $validationMsg = [
                'staff_id.required' => __('solarmitra::solarmitra.please_select_staff_member'),
                'no_follow_up_reason.required_if' => __('solarmitra::solarmitra.please_provide_reason_no_followup'),
                'follow_up_note.required_unless' => __('solarmitra::solarmitra.followup_note_required'),
            ];

            $validator = \Validator::make($request->all(), $validation, $validationMsg);
            
            if ($request->ajax() && $validator->fails()) 
            {
                return response()->json(['errors' => $validator->errors()], 422);
            }else{
                $this->validate($request, $validation,$validationMsg);
            }
            
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
                // !$lastFollowUp->date_time->isSameDay(Carbon::parse($request->follow_up_date)) ||
                $lastFollowUp->repeat_followup != $request->repeat_followup ||
                $lastFollowUp->assigned_to != $request->staff_id;
               
                if ($isChanged) {

                    $lead->follow_ups()->update(['is_active' => 0]);
                    optional($lastFollowUpLog)->update(['status' => 4,'completed_at' => now()->format(config('solarmitra.date_time_format'))]);

                    $newFollowUp = LeadFollowUp::create([
                        'lead_id'         => $lead_id,
                        'assigned_to'     => $request->staff_id,
                        'repeat_followup' => $request->repeat_followup,
                        'date_time'       => $request->follow_up_date ?? now()->format(config('solarmitra.date_time_format')),
                        'is_active'       => 1,
                        'note'            => $request->follow_up_note,
                        'created_by'      => auth('business')->id(),
                    ]);

                    $followupId = $newFollowUp->id;

                } else {
                    optional($lastFollowUpLog)->update(['status' => 4,'completed_at' => now()->format(config('solarmitra.date_time_format'))]);
                    optional($lastFollowUp)->update(['note'=>$request->follow_up_note,'date_time' => $request->follow_up_date]);
                    $followupId = $lastFollowUp->id;
                }

                LeadFollowUpLog::create([
                    'lead_id'      => $lead_id,
                    'followup_id'  => $followupId,
                    'scheduled_at' => $request->follow_up_date ?? now()->format(config('solarmitra.date_time_format')),
                    'status'       => 1,
                    'remarks'      => $request->follow_up_note
                ]);
            }

            /* Send Event Notification */
            $notificationObj        = new Notification();
            $notificationObj->notification_entry('LEAD-AL', $lead_id, auth('business')->id(), config('constants.superadmin'));
            /* End Send Event Notification */

            if ($request->ajax()) {
                return response()->json(['status' => true,'message' => __('solarmitra::solarmitra.lead_follow_up_saved'),'close_modal' => true,'reload' => true]);
            }
            return redirect()->route('business.solarmitra.leads.index')->with('success', __('solarmitra::solarmitra.lead_follow_up_saved'));
        }

        $page_title = __('solarmitra::solarmitra.assign_and_follow_up');
        $lead = Lead::find($lead_id);
        $last_follow_up = $lead->last_follow_up;
        return view('solarmitra::business.leads.assign_lead_modal',compact('page_title','lead','last_follow_up'));
    }

    public function lead_followed(Request $request,$lead_id)
    {
        
        $lead = Lead::with(['last_follow_up', 'last_followup_log'])->findOrFail($lead_id);

        $rule = $lead->last_follow_up;
        $lastLog = $lead->last_followup_log;

        if (!$lastLog || @$lastLog->status != 1) {
            return redirect()->back()->with('error', __('solarmitra::solarmitra.no_pending_followup'));
        }

        $lastLog->status = 2;
        $lastLog->completed_at = now()->format(config('solarmitra.date_time_format'));
        $lastLog->save();

        if (!$rule || $rule->repeat_followup == 1) {
            return redirect()->back()->with('success', __('solarmitra::solarmitra.followup_completed'));
        }

        $nextDate = match ($rule->repeat_followup) {
            2 => now()->addDays(7)->format(config('solarmitra.date_time_format')),
            3 => now()->addMonth()->format(config('solarmitra.date_time_format')),
            4 => now()->addMonths(3)->format(config('solarmitra.date_time_format')),
            5 => now()->addYear()->format(config('solarmitra.date_time_format')),
            default => null,
        };

        if ($nextDate) {
            LeadFollowUpLog::create([
                'lead_id' => $lead->id,
                'followup_id' => $rule->id,
                'scheduled_at' => $nextDate,
                'status' => 1,
                'remarks' => $lastLog->remarks,
            ]);
        }

        return redirect()->back()->with('success', __('solarmitra::solarmitra.lead_followed_successfully'));

    }

    public function sources(Request $request,$id=null)
    {
        $page_title = __('solarmitra::solarmitra.sources');

        $sourceObj = Source::firstOrNew(['id' => $id]);

        if ($request->isMethod('post') && $sourceObj->exists && empty($sourceObj->business_id)) {
            return redirect()->back()->with('error', __('solarmitra::solarmitra.predefined_sources_cannot_be_edited'));
        }

        $sources = Source::visibleToBusiness()
                    ->when($request->filled('name'), function ($query) use ($request) {
                        $query->where('name', 'Like', '%'.$request->name.'%');
                    })
                    ->when($request->filled('type') && is_array(request('type')), function ($query) use ($request) {
                        $query->whereIn('type', request('type', []));
                    })
                    ->when($request->filled('channel_id') && is_array($request->channel_id), function ($query) use ($request) {
                        $query->whereIn('channel_id', $request->channel_id);
                    })
                    ->paginate(config('Reading.nodes_per_page'));

        $channels = Channel::visibleToBusiness()->where('is_active', 1)
                        ->pluck('title', 'id')->toArray();

        if ($request->isMethod('post'))
        {
            $validation = [
                'name' => 'required',
            ];

            $validationMsg = [
                'name.required' => __('solarmitra::solarmitra.name_field_required'),
            ];

            $this->validate($request, $validation, $validationMsg);

            $sourceObj->name        = $request->name;
            if (!$sourceObj->exists) {
                $sourceObj->slug    = \Str::slug($request->name);
            }
            $sourceObj->type        = $request->type;
            $sourceObj->channel_id  = $request->channel_id;
            $sourceObj->is_active   = $request->is_active;

            if (!$sourceObj->exists) {
                $sourceObj->business_id = app('currentBusinessId');
            }

            $res = $sourceObj->save();

            if ($res)
            {
                if (!$sourceObj->wasRecentlyCreated) {
                    $notificationObj = new Notification();
                    $notificationObj->notification_entry('SOURCE-US', $sourceObj->id, auth('business')->id(), config('constants.superadmin'));
                } else {
                    $notificationObj = new Notification();
                    $notificationObj->notification_entry('SOURCE-ANS', $sourceObj->id, auth('business')->id(), config('constants.superadmin'));
                }
                if ($sourceObj->exists) {
                    return redirect()->route('business.solarmitra.leads.sources')->with('success', __('solarmitra::solarmitra.source_saved_text'));
                }
                return redirect()->back()->with('success', __('solarmitra::solarmitra.source_saved_text'));
            }
            return redirect()->back()->with('error', __('solarmitra::solarmitra.something_went_wrong'));
        }
        return view('solarmitra::business.leads.sources', compact('page_title', 'sourceObj', 'sources', 'channels'));
    }

    public function destroy_source($id)
    {
        $source = Source::findOrFail($id);

        if (empty($source->business_id)) {
            return redirect()->back()->with('error', __('solarmitra::solarmitra.predefined_sources_cannot_be_deleted'));
        }

        if ($source->business_id != app('currentBusinessId')) {
            return redirect()->back()->with('error', __('solarmitra::solarmitra.cannot_delete_this_source'));
        }

        $notificationObj = new Notification();
        $notificationObj->notification_entry('SOURCE-DS', $source->id, auth('business')->id(), config('constants.superadmin'));

        $source->delete();

        return redirect()->back()->with('success', __('solarmitra::solarmitra.source_deleted_text'));
    }

    public function channels(Request $request,$id=null)
    {
        $page_title = __('solarmitra::solarmitra.channels');

        $channelObj = Channel::firstOrNew(['id' => $id]);

        if ($request->isMethod('post') && $channelObj->exists && empty($channelObj->business_id)) {
            return redirect()->back()->with('error', __('solarmitra::solarmitra.predefined_channels_cannot_be_edited'));
        }

        $channels = Channel::visibleToBusiness()
                    ->when(!empty($request->filled('search')), function ($query) use ($request) {
                        $query->where('title', 'Like', '%'.$request->search.'%');
                    })
                    ->paginate(config('Reading.nodes_per_page'));

        if ($request->isMethod('post'))
        {
            $validation = [
                'title' => 'required',
            ];

            $validationMsg = [
                'title.required' => __('solarmitra::solarmitra.title_required'),
            ];

            $this->validate($request, $validation, $validationMsg);

            $channelObj->title        = $request->title;
            if (!$channelObj->exists) {
                $channelObj->slug     = \Str::slug($request->title);
            }
            $channelObj->description  = $request->description;
            $channelObj->is_active    = $request->is_active;

            if (!$channelObj->exists) {
                $channelObj->business_id = app('currentBusinessId');
            }

            $res = $channelObj->save();

            if ($res)
            {
                if (!$channelObj->wasRecentlyCreated) {
                    $notificationObj = new Notification();
                    $notificationObj->notification_entry('CHANNEL-UC', $channelObj->id, auth('business')->id(), config('constants.superadmin'));
                } else {
                    $notificationObj = new Notification();
                    $notificationObj->notification_entry('CHANNEL-ANC', $channelObj->id, auth('business')->id(), config('constants.superadmin'));
                }

                if ($channelObj->exists) {
                    return redirect()->route('business.solarmitra.leads.channels')->with('success', __('solarmitra::solarmitra.channel_saved_text'));
                }
                return redirect()->back()->with('success', __('solarmitra::solarmitra.channel_saved_text'));
            }
            return redirect()->back()->with('error', __('solarmitra::solarmitra.something_went_wrong'));
        }
        return view('solarmitra::business.leads.channels', compact('page_title', 'channelObj', 'channels'));
    }

    public function destroy_channel($id)
    {
        $channel = Channel::findOrFail($id);

        if (empty($channel->business_id)) {
            return redirect()->back()->with('error', __('solarmitra::solarmitra.predefined_channels_cannot_be_deleted'));
        }

        if ($channel->business_id != app('currentBusinessId')) {
            return redirect()->back()->with('error', __('solarmitra::solarmitra.cannot_delete_this_channel'));
        }

        $notificationObj = new Notification();
        $notificationObj->notification_entry('CHANNEL-DC', $channel->id, auth('business')->id(), config('constants.superadmin'));

        $channel->delete();
        return redirect()->back()->with('success', __('solarmitra::solarmitra.channel_deleted_text'));
    }

    public function client_group(Request $request,$id=null)
    {
        $page_title = __('solarmitra::solarmitra.client_group');
        $customerGroupObj       = ClientGroup::firstOrNew(['id' =>  $id]);
        $customer_groups       = ClientGroup::where('business_id',app('currentBusinessId'))->get();

        if($request->isMethod('post'))
        {

            $validation = [
                'title'             => 'required|string|max:20|regex:/^[A-Za-z0-9 ]+$/',
            ];

            $validationMsg = [
                'title.required' => __('solarmitra::solarmitra.title_required'),
                'title.string' => __('solarmitra::solarmitra.title_must_be_valid_text'),
                'title.max' => __('solarmitra::solarmitra.title_max_20_chars'),
                'title.regex' => __('solarmitra::solarmitra.title_regex'),
            ];

            $validator = \Validator::make($request->all(), $validation,$validationMsg);
            if ($request->ajax() && $validator->fails()) 
            {
                return response()->json(['errors' => $validator->errors()], 422);
            }else{
                $this->validate($request, $validation,$validationMsg);
            }
                
            $customerGroupObj->title           = $request->title;
            $customerGroupObj->business_id     = $request->business_id;
            $res                        = $customerGroupObj->save();

            if($res)
            {
                if ($customerGroupObj->wasRecentlyCreated) {
                    /* Send Event Notification */
                    $notificationObj        = new Notification();
                    $notificationObj->notification_entry('CLIENTGROUP-ANCG', $customerGroupObj->id, auth('business')->id(), config('constants.superadmin'));
                    /* End Send Event Notification */
                }

                $html = '
                    <tr>
                        <td>'.($customer_groups->count() + 1).'</td>
                        <td>'.$customerGroupObj->title.'</td>
                        <td>
                            <a href="'.route('business.solarmitra.leads.destroy_client_group',$customerGroupObj->id).'" class="btn btn-danger shadow btn-xs py-2 sharp deleteClientGroup" title="Delete"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                ';
                return response()->json(['status' => true,'html' => $html,'message' => __('solarmitra::solarmitra.client_group_saved_text')]);
            }
            return redirect()->back()->with('error', __('solarmitra::solarmitra.something_went_wrong'));
        }


        return view('solarmitra::business.leads.client_group',compact('page_title','customerGroupObj','customer_groups'));
    }

    public function destroy_client_group($id)
    {
        $clientGroup = ClientGroup::findOrFail($id);
        /* Send Event Notification */
        $notificationObj        = new Notification();
        $notificationObj->notification_entry('CLIENTGROUP-DCG', $clientGroup->id, auth('business')->id(), config('constants.superadmin'));
        /* End Send Event Notification */
        $clientGroup->delete();

        if(request()->ajax())
        {
            return response()->json(['status' => true,'message' => __('solarmitra::solarmitra.client_group_deleted_text')]);
        }
        return redirect()->back()->with('success', __('solarmitra::solarmitra.client_group_deleted_text'));
    }

    public function export(Request $request)
    {
        /* Send Event Notification */
        /*$notificationObj        = new Notification();
        $notificationObj->notification_entry('LEAD-EL', $lead->id, auth('business')->id(), config('constants.superadmin'));*/
        /* End Send Event Notification */
        return Excel::download(new LeadsExport, 'leads.xlsx');
    }

    public function import(Request $request)
    {
        if($request->isMethod('post'))
        {
            $request->validate([
                'import_file' => 'required|mimes:xlsx',
                'assign_to' => 'required',
            ]);

            try {

                $import = new LeadsImport();
                Excel::import($import, $request->file('import_file'));
                $failures = $import->failures();
                $failedCount = count($import->failures());

                $rowNumObj = $failures->map(function ($failure) {
                    return $failure->row();
                });

                $rowNumbers = $rowNumObj->implode(', ');
                
                /* Send Event Notification */
                /*$notificationObj        = new Notification();
                $notificationObj->notification_entry('LEAD-IL', $lead->id, auth('business')->id(), config('constants.superadmin'));*/
                /* End Send Event Notification */

                return back()->with(
                    'success',
                    "Imported: {$import->importedCount}, 
                     Duplicates: {$import->duplicateCount}, 
                     Failed: {$failedCount},
                     Failed Rows: {$rowNumbers}"
                );


                return back()->with('success', 'Leads imported successfully');

            } catch (\Exception $e) {

                return back()->with('error', $e->getMessage());
            }

        }

        $client_groups = ClientGroup::where('business_id', app('currentBusinessId'))->pluck('title','id')->toArray();
        $staff_list = SolarMitraHelper::getContactsList('staff');
        if($request->ajax())
        {
            return view('solarmitra::business.leads.import-modal',compact('client_groups','staff_list'));
        }
        return view('solarmitra::business.leads.import',compact('client_groups','staff_list'));
    }

    public function multi_destroy(Request $request)
    {
        if($request->isMethod('post'))
        {
            Lead::whereIn('id', $request->selected_leads)->delete();

            /* Send Event Notification */
            /*$notificationObj        = new Notification();
            $notificationObj->notification_entry('LEAD-DML', $lead->id, auth('business')->id(), config('constants.superadmin'));*/
            /* End Send Event Notification */
            
            return response()->json(['status' => true,'message' => __('solarmitra::solarmitra.lead_deleted_text')]);
        }
    }

    public function lead_change_stage(Request $request)
    {
        if($request->isMethod('post'))
        {
            Lead::whereIn('id', $request->selected_leads)->update(['lead_stage_id' => $request->value]);
            /* Send Event Notification */
            /*$notificationObj        = new Notification();
            $notificationObj->notification_entry('LEAD-LSCB', $lead->id, auth('business')->id(), config('constants.superadmin'));*/
            /* End Send Event Notification */
            return response()->json(['status' => true,'message' => __('solarmitra::solarmitra.lead_stage_changed')]);

        }
    }

    public function lead_client_group(Request $request)
    {
        if($request->isMethod('post'))
        {
            Lead::whereIn('id', $request->selected_leads)->update(['client_group_id' => $request->value]);
            /* Send Event Notification */
            /*$notificationObj        = new Notification();
            $notificationObj->notification_entry('LEAD-CLCGB', $lead->id, auth('business')->id(), config('constants.superadmin'));*/
            /* End Send Event Notification */
            return response()->json(['status' => true,'message' => __('solarmitra::solarmitra.client_group_changed')]);
        }
    }

    public function lead_source(Request $request)
    {
        if($request->isMethod('post'))
        {
            Lead::whereIn('id', $request->selected_leads)->update(['lead_source_id' => $request->value]);
            /* Send Event Notification */
            /*$notificationObj        = new Notification();
            $notificationObj->notification_entry('LEAD-CLSB', $lead->id, auth('business')->id(), config('constants.superadmin'));*/
            /* End Send Event Notification */
            return response()->json(['status' => true,'message' => __('solarmitra::solarmitra.lead_source_changed')]);
        }
    }

    public function lead_potential(Request $request)
    {
        if($request->isMethod('post'))
        {
            Lead::whereIn('id', $request->selected_leads)->update(['potential' => $request->value]);
            /* Send Event Notification */
            /*$notificationObj        = new Notification();
            $notificationObj->notification_entry('LEAD-CLPB', $lead->id, auth('business')->id(), config('constants.superadmin'));*/
            /* End Send Event Notification */
            return response()->json(['status' => true,'message' => __('solarmitra::solarmitra.lead_potential_changed')]);
        }
    }


}
