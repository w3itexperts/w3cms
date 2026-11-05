<?php

namespace Modules\SolarMitra\App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\SolarMitra\App\Models\QuotationItem;
use Modules\SolarMitra\App\Models\MaterialLibrary;
use App\Models\Notification;

class QuotationItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('solarmitra::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $page_title = __('solarmitra::solarmitra.create').' '.__('solarmitra::solarmitra.quotation_item');
        if ($request->ajax()) 
        {
            return view('solarmitra::business.quotation-items.ajax_form');
        }

        return view('solarmitra::business.quotation-items.create',compact('page_title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        $validation = [
            'item_title'  => 'required',
            'quotation_id'  => 'required',
            'item_quantity'  => 'required',
            'rates_per_units'  => 'required',
        ];


        $validationMsg = [
            'item_title.required' => __('solarmitra::solarmitra.item_title_is_required'),
            'quotation_id.required' => __('solarmitra::solarmitra.quotation_id_is_required'),
            'quotation_id.exists' => __('solarmitra::solarmitra.selected_quotation_does_not_exist'),
            'item_quantity.required' => __('solarmitra::solarmitra.item_quantity_is_required'),
            'item_quantity.numeric' => __('solarmitra::solarmitra.item_quantity_must_be_a_number'),
            'item_quantity.min' => __('solarmitra::solarmitra.item_quantity_must_be_at_least_1'),
            'rates_per_units.required' => __('solarmitra::solarmitra.rate_per_unit_is_required'),
            'rates_per_units.numeric' => __('solarmitra::solarmitra.rate_per_unit_must_be_a_number'),
            'rates_per_units.min' => __('solarmitra::solarmitra.rate_per_unit_cannot_be_negative'),
        ];

        $validator = \Validator::make($request->all(), $validation,$validationMsg);
        
        if ($request->ajax() && $validator->fails()) 
        {
            return response()->json(['errors' => $validator->errors()], 422);
        }else{
            $this->validate($request, $validation,$validationMsg);
        }
        
        $quotationObj = new QuotationItem(); 
        $quotationObj->quotation_id     = $request->quotation_id; 
        $quotationObj->invoice_id       = $request->invoice_id; 
        $quotationObj->item_unit        = $request->item_unit; 
        $quotationObj->item_id          = $request->item_id; 
        $quotationObj->item_title       = $request->item_title; 
        $quotationObj->item_quantity    = $request->item_quantity; 
        $quotationObj->rates_per_units  = $request->rates_per_units; 
        $quotationObj->gst              = $request->gst; 
        $quotationObj->discount         = $request->discount; 
        $quotationObj->description      = $request->description; 
        $res = $quotationObj->save();

        if ($res) {

            /* Send Event Notification */
            $notificationObj        = new Notification();
            $notificationObj->notification_entry('QUOTATIONITEM-ANQI', $quotationObj->id, auth('business')->id(), config('constants.superadmin'));
            /* End Send Event Notification */

            return redirect()->back()->with('success', __('solarmitra::solarmitra.quotation_item_added_text'));
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
        $page_title = __('solarmitra::solarmitra.edit').' '.__('solarmitra::solarmitra.quotation_items');
        $quotationItem = QuotationItem::findOrFail($id);
        if ($request->ajax()) {

            return view('solarmitra::business.quotation-items.ajax_form',compact('quotationItem'));
        }

        return view('solarmitra::business.quotation-items.edit',compact('page_title','quotationItem'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {

        $quotationItem = QuotationItem::findOrFail($id);

        /* Send Event Notification */
        $notificationObj        = new Notification();
        $notificationObj->notification_entry('QUOTATIONITEM-DQI', $quotationItem->id, auth('business')->id(), config('constants.superadmin'));
        /* End Send Event Notification */
            
        $quotationItem->delete();

        if ($request->ajax()) {
            return response()->json(['status' => true]);
        }
        return redirect()->back()->with('success', __('solarmitra::solarmitra.quotation_item_deleted_text'));
    }
}
