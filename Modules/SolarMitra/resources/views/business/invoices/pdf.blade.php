<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #000;
            background: #fff;
            width: 750px;
        }

        .page {
            width: 750px;
            padding: 20px 24px;
        }

        /* -- Header -- */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }
        .header-table td {
            vertical-align: middle;
            padding: 2px 4px;
        }
        .logo-cell {
            width: 72px;
        }
        .logo-box {
            width: 62px;
            height: 62px;
            border: 2px solid #1d4aa1;
            text-align: center;
            font-size: 26px;
            color: #1d4aa1;
            font-weight: bold;
            {{-- padding-top: 14px; --}}
        }
        .logo-box img {
            position: relative;
            top: 50%;
            transform: translatey(-50%);
        }
        .company-name {
            font-size: 22px;
            font-weight: bold;
            color: #1d4aa1;
            letter-spacing: 1px;
        }
        .company-info {
            font-size: 9px;
            color: #333;
            margin-top: 4px;
            line-height: 1.7;
            width: 100%;
        }
        .company-info b { font-weight: bold; }
        .company-info table { 
            width: 100%;
            border-collapse: collapse;

        }
        .company-info table td { 
            width: 50%;
            padding: 0;
            margin: 0;
        }
        .company-info span { 
            width:50%;
            float: left;
         }

        .header-divider {
            border: none;
            border-top: 2px solid #1d4aa1;
            margin: 6px 0 8px 0;
        }

        /* -- Bill To / Invoice Details -- */
        .bill-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
            border: 1px solid #999;
        }
        .bill-table .hdr td {
            font-weight: bold;
            background-color: #eee;
            padding: 4px 6px;
            border-bottom: 1px solid #999;
            font-size: 10px;
        }
        .bill-table .hdr td.left { border-right: 1px solid #999; }
        .bill-table .body td {
            padding: 5px 6px;
            vertical-align: top;
            font-size: 9px;
        }
        .bill-table .body td.left { border-right: 1px solid #999; }
        .bill-table .body td .name { font-weight: bold; font-size: 11px; }
        .bill-table .body td .inv-no { font-weight: bold; font-size: 11px; }

        /* -- Items Table -- */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
            table-layout: fixed;
        }
        .items-table th {
            background-color: #1d4aa1;
            color: #fff;
            padding: 5px 4px;
            text-align: center;
            font-size: 9px;
            border: 1px solid #1d4aa1;
            word-wrap: break-word;
        }
        .items-table td {
            padding: 5px 4px;
            border: 1px solid #ccc;
            font-size: 9px;
            vertical-align: middle;
            word-wrap: break-word;
        }
        .items-table .c-no   { width: 4%;  text-align: center; }
        .items-table .c-item { width: 27%; text-align: left; }
        .items-table .c-hsn  { width: 7%;  text-align: center; }
        .items-table .c-qty  { width: 7%;  text-align: right; }
        .items-table .c-unit { width: 5%;  text-align: center; }
        .items-table .c-prc  { width: 13%; text-align: right; }
        .items-table .c-gst  { width: 15%; text-align: right; }
        .items-table .c-amt  { width: 15%; text-align: right; }

        .items-table .total-row td {
            font-weight: bold;
            background-color: #f5f5f5;
        }

        /* -- Bottom two-column layout -- */
        .bottom-wrap {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }
        .bottom-wrap td { vertical-align: top; }
        .bottom-wrap .col-left  { width: 65%; padding-right: 6px; }
        .bottom-wrap .col-right { width: 35%; }

        /* -- Tax Summary -- */
        .section-label {
            font-weight: bold;
            font-size: 9px;
            background-color: #eee;
            padding: 3px 5px;
            border: 1px solid #999;
            border-bottom: none;
        }
        .tax-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #999;
            table-layout: fixed;
        }
        .tax-table th {
            background-color: #1d4aa1;
            color: #fff;
            padding: 4px 3px;
            font-size: 8.5px;
            text-align: center;
            border: 1px solid #1d4aa1;
            word-wrap: break-word;
        }
        .tax-table td {
            padding: 4px 3px;
            font-size: 8.5px;
            border: 1px solid #ccc;
            text-align: center;
            word-wrap: break-word;
        }
        .tax-table .total-row td { font-weight: bold; background-color: #f5f5f5; }

        /* -- Summary (Sub Total / Total) -- */
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #999;
            margin-bottom: 6px;
        }
        .summary-table td {
            padding: 4px 6px;
            font-size: 9px;
            border-bottom: 1px solid #ddd;
        }
        .summary-table .lbl { font-weight: bold; width: 48%; }
        .summary-table .col { width: 5%; text-align: center; }
        .summary-table .val { text-align: right; }
        .summary-table .grand td {
            font-weight: bold;
            font-size: 10px;
            background-color: #eee;
        }

        /* -- Words Box -- */
        .words-box {
            border: 1px solid #999;
            padding: 5px 6px;
            font-size: 9px;
        }
        .words-box b { font-weight: bold; display: block; margin-bottom: 2px; }

        /* -- Terms -- */
        .terms-box {
            border: 1px solid #999;
            padding: 5px 6px;
            font-size: 9px;
            margin-bottom: 8px;
        }
        .terms-box b { font-weight: bold; display: block; margin-bottom: 2px; }

        /* -- Footer: Bank + Signature -- */
        .footer-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #999;
        }
        .footer-table td { padding: 7px 8px; vertical-align: top; font-size: 9px; }
        .footer-table .bank-col { width: 54%; border-right: 1px solid #999; }
        .footer-table .sig-col  { width: 46%; text-align: center; }
        .footer-table b { font-weight: bold; }
        .sig-company {
            font-weight: bold;
            font-size: 11px;
            color: #1d4aa1;
            margin: 8px 0 28px 0;
        }
        .sig-line {
            border-top: 1px solid #000;
            width: 65%;
            margin: 0 auto 4px auto;
        }
    </style>
</head>
<body>
<div class="page">

    <!-- HEADER -->
    <table class="header-table">
        <tr>
            <td class="logo-cell">
                <div class="logo-box"><img src="{{asset('modules/solarmitra/images/logo.png')}}" alt="Logo"></div>
            </td>
            <td>
                <div class="company-name">{{$business->company_name}}</div>
                <div class="company-info">
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td colspan="2">{{ $business->addresses && $business->addresses->isNotEmpty() ? $business->addresses->first()->address : ''}}</td>
                        </tr>
                        <tr>
                            <td><b>Phone:</b> {{$business->phone}} </td>
                            <td><b>Email:</b> {{$business->user->email}} </td>
                        </tr>
                        <tr>
                            <td><b>GSTIN:</b> {{$business->gst_no}} </td>
                            <td><b>State:</b> {{ $business->addresses && $business->addresses->isNotEmpty() ? optional($business->addresses->first()->state)->name : ''}}</td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>

    <hr class="header-divider">

    <!-- BILL TO / INVOICE DETAILS -->
    <table class="bill-table">
        <tr class="hdr">
            <td class="left" style="width:55%;">Bill To:</td>
            <td style="width:45%;">Invoice Details:</td>
        </tr>
        <tr class="body">
            <td class="left" style="width:55%;">
                <div class="name">{{optional($invoice->client)->name}}</div>
                <div style="margin-top:3px;">{{optional(optional(@$invoice->client)->address)->address}}</div>
                <div>GSTIN: {{optional(@$invoice->client)->gst_no}}</div>
            </td>
            <td style="width:45%;">
                <div class="inv-no">No: {{$invoice->invoice_number}}</div>
                <div style="margin-top:4px; font-weight:bold;">Date: {{$invoice->date}}</div>
            </td>
        </tr>
    </table>

    <!-- ITEMS TABLE -->
    <table class="items-table">
        <thead>
            <tr>
                <th class="c-no">#</th>
                <th class="c-item" style="text-align:left;">{{ __('solarmitra::solarmitra.item_name') }}</th>
                <th class="c-hsn">HSN/<br>SAC</th>
                <th class="c-qty">Qty</th>
                <th class="c-unit">{{ __('solarmitra::solarmitra.unit') }}</th>
                <th class="c-prc">Price/Unit(&#8377;)</th>
                <th class="c-gst">GST(&#8377;)</th>
                <th class="c-amt">Amount(&#8377;)</th>
            </tr>
        </thead>
        <tbody>
            @php $totalGst = 0; @endphp
            @forelse ($invoice->items as $length => $item)
                @php
                    $gstAmount = round($item->amount * ($item->gst / (100 + $item->gst)), 2);
                    $totalGst += $gstAmount;
                @endphp
            <tr>
                <td class="c-no">{{$length+1}}</td>
                <td class="c-item"><b>{{$item->item_title}} </b></td>
                <td class="c-hsn">{{optional(optional($item)->material_item)->hsn_sac}}</td>
                <td class="c-qty">{{$item->item_quantity}}</td>
                <td class="c-unit">{{$item->item_unit}}</td>
                <td class="c-prc">&#8377; {{$item->rates_per_units}}</td>
                <td class="c-gst">&#8377; {{$gstAmount}} ({{$item->gst}}%)</td>
                <td class="c-amt">&#8377; {{$item->amount}}</td>
            </tr>
            @empty
            @endforelse
           
            <tr class="total-row">
                <td colspan="2" style="text-align:left;"><b>Total</b></td>
                <td></td>
                <td class="c-qty"><b>{{$invoice->items->sum('item_quantity')}}</b></td>
                <td></td>
                <td></td>
                <td class="c-gst"><b>&#8377; {{$totalGst}}</b></td>
                <td class="c-amt"><b>&#8377; {{$invoice->total_amount}}</b></td>
            </tr>
        </tbody>
    </table>

    <!-- BOTTOM: TAX SUMMARY + RIGHT PANEL -->
    <table class="bottom-wrap">
        <tr>

            <td class="col-right">
                <table class="summary-table">
                    @php
                        $roundedTotal = round($invoice->total_amount,0);
                        $roundOff = $roundedTotal - $invoice->total_amount;
                    @endphp
                    <tr>
                        <td class="lbl">Sub Total</td>
                        <td class="col">:</td>
                        <td class="val">&#8377; {{SolarMitraHelper::format_number($invoice->total_amount)}}</td>
                    </tr>
                    <tr>
                        <td class="lbl">Round Off</td>
                        <td class="col">:</td>
                        <td class="val">&#8377; {{ $roundOff > 0 ? '+' : ($roundOff < 0 ? '-' : '') }} {{ SolarMitraHelper::format_number(abs($roundOff)) }}</td>
                    </tr>
                    <tr class="grand">
                        <td class="lbl">Total</td>
                        <td class="col">:</td>
                        <td class="val">&#8377; {{SolarMitraHelper::format_number($roundedTotal)}}</td>
                    </tr>
                </table>
                <div class="words-box">
                    <b>Invoice Amount in Words:</b>
                    {{Number::spell($roundedTotal, locale: 'en_IN')}}
                </div>
            </td>
        </tr>
    </table>


    <!-- PAYMENT HISTORY -->
    @if(@$transactions->count())
    <div style="margin-top: 20px; margin-bottom: 20px;">
        <h3 style="font-size: 14px; margin-bottom: 10px;">{{ __('solarmitra::solarmitra.payment_history') }}</h3>
        <table class="table" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f3f3f3;">
                    <th style="padding: 6px 8px; border: 1px solid #ddd; text-align: left;">{{ __('solarmitra::solarmitra.date') }}</th>
                    <th style="padding: 6px 8px; border: 1px solid #ddd; text-align: left;">{{ __('solarmitra::solarmitra.type') }}</th>
                    <th style="padding: 6px 8px; border: 1px solid #ddd; text-align: right;">{{ __('solarmitra::solarmitra.amount') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $txn)
                <tr>
                    <td style="padding: 6px 8px; border: 1px solid #ddd;">{{ $txn->date }}</td>
                    <td style="padding: 6px 8px; border: 1px solid #ddd;">{{ optional($txn->transaction_type)->title ?? '-' }}</td>
                    <td style="padding: 6px 8px; border: 1px solid #ddd; text-align: right;">{{ SolarMitraHelper::getBusinessConfig('currency_symbol', '₹') }}{{ SolarMitraHelper::format_number($txn->amount) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 10px;">
            <p style="margin: 4px 0;">Total Amount: <b>{{ SolarMitraHelper::getBusinessConfig('currency_symbol', '₹') }}{{ SolarMitraHelper::format_number($invoice->total_amount) }}</b></p>
            <p style="margin: 4px 0;">Total Paid: <b style="color: green;">{{ SolarMitraHelper::getBusinessConfig('currency_symbol', '₹') }}{{ SolarMitraHelper::format_number($totalPaid) }}</b></p>
            <p style="margin: 4px 0;">Due Amount: <b style="color: {{ $dueAmount > 0 ? 'red' : 'green' }};">{{ SolarMitraHelper::getBusinessConfig('currency_symbol', '₹') }}{{ SolarMitraHelper::format_number($dueAmount) }}</b></p>
        </div>
    </div>
    @endif

    <!-- BANK + SIGNATURE -->
    <table class="footer-table">
        @php
            $bank_account = $business->bank_accounts->firstWhere('is_primary',1);
        @endphp
        <tr>
            @if (SolarMitraHelper::getBusinessConfig('show_company_bank_details', true))
            <td class="bank-col">
                <table style="width:100%;">
                    <tr>
                        <td style="width:10px; vertical-align: top;">
                            @if (is_file(public_path('storage/solarmitra-attachments/business_'.optional(@$bank_account->attachment)->business_id.'/'.optional(@$bank_account->attachment)->file_name)))
                                <img width="100" src="{{public_path('storage/solarmitra-attachments/business_'.optional(@$bank_account->attachment)->business_id.'/'.optional(@$bank_account->attachment)->file_name)}}">
                            @endif
                        </td>
                        <td style="vertical-align: top;">
                            <b>Bank Details:</b><br><br>
                            Name : <b>{{@$bank_account->bank_name}}, {{@$bank_account->bank_address}}</b><br>
                            Account No. : <b>{{@$bank_account->account_number}}</b><br>
                            IFSC code : <b>{{@$bank_account->ifsc_code}}</b><br>
                            Account holder's name : <b>{{@$bank_account->account_holder}}</b>
                        </td>
                    </tr>
                </table>
            </td>
            @endif
            <td class="sig-col">
                <b>For {{$business->company_name}}:</b>
                <div class="sig-company">{{$business->company_name}}</div>
                <div class="sig-line"></div>
                <div>Authorized Signatory</div>
            </td>
        </tr>
    </table>

</div>
</body>
</html>