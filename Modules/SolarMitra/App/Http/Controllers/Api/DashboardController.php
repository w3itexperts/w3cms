<?php

namespace Modules\SolarMitra\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\SolarMitra\App\Models\Project;
use Modules\SolarMitra\App\Models\Quotation;
use Modules\SolarMitra\App\Models\Invoice;
use Modules\SolarMitra\Helper\SolarMitraHelper;
use Modules\SolarMitra\App\Models\Lead;

class DashboardController extends Controller
{

    // Display Dashboard Data
    public function dashboard(Request $request)
    {
        $projects = Project::where('business_id',app('currentBusinessId'));
        $this->checkDateFilter('start_date' ,$projects);

        $quotations = Quotation::where('business_id', app('currentBusinessId'));
        $this->checkDateFilter('date' ,$quotations);

        $invoices = Invoice::where('business_id', app('currentBusinessId'));
        $this->checkDateFilter('date' ,$invoices);

        $leads = Lead::where('business_id', app('currentBusinessId'))->when(optional(auth('api')->user())->id && !auth('api')->user()->hasRole('Business'), function ($query) use ($request) {
                        $query->where('lead_added_by_id', optional(auth('api')->user())->id);
                    });
        $this->checkDateFilter('created_at' ,$leads);

        /* 1. KPI Summary Cards Start Here */
        /* New Leads */
        $new_leads = (clone $leads)->whereHas('lead_stage',function($q){
                                $q->where('slug','new');
                            })->count();

        /* Active Projects */
        $active_projects = (clone $projects)->where('status', '2')->count();

        /* Pending Quotation */
        $pending_quotations = (clone $quotations)->whereIn('quotation_status_id', [2,3,4])->count();

        /* Outstanding Payments */
        $outstanding_payments = (clone $invoices)->sum('due_amount');

        /* Installed Capacities */
        $installed_capacities = (clone $projects)->where('status', '3')->sum('capacity_int');

        /* Material Alerts */
        $material_alerts = 0;

        /* Material Alerts */
        $draft_quotations = (clone $quotations)->where('quotation_status_id',1)->count();
        $sent_quotations = (clone $quotations)->where('quotation_status_id',2)->count();
        $in_discussion_quotations = (clone $quotations)->where('quotation_status_id',3)->count();
        $on_hold_quotations = (clone $quotations)->where('quotation_status_id',4)->count();
        $client_confirmed_quotations = (clone $quotations)->where('quotation_status_id',5)->count();
        $rejected_quotations = (clone $quotations)->where('quotation_status_id',6)->count();
        /* KPI Summary Cards End Here */


        /* 2. Sales Funnel Start Here */

        /* Total Leads */
        $total_leads = (clone $leads)->count();

        /* Total Qualified */
        $total_qualified = (clone $leads)->where('lead_stage_id',3)->count();

        /* Total Quotation Send */
        $total_quotation_send = (clone $quotations)->where('quotation_status_id',2)->count();

        /* Apporoved Quotation Won */
        $apporoved_quotations = (clone $quotations)->where('quotation_status_id',5)->count();

        /* Installed Panels */
        $installed_panels = (clone $projects)->whereHas('project_documents', function($q){
                                            $q->where('panel_work_status',1);
                                    })->count();
        /* Sales Funnel End Here */




        /* 4. Financial Snapshot Start Here */

        /* Total Revenue */
        $total_revenue = (clone $invoices)->sum('total_amount');
        $total_paid_invoices = (clone $invoices)->selectRaw('COUNT(*) as count, SUM(paid_amount) as total')->first();
        $total_unpaid_invoices = (clone $invoices)->selectRaw('COUNT(*) as count, SUM(due_amount) as total')->first();
        /* Financial Snapshot End Here */

        return response()->json([
            'status' => true,
            'data' => [
                'overview' => [
                    'new_leads' => $new_leads,
                    'active_projects' => $active_projects,
                    'pending_quotations' => $pending_quotations,
                    'outstanding_payments' => $outstanding_payments,
                    'installed_capacities' => $installed_capacities,
                    'material_alerts' => $material_alerts,
                    'draft_quotations' => $draft_quotations,
                    'sent_quotations' => $sent_quotations,
                    'in_discussion_quotations' => $in_discussion_quotations,
                    'on_hold_quotations' => $on_hold_quotations,
                    'client_confirmed_quotations' => $client_confirmed_quotations,
                    'rejected_quotations' => $rejected_quotations
                ],
                'finance' => [
                    'total_revenue' => $total_revenue,
                    'total_paid_invoices' => $total_paid_invoices,
                    'total_unpaid_invoices' => $total_unpaid_invoices
                ],
                'sales_funnel' => [
                    'total_leads' => $total_leads,
                    'total_qualified' => $total_qualified,
                    'total_quotation_send' => $total_quotation_send,
                    'apporoved_quotations' => $apporoved_quotations,
                    'installed_panels' => $installed_panels,
                    'qualified_leads_stage' => [
                        'id' => 3,
                        'name' => 'Qualified',
                    ]
                ],
                'solar_installation_margin_unit' => SolarMitraHelper::getBusinessConfig('solar_installation_margin_unit','Fix'),
                'solar_installation_margin_value' => SolarMitraHelper::getBusinessConfig('solar_installation_margin_value',0),
                'solar_installation_margin_for_1kw_3kw' => SolarMitraHelper::getBusinessConfig('solar_installation_margin_for_1kw_3kw',0),
                'solar_installation_margin_for_4kw_7kw' => SolarMitraHelper::getBusinessConfig('solar_installation_margin_for_4kw_7kw',0),
                'solar_installation_margin_for_8kw_15kw' => SolarMitraHelper::getBusinessConfig('solar_installation_margin_for_8kw_15kw',0),
                'solar_installation_margin_for_16kw_plus' => SolarMitraHelper::getBusinessConfig('solar_installation_margin_for_16kw_plus',0),
            ]
        ]);


    }

    private function checkDateFilter($fieldName ,$query) {
        if (request()->sort_by == 'this_month') {
            $query->whereYear($fieldName, \Carbon\Carbon::now()->year);
            $query->whereMonth($fieldName, \Carbon\Carbon::now()->month);
        }
        elseif (request()->sort_by == 'last_24_hours') {
            $query->where($fieldName, '>=', \Carbon\Carbon::now()->subDay());
        }
        elseif (request()->sort_by == 'last_7_days') {
            $query->where($fieldName, '>=', \Carbon\Carbon::now()->subDays(7));
        }
        elseif (request()->sort_by == 'this_week') {
            $query->whereBetween($fieldName, [
                \Carbon\Carbon::now()->startOfWeek(), 
                \Carbon\Carbon::now()->endOfWeek()
            ]);
        }
        elseif (request()->sort_by == 'this_year') {
            $query->whereYear($fieldName, \Carbon\Carbon::now()->year);
        }
        elseif (request()->sort_by == 'range') {
            if (!empty(request()->daterange)) {
                $dates = explode(' - ', request()->daterange);
                $startDate = \Carbon\Carbon::createFromFormat('d-m-Y', $dates[0])->format('Y-m-d');
                $endDate = \Carbon\Carbon::createFromFormat('d-m-Y', $dates[1])->format('Y-m-d');
                $query->whereBetween($fieldName, [$startDate, $endDate]);
            }
        }
        elseif (request()->sort_by == 'all_time') {
            
        }
    }

}