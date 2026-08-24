<?php

namespace Modules\SolarMitra\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Modules\SolarMitra\App\Models\Contact;
use App\Models\User;
use Modules\SolarMitra\App\Models\Address;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;

class ContactsController extends Controller
{

    // Display Contact Listing
    public function list(Request $request)
    {
        $request->validate([
            'search'      => 'nullable|string|max:255',
            'type'        => 'nullable|string|max:255',
            'per_page'    => 'nullable|integer|min:1|max:100',
        ]);

        $businessId = app('currentBusinessId');
        $search = $request->query('search');  
        $perPage = $request->query('per_page', config('Reading.nodes_per_page'));

        $contacts = Contact::query()
            ->with('address')
            ->withCount(['client', 'supplier', 'investor', 'contractor', 'partner', 'staff'])
            ->where('business_id', $businessId)
            ->when($request->query('type'), function ($query, $type) {
                $businessRoles = config('solarmitra.business_user_roles', []);
                if (array_key_exists($type, $businessRoles)) {
                    $relation = Str::singular($type ?? '');
                    $query->whereHas($relation);
                }
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('first_name', 'like', '%' . $search . '%')
                        ->orWhere('last_name', 'like', '%' . $search . '%')
                        ->orWhere('phone_number', 'like', '%' . $search . '%');
                });
            })
            ->latest()
            ->paginate($perPage);

        // Add roles count for staff contacts
        $contacts->getCollection()->transform(function ($contact) {

            if ($contact->user) {
                $contact->roles = $contact->user->roles()->pluck('name')->toArray();
            } else {
                $contact->roles = [];
            }

            return $contact;
        });

        return response()->json([
            'status' => true,
            'data' => $contacts
        ]);
    }


    //Add Contact
    public function store(Request $request)
    {
        return $this->saveContact($request);
    }

    //Update Contact
    public function update(Request $request, $id)
    {
        return $this->saveContact($request, $id);
    }

    //Destroy Contact
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $contact = Contact::with([
                'clients',
                'staff',
                'suppliers',
                'investors',
                'contractors',
                'partners',
                'user'
            ])->findOrFail($id);

            /** Delete role-based records */
            $contact->client()?->delete();
            $contact->staff()?->delete();
            $contact->supplier()?->delete();
            $contact->investor()?->delete();
            $contact->contractor()?->delete();
            $contact->partner()?->delete();

            /** Remove user roles */
            if ($contact->user) {
                $contact->user->syncRoles([]);
            }

            /** Delete contact */
            $contact->delete();

            /** Optional: delete user if unused */
            if ($contact->user && !$contact->user->contact()->exists()) {
                $contact->user->delete();
            }

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => __('solarmitra::solarmitra.contact_deleted_successfully')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'error'  => $e->getMessage()
            ], 500);
        }
    }

    //Save Contact
    private function saveContact(Request $request, $id = null)
    {
        $businessRoles = config('solarmitra.business_user_roles', []);
        $businessId = app('currentBusinessId');

        $contact = $id ? Contact::findOrFail($id) : new Contact();
        $user    = $contact->user ?? new User();

        $validation = [
            'name'  => 'required|string|max:255',
            'email' => [
                'nullable',
                'email',
                Rule::unique('contacts')->where(fn($q) => $q->where('business_id', $businessId))->ignore($contact->id, 'id'),
            ],
            'phone_number' => [
                'required','numeric','digits:10',
                Rule::unique('contacts')->where(fn($q) => $q->where('business_id', $businessId))->ignore($contact->id, 'id'),
            ],
            'aadhar_no' => [
                'nullable',
                'digits:12',
                'regex:/^[0-9]{12}$/',
                Rule::unique('contacts')->where(fn($query) => $query->where('business_id', $businessId))->ignore($contact->id, 'id'),
            ],

            'pan_no' => [
                'nullable',
                'regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/',
                Rule::unique('contacts')->where(fn($query) => $query->where('business_id', $businessId))->ignore($contact->id, 'id'),
            ],

            'gst_no' => [
                'nullable',
                'regex:/^\d{2}[A-Z]{5}\d{4}[A-Z]{1}\d[A-Z0-9]{1}[A-Z0-9]{1}$/',
                Rule::unique('contacts')->where(fn($query) => $query->where('business_id', $businessId))->ignore($contact->id, 'id'),
            ],
            'type'  => 'required|in:' . implode(',', array_keys($businessRoles)),
            'company_name' => 'nullable|string|max:255',
        ];

        if (request('type') == 'clients' && !$contact->exists) {
            $validation['address_title'] = 'required';
            $validation['address'] = 'required';
        }

        if ($contact->user) {
            $validation['email'] = 'required|email|unique:users,email,' . $contact->user->id;
            $validation['phone_number'] = 'required|string|digits:10|unique:users,mobile,'. $contact->user->id;
        }


        $validated = $request->validate($validation);

        DB::beginTransaction();

        try {
            /** USER */
            [$firstName, $lastName] = explode(' ', $validated['name'] . ' ', 2);

 
            /** CONTACT */
            $contact->business_id  = $businessId;
            $contact->user_id      = 0;
            $contact->type         = 2;
            $contact->first_name    = trim(@$firstName);
            $contact->last_name     = trim(@$lastName);
            $contact->name         = $validated['name'];
            $contact->phone_number = $validated['phone_number'];
            $contact->email        = $request->email;
            if ($request->filled('company_name')) {
                $contact->company_name= $request->company_name;
            }
            $contact->aadhar_no    = $validated['aadhar_no'] ?? null;
            $contact->pan_no       = $validated['pan_no'] ?? null;
            $contact->gst_no       = $validated['gst_no'] ?? null;

            $contact->save();

            /** ROLE TABLE */
            $projectId = $validated['project_id'] ?? 0;

            match ($validated['type']) {
                'clients' => $contact->client()->firstOrNew(['contact_id' => $contact->id])
                    ->fill([
                        'business_id' => $businessId,
                        'customer_since' => $request->filled('customer_since') ? Carbon::parse($request->customer_since)->format(config('solarmitra.date_time_format')) : Carbon::now()->format(config('solarmitra.date_time_format')),
                        'status' => 1,
                        'client_code'=> $request->client_code,
                        'client_type'=> $request->client_type,
                        'account_manager_id'=> $request->account_manager_id,
                        'credit_limit'=> $request->credit_limit,
                        'payment_terms'=> $request->payment_terms,
                        'preferred_contact_method'=> $request->preferred_contact_method,
                        'priority_level'=> $request->priority_level,
                        'notes'=> $request->notes,
                    ])->save(),

                'staff' => (function () use ($contact, $businessId, $request) {
                    $contact->staff()->firstOrNew(['contact_id' => $contact->id])
                        ->fill([
                            'business_id' => $businessId,
                            'joining_date' => $request->filled('joining_date') ? Carbon::parse($request->joining_date)->format(config('solarmitra.date_time_format')) : Carbon::now()->format(config('solarmitra.date_time_format')),
                            'status' => 1,
                            'employee_code'=> $request->employee_code,
                            'department'=> $request->department,
                            'designation'=> $request->designation,
                            'employment_type'=> $request->employment_type,
                            'salary_type'=> $request->salary_type,
                            'salary_amount'=> $request->salary_amount,
                            'reporting_manager_id'=> $request->reporting_manager_id,
                            'work_location'=> $request->work_location,
                            'work_responsibilities'=> $request->work_responsibilities,
                            'special_note'=> $request->special_note,
                        ])
                        ->save();

                    $contact->update([
                        'company_name' => optional($contact->business)->company_name,
                    ]);
                })(),

                'suppliers' => $contact->supplier()->firstOrNew(['contact_id' => $contact->id])
                    ->fill([
                        'business_id' => $businessId, 
                        'status' => 1, 
                        'supplier_category' => $request->supplier_category,
                        'brand_name' => $request->brand_name,
                        'gst_no' => $request->gst_no,
                        'pan_no' => $request->pan_no,
                        'payment_terms' => $request->payment_terms,
                        'delivery_time_days' => $request->delivery_time_days,
                        'service_area' => $request->service_area,
                        'rating' => $request->rating,
                    ])->save(),

                'investors' => $contact->investor()->firstOrNew(['contact_id' => $contact->id])
                    ->fill([
                        'business_id' => $businessId, 
                        'investment_date' => $request->filled('investment_date') ? Carbon::parse($request->investment_date)->format(config('solarmitra.date_time_format')) : Carbon::now()->format(config('solarmitra.date_time_format')), 
                        'status' => 1, 
                        'investment_type' => $request->investment_type,
                        'investment_amount' => $request->investment_amount,
                        'equity_percent' => $request->equity_percent,
                        'investment_date' => $request->investment_date,
                        'expected_roi' => $request->expected_roi,
                        'payout_frequency' => $request->payout_frequency,
                        'contract_document' => $request->contract_document,
                    ])->save(),

                'contractors' => $contact->contractor()->firstOrNew(['contact_id' => $contact->id])
                    ->fill([
                        'business_id' => $businessId, 
                        'contractor_type' => $request->contractor_type,
                        'team_size' => $request->team_size,
                        'skill_category' => $request->skill_category,
                        'labor_rate_per_kw' => $request->labor_rate_per_kw,
                        'service_area' => $request->service_area,
                        'experience_years' => $request->experience_years,
                        'license_no' => $request->license_no,
                        'availability_status' => $request->availability_status,
                        'rating' => $request->rating,
                    ])->save(),

                'partners' => $contact->partner()->firstOrNew(['contact_id' => $contact->id])
                    ->fill([
                        'business_id' => $businessId, 
                        'partnership_start_date' => $request->filled('partnership_start_date') ? Carbon::parse($request->partnership_start_date)->format(config('solarmitra.date_time_format')) : Carbon::now()->format(config('solarmitra.date_time_format')), 
                        'partnership_end_date' => $request->filled('partnership_end_date') ? Carbon::parse($request->partnership_end_date)->format(config('solarmitra.date_time_format')) : Carbon::now()->format(config('solarmitra.date_time_format')), 
                        'status' => 1, 
                        'partner_type' => $request->partner_type,
                        'commission_percent' => $request->commission_percent,
                        'region' => $request->region,
                        'sales_target' => $request->sales_target,
                    ])->save(),
            };

            if ($request->address) {
                $AddressObj = $contact->address()->firstOrNew(['contact_id' => $contact->id]);
                $AddressObj->business_id        = $request->business_id ?? 0;
                $AddressObj->contact_id         = $contact->id ?? 0;
                $AddressObj->project_id         = $request->project_id ?? 0;
                $AddressObj->address_title      = $request->address_title;
                $AddressObj->address            = $request->address;
                $AddressObj->city_id            = $request->city_id ?? 0;
                $AddressObj->state_id           = $request->state_id ?? 0;
                $AddressObj->country_id         = $request->country_id ?? 0;
                $AddressObj->address_type       = $request->address_type ?? 1;
                $AddressObj->is_primary         = 1;
                $address                        = $AddressObj->save();
            }

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => $id ? __('solarmitra::solarmitra.contact_updated_successfully') : __('solarmitra::solarmitra.contact_created_successfully'),
                'data'    => $contact
            ], 201);

        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'error'  => $e->getMessage(),
            ], 500);
        }
    }
    

}