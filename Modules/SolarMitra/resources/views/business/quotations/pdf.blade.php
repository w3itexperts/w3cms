<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Proposal - {{$business->company_name}}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        @font-face {
            font-family: 'Poppins';
            src: url("{{ public_path('fonts/Poppins-Regular.ttf') }}") format('truetype');
            font-weight: 400;
        }
        @font-face {
            font-family: 'Poppins';
            src: url("{{ public_path('fonts/Poppins-Medium.ttf') }}") format('truetype');
            font-weight: 500;
        }
        @font-face {
            font-family: 'Poppins';
            src: url("{{ public_path('fonts/Poppins-SemiBold.ttf') }}") format('truetype');
            font-weight: 600;
        }
        @font-face {
            font-family: 'Poppins';
            src: url("{{ public_path('fonts/Poppins-Bold.ttf') }}") format('truetype');
            font-weight: 700;
        }
        * {
            margin: 0;
            padding: 0;
            font-size: 14px;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
            line-height: 100%;
        }

        body {
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
             font-family: "Poppins", sans-serif;
             line-height: 100%;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        .header {
            background: #3484ff;
            height: 50px;
        }

        .content {
            padding: 0px;
        }

        .title-section {
            padding: 200px 115px 140px;
        }

        .title {
            font-size: 120px;
            font-weight: 700;
            color: #3484ff;
            line-height: 70px;
            font-family: "Poppins", sans-serif;
        }

        .contact-info {
            margin-top: 80px;
            border: 1px solid #eff2f7;
            border-radius: 8px;
            padding: 10px 30px;
            
        }
        table.contact-info{
            margin-top: 80px;
            border: 1px solid #eff2f7;
            border-radius: 8px;
            padding: 20px 30px;
            width:100%;
        }
        table.contact-info tr td{
            font-size: 18px;
            padding: 5px 20px;
            color: #363636;
            font-weight: 400;
        }
        table.contact-info tr td.contact-detail{
            font-weight: 500;
            color: #101010;
        }

        table.contact-info tr:nth-child(even),
        table.info-item tr:nth-child(even),
        table.doc-grid tbody tr:nth-child(even){
            background-color: transparent;
        }

        table.contact-info tr:hover,
        table.info-item tr:hover,
        table.doc-grid tr:hover{
            background: transparent;
        }
        .contact-item {
            margin: 10px 0;
            font-size: 16px;
            display: flex;
        }

        .contact-label {
            color: #363636;
            margin-right: 10px;
            font-size: 18px;
            font-weight: 400;
            width: 120px;
            display:inline-block;
        }
        
        .contact-detail{
            color: #101010;
            font-weight: 500;
            font-size: 18px;
            line-height: 1;
            display:inline-block;
        }

        .logo-section {
            background: #3484ff;
            text-align:center;
            gap: 25px;
            height: 190px;
            display:block;
        }
         .logo-section img{
            display:inline-block;
            margin-top:35px;
         }
        .logo-icon {
            width: 50px;
            height: 50px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            color: #3484ff;
        }

        .logo-text {
            color: white;
            font-size: 28px;
            font-weight: 600;
        }

        .content-inner{
            padding: 40px 40px 0;
        }

        .section-title {
            color: #3484ff;
            font-size: 20px;
            font-weight: 700;
            background: #f4f8ff;
            border-radius: 8px;
            text-align: center;
            padding: 20px 0;
        }

        .info-grid {
            margin: 30px 0 15px;

        }
        .info-grid:after{
            content:"";
            display:block;
            clear:both;
        }
        .info-column{
            padding: 20px 15px;
            border: 1.5px solid #f1f1f1;
            border-radius: 8px;
            width: 315px;
            float:left;
        }
        
        .info-column h3 {
            font-size: 16px;
            margin-bottom: 10px;
            color: #000;
            font-weight: 600;
        }

        .info-item {
            margin: 8px 0;
            font-size: 12px;
            color: #101010;
            font-weight: 500;
            display: flex;
        }

        .info-item span {
            display: inline-block;
            min-width: 100px;
            font-size: 12px;
            font-weight: 400;
            color: #363636;
        }
        .info-item span img{
            margin-right:4px;
        }
        .table-header {
            margin: 18px 0 0;
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #000;
        }

        .quotation-tbl thead tr th:last-child{
            min-width: 120px;
        }

        .quotation-tbl tbody tr td:first-child{
            text-align: center;
        }

        table tbody tr:nth-child(even) {
            background-color: #f4f8ff;
        }

        table {
           width: 100%;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0px 1px 6px 0px #dddddd;
            border: 1px solid #dfdfdf;
        }

        th {
            background: #3484ff;
            color: white;
            padding: 15px 20px;
            text-align: left;
            font-size: 13px;
            font-weight: 600;
        }

        td {
            padding: 15px 22px;
            font-size: 11px;
            font-weight: 500;
            color: #363636;
        }

        td strong{
            font-size: 12px;
        }

        tr:hover {
            background: #f9f9f9;
        }

        .footer-logo {
            text-align: right;
            margin: 30px 0;
        }

        .footer-logo-icon {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: #3484ff;
            font-size: 18px;
            font-weight: 600;
        }

        .footer-logo-symbol {
            width: 30px;
            height: 30px;
            background: #3484ff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 16px;
        }
        
        .diagram-section {
            margin: 40px 0;
        }

        .diagram-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 30px;
            color: #333;
        }

        .diagrams {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-top: 50px;

        }
        .diagrams img{
            {{-- height: 80px; --}}
            width: 28%;
            margin: 0 2%;
        }

        .diagram-item {
            text-align: center;
        }

        .triangle {
            width: 0;
            height: 0;
            border-left: 50px solid transparent;
            border-right: 50px solid transparent;
            border-bottom: 80px solid #e0e0e0;
            position: relative;
            margin: 0 auto 10px;
        }

        .diagram-label {
            font-size: 12px;
            color: #666;
            margin-top: 10px;
        }

        .payment-section,.scope-section,.bank-details{
            background: #f4f8ff;
            border-radius: 8px;
            padding: 20px;
        }

        .payment-section, .scope-section, .organization-section {
            margin: 35px 0;
        }

        .section-heading {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #000;
        }

        .list-item {
            margin: 5px 0;
            padding-left: 20px;
            font-size: 13px;
            font-weight: 500;
            color: #232323;
            position: relative;
        }

        .list-item:before, .doc-item:before {
            content: "•>";
            position: absolute;
            left: 0;
            color: #3484ff;
            font-weight: bold;
        }

        .note-box {
            padding: 10px 20px;
            margin: 20px 0;
            border: 1px solid #95bfff;
            border-radius: 8px;
        }

        .note-box span{
            color: #3484ff;
            font-weight: 600;
        }

        .note-box p {
            font-size: 13px;
            font-weight: 500;
            color: #555;
            line-height: 1.6;
        }

        .documents-section {
            margin: 40px 0;
        }

        .doc-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
            margin-top: 20px;
        }

        .doc-item {
            font-size: 13px;
            color: #363636;
            font-weight: 500;
            padding: 5px 0 5px 20px;
            position: relative;
        }

        .bank-details p{
            font-size: 12px;
            color: #666;
            background: #fafafa;
            margin-bottom: 15px;
            border-radius: 8px;
            padding: 10px;
        }

        .bank-details-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 25px;
            color: #363636;
        }
        .bank-label {
            font-size: 12px;
            color: #363636;
			padding:5px;
            font-weight: 500;
        }

        .bank-value {
            font-size: 12px;
            color: #101010;
            font-weight: 600;
			padding:5px;
        }

        .page-footer {
            text-align: right;
            padding: 30px 30px 20px;
        }
        .scaner{
            float:right;
            width:200px;
            height:auto;
        }
        .scaner img{
            width:100%;
            height:auto;
        }
        .bank-grid{
            float:left;
            border: transparent;
        }

        .bank-details:after{
            content:"";
            display:block;
            clear:both;
        }

    </style>
</head>
<body>
    
    <div class="container">
        
        <!-- Header -->
        <div class="header"></div>

        <!-- Main Content -->
        <div class="content">
            
            <!-- Title Section -->
            <div class="title-section">
                <h1 class="title">{{ __('solarmitra::solarmitra.project_proposal') }}</h1>
                
                <table class="contact-info">
                    <tr class="contact-item">
                        <td class="contact-label">
                        <img src="{{ asset('modules/solarmitra/images/map.svg') }}" alt="{{$business->company_name}}" width="16">
                        Address
                        </td>
                        <td class="contact-detail">{{$business->addresses && $business->addresses->isNotEmpty() ? $business->addresses->first()->address : ''}}</td>
                    </tr>
                    <tr class="contact-item">
                        <td class="contact-label">
                           <img src="{{ asset('modules/solarmitra/images/phone-call.svg') }}" alt="{{$business->company_name}}" width="16">
                            Contact
                        </td>
                        <td class="contact-detail">+91 {{$business->phone}}</td>
                    </tr>
                </table>
            </div>

            <!-- Logo Section -->
            <div class="logo-section">
                <img src="{{ asset('modules/solarmitra/images/logo.png') }}" alt="{{$business->company_name}}" width="400">
            </div>
            
            <!-- Container -->
            <div class="content-inner">

                <!-- Quotation Section -->
                <p class="section-title">Quotation for Solar {{optional($quotation->project)->project_type}} Power {{optional($quotation->project)->capacity}}</p>

                <div class="info-grid">
                    <div class="info-column" style="margin-right: 20px;">
                        <h3>{{ __('solarmitra::solarmitra.quotation_to') }}</h3>
                        <div class="info-item">
                        <span>
                            <img src="{{ asset('modules/solarmitra/images/user.svg') }}" alt="{{$business->company_name}}" width="12">
                            Name:
                        </span>
                        {{optional($quotation->client)->name}}
                        </div>
                        <div class="info-item">
                            <span>
                               <img src="{{ asset('modules/solarmitra/images/phone-call.svg') }}" alt="{{$business->company_name}}" width="12">
                                Mobile:
                            </span>
                            {{optional($quotation->client)->phone_number}}
                        </div>
                        <div class="info-item">
                            <span>
                                <img src="{{ asset('modules/solarmitra/images/calendar.svg') }}" alt="{{$business->company_name}}" width="12">
                                Date:
                            </span>
                            {{$quotation->date}}
                        </div>
                        <div class="info-item">
                            <span>
                                <img src="{{ asset('modules/solarmitra/images/map.svg') }}" alt="{{$business->company_name}}" width="12">
                                Address:
                            </span>
                            {{optional(optional(@$quotation->client)->address)->address}}
                        </div>
                    </div>
                    <div class="info-column">
                        <h3>{{ __('solarmitra::solarmitra.subject') }}</h3>
                        <div class="info-item">{{$quotation->title}}</div>
                        <h3 style="margin-top: 20px;">{{ __('solarmitra::solarmitra.prepared_by') }}</h3>
                        <div class="info-item">
                            <span>
                               <img src="{{ asset('modules/solarmitra/images/user.svg') }}" alt="{{$business->company_name}}" width="12">
                                Name:
                            </span>
                            
                            {{optional(optional($quotation)->creator)->full_name ?? optional(optional(optional($quotation)->creator)->contact)->name }}
                        </div>
                        <div class="info-item">
                            <span>
                               <img src="{{ asset('modules/solarmitra/images/phone-call.svg') }}" alt="{{$business->company_name}}" width="12">
                                Mobile:
                            </span>
                            +91 {{optional(optional($quotation)->creator)->mobile ?? optional(optional(optional($quotation)->creator)->contact)->phone_number }}
                        </div>
                    </div>
                </div>

                <p>We thankfully acknowledge the enquiry for Installation of solar power plant. We are pleased to submit our offer as under.</p>

                <!-- Equipment Table -->
                <h4 class="table-header">List of Major Equipments & Proposed Vendors</h4>
                <div class="table-section">
                    <table class="quotation-tbl">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>{{ __('solarmitra::solarmitra.item') }}</th>
                                <th>{{ __('solarmitra::solarmitra.quantity') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($quotation->items as $length => $item)
                                <tr>
                                    <td>{{$length+1}}</td>
                                    <td>
                                        {{optional(optional(optional($item)->material_item)->material_category)->title}}
                                        <br> 
                                        {{$item->item_title}} 
                                        <br> 
                                        {{$item->description}}
                                    </td>
                                    <td>{{$item->item_quantity}}</td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>

                </div>

                <!-- Commercial -->
                @php
                    $totalAmount = $quotation->sub_total - $quotation->discount + $quotation->aditional_charges;
                    $B1fetch89Percent = $totalAmount * (8.9/ 100);
                    $B2AmountExceptTotalAmount = $totalAmount - $B1fetch89Percent;

                @endphp
                <h4 class="table-header">{{ __('solarmitra::solarmitra.commercial') }}</h4>
                <div class="table-section">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 520px;">{{ __('solarmitra::solarmitra.description') }}</th>
                                <th>{{ __('solarmitra::solarmitra.amount') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Cost for {{optional($quotation->project)->capacity}} Solar Power plant</td>
                                <td>Rs {{SolarMitraHelper::format_number($B2AmountExceptTotalAmount)}}/-</td>
                            </tr>
                            <tr>
                                <td>GST Will Be. 8.9% [5% on 70% of total cost and 18% on 30% of total cost]</td>
                                <td>Rs {{ SolarMitraHelper::format_number($B1fetch89Percent) }}/-</td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>TOTAL</strong>
                                </td>
                                <td>
                                    <strong>Rs {{SolarMitraHelper::format_number($totalAmount)}}/-</strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                @if (@$quotation->description)
                <p><strong>Note: </strong>   {{$quotation->description}}</p>
                @endif

                @if (optional(optional(optional($quotation)->project)->project_documents)->government_subsidy)
                @php
                    $subsidy_type = optional(optional(optional($quotation)->project)->project_documents)->selected_subsidy_type;
                    $central_govt_subsidy_amount = filter_var(SolarMitraHelper::getBusinessConfig('central_govt_subsidy_amount','78000'), FILTER_SANITIZE_NUMBER_INT);
                    $state_govt_subsidy_amount = filter_var(SolarMitraHelper::getBusinessConfig('state_govt_subsidy_amount','17000'), FILTER_SANITIZE_NUMBER_INT);
                    $amount = 0;
                @endphp
                <!-- Goverment Subsidy -->
                <h4 class="table-header">{{ __('solarmitra::solarmitra.government_subsidy') }}</h4>
                <div class="table-section">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 520px;">{{ __('solarmitra::solarmitra.description') }}</th>
                                <th>{{ __('solarmitra::solarmitra.amount') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (empty($subsidy_type) || $subsidy_type == 1 || $subsidy_type == 3)
                            @php $amount = $amount + $central_govt_subsidy_amount; @endphp
                            <tr>
                                <td>{{SolarMitraHelper::getBusinessConfig('central_govt_subsidy_content','Central Goverment')}}</td>
                                <td>Rs {{SolarMitraHelper::format_number($central_govt_subsidy_amount)}}/-</td>
                            </tr>
                            @endif
                            @if (empty($subsidy_type) || $subsidy_type == 2 || $subsidy_type == 3)
                            @php $amount = $amount + $state_govt_subsidy_amount; @endphp
                            <tr>
                                <td>{{SolarMitraHelper::getBusinessConfig('state_govt_subsidy_content','State Government (When applied)')}}</td>
                                <td>Rs {{SolarMitraHelper::format_number($state_govt_subsidy_amount)}}/-</td>
                            </tr>
                            @endif
                            <tr>
                                <td>
                                    <strong>TOTAL</strong>
                                </td>
                                <td>
                                    <strong>Rs {{ SolarMitraHelper::format_number($amount) }}/-</strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @endif 

                <!-- Additional Cost Section -->
                <h4 class="table-header">{{ __('solarmitra::solarmitra.additional_cost_customer') }}</h4>
                <div>
                    <div class="diagrams">
                        <img src="{{asset('modules/solarmitra/images/pic-structure-1.png')}}" alt="structure-1">
                        <img src="{{asset('modules/solarmitra/images/pic-structure-2.png')}}" alt="structure-2">
                        <img src="{{asset('modules/solarmitra/images/pic-structure-3.png')}}" alt="structure-3">
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>{{ __('solarmitra::solarmitra.start_side') }}</th>
                                <th>{{ __('solarmitra::solarmitra.end_side') }}</th>
                                <th>{{ __('solarmitra::solarmitra.rate') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>7 Ft</td>
                                <td>9 Ft</td>
                                <td>Included in cost</td>
                            </tr>
                            <tr>
                                <td>10 Ft</td>
                                <td>12 Ft</td>
                                <td>Rs 1000 / KW</td>
                            </tr>
                            <tr>
                                <td>Up To 17 Ft</td>
                                <td>Up To 19 Ft</td>
                                <td>Rs 1500 / KW</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Payment Section -->
                <div class="payment-section">
                    <h3 class="section-heading">{{ __('solarmitra::solarmitra.payment') }}</h3>
                    <div class="list-item">20% Advance For Structure</div>
                    <div class="list-item">75% For Panel & Inverter Structure Completed</div>
                    <div class="list-item">5% After Generation Start With In 4 Days</div>
                </div>

                <!-- Project Organization -->
                <div class="organization-section">
                    <h3 class="section-heading">{{ __('solarmitra::solarmitra.project_organization') }}</h3>
                    <p style="font-size: 12px;">45 days from the date of Receipt Solar NOC of DISCOM & Commerically Clear Order and Advance Payment.</p>
                    <p style="font-size: 12px;">Validity of Offer 30 Days from the date of offer .After this period will not remain Valid.</p>
                </div>

                <!-- Customer Scope -->
                <div class="scope-section">
                    <h3 class="section-heading">{{ __('solarmitra::solarmitra.customer_scope') }}</h3>
                    <div class="list-item">Approach way/Stairs to reach at roof/location where solar plant to be Installed.</div>
                    <div class="list-item">Electricity & Water shall be provided by customer during plant Installation.</div>
                    <div class="list-item">Internet connection through GPRS SIM Card/Wi-Fi for remote monitoring system.</div>
                    <div class="list-item">All Discom fees payment deposit shall be in customer scope.</div>
                </div>

                <!-- Project Copmletion -->
                <div class="organization-section">
                    <h3 class="section-heading">{{ __('solarmitra::solarmitra.project_completion') }}</h3>
                    <p style="font-size: 12px;">5 year free maintenance service, which includes site visit and attend faults .any Spare/material replacementshall not be part of this service. all material replacement under warranty shall be done by manufacturer of that spare/equipments only as per manufacturer T&C. Regular cleaning of panel will be Clint/customer scope.</p>
                    
                    <div class="note-box">
                        <p><span>NOTE : </span> Any major modification in size, structure or electrical fitting of plant will lead to change in price.</p>
                    </div>

                    <p style="font-size: 12px; margin-bottom: 10px;">Solar panel comes with 12 year manufacturing defect warranty and 30 year Performance warranty. Fuse and SPD's are not covered under warranty. All other electrical parts are having 1 year warranty.</p>

                    <p style="font-size: 12px; margin-bottom: 10px;">Goods once sold will not b returned.</p>
                    
                    <p style="font-size: 12px; margin-bottom: 10px;">All demand issued by KEDl/JVVNL not include in this prices.</p>

                    <p style="font-size: 12px; margin-bottom: 10px;">Electrical inspector fees not include in this prices</p>

                    <p style="font-size: 12px; margin-bottom: 10px;">There is no responsibility of physical damage and natural disaster after installations.</p>
                </div>

                <!-- Transportation -->
                <h3 class="section-heading">{{ __('solarmitra::solarmitra.transportation') }}</h3>
                <p style="font-size: 13px; margin: 15px 0;">All transportation included of above mentioned Material up to the installation site.</p>

                <!-- Documents Required -->
                <div class="documents-section">
                    <h3 class="section-heading">{{ __('solarmitra::solarmitra.documents_required') }}</h3>
                    <div class="doc-grid">
                        <div>
                            <div class="doc-item">Passport Size Photo</div>
                            <div class="doc-item">Cancel Cheque</div>
                        </div>
                        <div>
                            <div class="doc-item">{{ __('solarmitra::solarmitra.aadhar_card') }}</div>
                            <div class="doc-item">Properties Paper</div>
                        </div>
                        <div>
                            <div class="doc-item">{{ __('solarmitra::solarmitra.electricity_bill') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Bank Account Details -->
                @php
                    $bank_account = $business->bank_accounts->firstWhere('is_primary',1);
                @endphp
                @if (SolarMitraHelper::getBusinessConfig('show_company_bank_details', true))
                <h3 class="section-heading">{{ __('solarmitra::solarmitra.bank_details') }}</h3>
                <div class="bank-details">
                    <p style="font-size: 13px; color: #363636; margin-bottom: 15px;">This is to Certify that the below is Bank A/C details of <span style="color: #101010; font-weight: 500;">{{$business->company_name}}</span></p>
                     
                    <table class="bank-grid">
						<tr>	
							<td class="bank-label" width="120">{{ __('solarmitra::solarmitra.account_holder_name') }}</td>
							<td class="bank-value">{{@$bank_account->account_holder}}</td>
                        </tr>
						<tr>
							<td class="bank-label">Bank Name</td>
							<td class="bank-value">{{@$bank_account->bank_name}}</td>
                        </tr>
						<tr>
							<td class="bank-label">{{ __('solarmitra::solarmitra.account_number_label') }}</td>
							<td class="bank-value">{{@$bank_account->account_number}}</td>
                        </tr>
						<tr>
							<td class="bank-label">IFSC Code</td>
							<td class="bank-value">{{@$bank_account->ifsc_code}}</td>
                        </tr>
						<tr>
							<td class="bank-label">Address</td>
							<td class="bank-value">{{@$bank_account->bank_address}}</td>
                        </tr>
						<tr>
							<td class="bank-label">GSTIN</td>
							<td class="bank-value">{{$business->gst_no}}</td>
						</tr>	
                    </table>
                    <div class="scaner">
                        @if (is_file(public_path('storage/solarmitra-attachments/business_'.optional(@$bank_account->attachment)->business_id.'/'.optional(@$bank_account->attachment)->file_name)))
                        <img src="{{public_path('storage/solarmitra-attachments/business_'.optional(@$bank_account->attachment)->business_id.'/'.optional(@$bank_account->attachment)->file_name)}}">
                        @endif
                    </div>
                </div>
                @endif
                
            </div>

            <!-- Footer -->
            <div class="page-footer">
                <div class="footer-logo-icon">
                    <svg width="200" height="57" viewBox="0 0 200 57" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_1163_2)">
                            <mask id="mask0_1163_2" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="200" height="57">
                                <path d="M200 0H0V57H200V0Z" fill="white"/>
                            </mask>
                            <g mask="url(#mask0_1163_2)">
                                <path d="M86.5155 24.7252H82.4752L77.2221 18.5684H73.9514V24.7252H70.5469V6.28906C73.4077 6.28906 76.2685 6.28906 79.1209 6.28906C83.3787 6.28906 85.612 9.20093 85.612 12.386C85.612 14.9478 84.4828 17.4583 81.0532 18.167L86.5155 24.4518V24.7252ZM73.9682 9.55103V15.443H79.1376C79.5351 15.4739 79.9346 15.4208 80.3108 15.2868C80.6873 15.1526 81.0324 14.9407 81.3248 14.6641C81.6172 14.3875 81.8505 14.0522 82.0099 13.6794C82.1694 13.3065 82.2518 12.904 82.2518 12.497C82.2518 12.0901 82.1694 11.6876 82.0099 11.3147C81.8505 10.9418 81.6172 10.6065 81.3248 10.3299C81.0324 10.0534 80.6873 9.8414 80.3108 9.70737C79.9346 9.57334 79.5351 9.5201 79.1376 9.55103H73.9682Z" fill="#214FA2"/>
                                <path d="M90.3466 19.3933C90.5557 20.9986 91.9192 22.1515 94.1359 22.1515C95.3741 22.1708 96.5794 21.7447 97.5404 20.9475L99.5481 22.9712C98.0614 24.3655 96.104 25.1183 94.0857 25.0719C89.711 25.0719 87.1094 22.3137 87.1094 18.1551C87.1094 14.2101 89.736 11.375 93.8515 11.375C98.1009 11.375 100.761 14.0563 100.267 19.3933H90.3466ZM97.256 16.7375C97.0469 15.0298 95.7586 14.1759 93.9602 14.1759C93.1683 14.1138 92.3798 14.3357 91.731 14.8033C91.082 15.2709 90.6131 15.9551 90.4051 16.7375H97.256Z" fill="#214FA2"/>
                                <path d="M115.574 11.7358L110.161 24.7752H106.765L101.328 11.7358H104.749L106.506 16.0054L108.463 21.4705L110.396 16.0567L112.144 11.7188L115.574 11.7358Z" fill="#214FA2"/>
                                <path d="M119.761 19.3933C119.97 20.9986 121.334 22.1515 123.55 22.1515C124.786 22.1711 125.989 21.7447 126.947 20.9475L128.954 22.9712C127.471 24.3657 125.516 25.1188 123.5 25.0719C119.117 25.0719 116.516 22.3137 116.516 18.1551C116.516 14.2101 119.142 11.375 123.266 11.375C127.39 11.375 130.167 14.0563 129.682 19.3933H119.761ZM126.662 16.7375C126.461 15.0298 125.173 14.1759 123.366 14.1759C122.575 14.1171 121.788 14.3404 121.14 14.8075C120.492 15.2745 120.022 15.9566 119.811 16.7375H126.662Z" fill="#214FA2"/>
                                <path d="M135.013 11.7663L135.238 13.2608C135.604 12.6402 136.135 12.1383 136.768 11.8133C137.401 11.4883 138.112 11.3536 138.818 11.4248C140.022 11.4027 141.19 11.8448 142.09 12.663L140.675 15.4468C140.372 15.1585 140.016 14.9346 139.626 14.788C139.237 14.6415 138.824 14.5751 138.409 14.5928C137.979 14.5555 137.545 14.6152 137.141 14.7681C136.736 14.9208 136.371 15.1627 136.067 15.4766C135.764 15.7905 135.533 16.1686 135.39 16.5841C135.247 16.9996 135.194 17.4422 135.238 17.8804V24.7118H132.102V11.7663H135.013Z" fill="#214FA2"/>
                                <path d="M145.948 19.3933C146.157 20.9986 147.52 22.1515 149.738 22.1515C150.973 22.1711 152.176 21.7447 153.134 20.9475L155.142 22.9712C153.657 24.3643 151.703 25.1169 149.687 25.0719C145.304 25.0719 142.703 22.3137 142.703 18.1551C142.703 14.2101 145.33 11.375 149.453 11.375C153.577 11.375 156.355 14.0563 155.869 19.3933H145.948ZM152.849 16.7375C152.649 15.0298 151.36 14.1759 149.553 14.1759C148.763 14.1171 147.975 14.3404 147.327 14.8075C146.679 15.2745 146.209 15.9566 145.998 16.7375H152.849Z" fill="#214FA2"/>
                                <path d="M167.63 24.7307V17.9506C167.63 15.978 166.577 14.475 164.569 14.475C164.12 14.4879 163.677 14.593 163.269 14.7839C162.86 14.9749 162.495 15.2479 162.191 15.5865C161.888 15.9251 161.655 16.3226 161.506 16.7552C161.357 17.1877 161.295 17.6465 161.322 18.1042V24.7307H158.203V11.7425H161.014L161.223 13.5017C161.749 12.8983 162.393 12.4136 163.113 12.0784C163.834 11.7432 164.614 11.5648 165.404 11.5547C168.399 11.5547 170.793 13.8431 170.793 17.9164V24.7478L167.63 24.7307Z" fill="#214FA2"/>
                                <path d="M184.369 23.0704C183.738 23.7414 182.978 24.2703 182.134 24.6233C181.292 24.9762 180.386 25.1453 179.476 25.1199C175.795 25.1199 172.734 22.857 172.734 18.2885C172.734 13.72 175.795 11.4572 179.476 11.4572C180.33 11.4255 181.181 11.5806 181.971 11.9119C182.762 12.2433 183.473 12.7433 184.06 13.3784L182.077 15.5048C181.378 14.8556 180.471 14.491 179.526 14.48C179.034 14.4675 178.544 14.5592 178.087 14.7493C177.631 14.9395 177.218 15.224 176.875 15.585C176.532 15.9458 176.266 16.3754 176.092 16.8465C175.92 17.3178 175.844 17.8203 175.871 18.3227C175.835 18.8201 175.903 19.3197 176.069 19.7884C176.236 20.2571 176.499 20.6843 176.84 21.0419C177.181 21.3994 177.591 21.6791 178.046 21.8624C178.5 22.0457 178.987 22.1286 179.476 22.1055C179.987 22.1241 180.496 22.0386 180.974 21.8538C181.454 21.6691 181.891 21.3889 182.262 21.0295L184.369 23.0704Z" fill="#214FA2"/>
                                <path d="M188.957 19.3933C189.167 20.9986 190.529 22.1515 192.747 22.1515C193.982 22.1711 195.185 21.7447 196.143 20.9475L198.151 22.9712C196.663 24.3655 194.706 25.1183 192.688 25.0719C188.314 25.0719 185.711 22.3137 185.711 18.1551C185.711 14.2101 188.339 11.375 192.462 11.375C196.711 11.375 199.363 14.0563 198.87 19.3933H188.957ZM195.858 16.7375C195.658 15.0298 194.369 14.1759 192.563 14.1759C191.771 14.1171 190.984 14.3404 190.336 14.8075C189.687 15.2745 189.218 15.9566 189.008 16.7375H195.858Z" fill="#214FA2"/>
                                <path d="M81.6462 34.0496C81.1445 33.386 80.495 32.8539 79.7517 32.4976C79.0083 32.1411 78.1926 31.9707 77.3718 32.0002C74.8624 32.0002 73.6411 33.0762 73.6411 34.4423C73.6411 36.0478 75.4897 36.4918 77.6562 36.7565C81.4204 37.2262 84.917 38.2253 84.917 42.6229C84.917 46.7217 81.3619 48.4808 77.3468 48.4808C73.6662 48.4808 70.8305 47.3281 69.4922 43.9636L72.3278 42.4607C73.1642 44.4845 75.2136 45.3812 77.397 45.3812C79.5801 45.3812 81.5793 44.6211 81.5793 42.6229C81.5793 40.9152 79.806 40.1722 77.397 39.9074C73.7164 39.4635 70.3119 38.4644 70.3119 34.3399C70.3119 30.5486 73.9756 29.003 77.2966 28.9688C80.0988 28.9688 83.0098 29.8227 84.3816 32.6235L81.6462 34.0496Z" fill="#214FA2"/>
                                <path d="M100.451 41.5481C100.449 42.88 100.061 44.1817 99.3359 45.2891C98.6106 46.3964 97.5805 47.2597 96.3752 47.7702C95.1701 48.2807 93.8437 48.4155 92.5636 48.1577C91.2834 47.8998 90.1066 47.2609 89.1817 46.3215C88.2567 45.3819 87.6249 44.1838 87.3658 42.8784C87.1069 41.5729 87.2323 40.2182 87.7262 38.9853C88.2203 37.7525 89.0608 36.6964 90.1418 35.9505C91.2228 35.2045 92.496 34.8019 93.8008 34.7936C94.68 34.7603 95.5565 34.9119 96.3759 35.2392C97.1952 35.5664 97.9399 36.0621 98.5636 36.6956C99.1871 37.3291 99.6766 38.0868 100.001 38.9216C100.326 39.7563 100.479 40.6504 100.451 41.5481ZM90.413 41.5481C90.413 43.5205 91.5674 45.3651 93.8593 45.3651C96.1512 45.3651 97.314 43.5205 97.314 41.5481C97.3376 41.0638 97.2666 40.5796 97.105 40.1237C96.9436 39.6677 96.6948 39.2492 96.3732 38.8924C96.0518 38.5355 95.6638 38.2476 95.2323 38.0452C94.8007 37.8429 94.334 37.7303 93.8593 37.7139C91.5591 37.7053 90.3796 39.5926 90.3796 41.5481H90.413Z" fill="#214FA2"/>
                                <path d="M105.721 29.5938V47.9786H102.609V29.5938H105.721Z" fill="#214FA2"/>
                                <path d="M111.708 35.049V41.8292C111.708 43.8017 112.762 45.3046 114.77 45.3046C115.219 45.2918 115.661 45.1868 116.069 44.9958C116.478 44.8049 116.844 44.532 117.147 44.1933C117.45 43.8546 117.683 43.4571 117.832 43.0245C117.981 42.592 118.044 42.1332 118.015 41.6755V35.049H121.127V48.0372H118.316L118.107 46.2782C117.569 46.8979 116.907 47.3919 116.165 47.7265C115.423 48.0611 114.619 48.2282 113.808 48.2166C110.771 48.2166 108.555 45.8768 108.555 41.8548V35.0234L111.708 35.049Z" fill="#214FA2"/>
                                <path d="M128.334 31.3984V35.0789H131.839V37.837H128.309V43.4387C128.275 43.6773 128.294 43.9207 128.363 44.1509C128.433 44.3813 128.553 44.5926 128.714 44.7696C128.874 44.9465 129.071 45.0845 129.291 45.1733C129.51 45.2623 129.747 45.2998 129.982 45.2832C130.513 45.2673 131.033 45.1303 131.505 44.8819L132.383 47.6229C131.558 47.9723 130.675 48.1578 129.782 48.1694C127.021 48.2804 125.223 46.6751 125.223 43.4387V37.837H122.797V35.0789H125.173V31.74L128.334 31.3984Z" fill="#214FA2"/>
                                <path d="M137.612 31.3957C137.612 31.8985 137.416 32.3808 137.068 32.7363C136.72 33.0918 136.248 33.2914 135.755 33.2914C135.263 33.2914 134.79 33.0918 134.441 32.7363C134.094 32.3808 133.898 31.8985 133.898 31.3957C133.898 30.8931 134.094 30.4108 134.441 30.0553C134.79 29.6998 135.263 29.5 135.755 29.5C136.248 29.5 136.72 29.6998 137.068 30.0553C137.416 30.4108 137.612 30.8931 137.612 31.3957ZM134.183 34.9993V48.0131H137.328V34.9993H134.183Z" fill="#214FA2"/>
                                <path d="M153.06 41.5498C153.059 42.88 152.672 44.18 151.949 45.2863C151.225 46.3925 150.198 47.2559 148.994 47.7675C147.791 48.2792 146.468 48.4165 145.188 48.162C143.909 47.9077 142.733 47.273 141.806 46.3376C140.88 45.4024 140.244 44.2084 139.98 42.9057C139.717 41.6031 139.836 40.2499 140.325 39.0163C140.812 37.7827 141.645 36.7239 142.721 35.9728C143.796 35.2218 145.065 34.8121 146.369 34.7953C147.251 34.756 148.133 34.9032 148.957 35.2278C149.78 35.5523 150.53 36.0471 151.159 36.6813C151.787 37.3153 152.28 38.0752 152.608 38.9129C152.935 39.7506 153.089 40.6484 153.06 41.5498ZM143.023 41.5498C143.023 43.5224 144.176 45.3668 146.469 45.3668C148.761 45.3668 149.923 43.5224 149.923 41.5498C149.947 41.0655 149.876 40.5813 149.714 40.1254C149.553 39.6696 149.305 39.2509 148.983 38.8941C148.661 38.5373 148.273 38.2493 147.841 38.0471C147.411 37.8446 146.943 37.7321 146.469 37.7157C144.168 37.7072 142.99 39.5943 142.99 41.5498H143.023Z" fill="#214FA2"/>
                                <path d="M164.567 48.012V41.2233C164.567 39.2507 163.505 37.7563 161.498 37.7563C161.049 37.7692 160.607 37.8742 160.199 38.0652C159.79 38.2561 159.423 38.529 159.121 38.8677C158.817 39.2064 158.584 39.6039 158.436 40.0365C158.286 40.469 158.224 40.9278 158.252 41.3855V48.012H155.141V35.0238H157.926L158.135 36.783C158.662 36.1811 159.306 35.6976 160.027 35.3625C160.746 35.0275 161.526 34.8481 162.317 34.8359C165.304 34.8359 167.696 37.1244 167.696 41.1977V48.0291L164.567 48.012Z" fill="#214FA2"/>
                                <path d="M178.709 38.493C178.287 38.0967 177.791 37.7906 177.251 37.5927C176.711 37.3946 176.138 37.3089 175.565 37.3403C174.076 37.3403 173.247 37.8099 173.247 38.6297C173.247 39.4494 173.993 39.9447 175.615 40.0471C178.015 40.2009 181.052 40.7559 181.052 44.1973C181.052 46.4857 179.22 48.4668 175.59 48.4668C174.508 48.5404 173.423 48.3714 172.411 47.9716C171.399 47.5718 170.485 46.951 169.734 46.1527L171.281 43.8641C172.488 44.9714 174.035 45.6146 175.656 45.683C176.844 45.683 177.949 45.0768 177.949 44.1289C177.949 43.1811 177.23 42.865 175.439 42.7626C173.039 42.5747 170.186 41.6867 170.186 38.7406C170.186 35.7947 173.198 34.7187 175.497 34.7187C176.391 34.6576 177.288 34.7769 178.136 35.07C178.985 35.3629 179.767 35.824 180.442 36.4266L178.709 38.493Z" fill="#214FA2"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M15.2552 23.2689C15.0713 23.081 14.9625 22.9528 14.837 22.8333C11.4911 19.4177 8.14513 16.002 4.7992 12.5863C4.53152 12.3216 4.53989 12.1935 4.7992 11.9373C5.5102 11.2457 6.2045 10.5284 6.8904 9.81107C7.07443 9.61467 7.17481 9.5549 7.40067 9.81107C11.0645 13.5683 14.7339 17.3199 18.4089 21.0657C18.904 21.5646 19.2412 22.2036 19.3771 22.9001C19.513 23.5967 19.4412 24.3187 19.1711 24.9733C18.9009 25.6277 18.4449 26.1846 17.8617 26.5718C17.2784 26.959 16.595 27.1589 15.8993 27.1457C13.0888 27.1457 10.2782 27.1457 7.46758 27.1457C7.24173 27.1457 7.15808 27.0859 7.16644 26.8467C7.16644 25.7623 7.16644 24.6863 7.16644 23.6019C7.16644 23.2602 7.34211 23.2944 7.55124 23.2944H15.2552V23.2689Z" fill="#214FA2"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M40.6594 23.2696H41.4959C46.1383 23.2696 50.7725 23.2696 55.4067 23.2696C55.8165 23.2696 55.8835 23.3892 55.8751 23.7648C55.8751 24.7724 55.8751 25.7801 55.8751 26.7877C55.8751 27.0695 55.7914 27.1293 55.5238 27.1293C50.371 27.1293 45.2182 27.1293 40.0655 27.1293C39.3472 27.1745 38.6337 26.9821 38.0309 26.5806C37.4281 26.1791 36.9683 25.59 36.7195 24.9006C36.4289 24.2245 36.3607 23.4705 36.5251 22.7517C36.6894 22.0328 37.0777 21.3875 37.6313 20.9127C37.899 20.6566 38.1583 20.3833 38.4177 20.1186C40.0906 18.4108 41.7636 16.7029 43.4365 14.995C43.6791 14.7474 43.7962 14.7559 44.022 14.995C44.683 15.6954 45.3521 16.3869 46.0464 17.0616C46.3224 17.3263 46.3643 17.4715 46.0464 17.7789C44.2647 19.5721 42.4913 21.391 40.6594 23.2696Z" fill="#214FA2"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M40.6602 34.0629C44.232 37.7006 47.7119 41.2529 51.1916 44.788C51.3756 44.9759 51.4426 45.087 51.1916 45.3175C50.4471 46.0434 49.7278 46.7862 49.0084 47.5462C48.8243 47.7342 48.7323 47.7511 48.5316 47.5462C44.8594 43.7805 41.1621 40.0317 37.4899 36.2574C36.9895 35.7702 36.6492 35.1368 36.5159 34.444C36.3826 33.7513 36.4627 33.0335 36.7455 32.3892C36.9968 31.7339 37.4402 31.1739 38.0152 30.7857C38.5902 30.3974 39.2686 30.1999 39.9576 30.2202H48.3225C48.6152 30.2202 48.7239 30.2715 48.7239 30.596C48.7239 31.6206 48.7239 32.6453 48.7239 33.6615C48.7239 34.0202 48.6152 34.08 48.2973 34.08C45.9133 34.08 43.5294 34.08 41.1454 34.08L40.6602 34.0629Z" fill="#214FA2"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M33.2897 15.5615C33.3637 15.4352 33.4476 15.3152 33.5407 15.2028C36.8865 11.7871 40.2549 8.343 43.6453 4.8704C43.9047 4.6057 44.0301 4.6057 44.2811 4.8704C44.967 5.61331 45.678 6.3306 46.3974 7.03936C46.5982 7.23576 46.5815 7.32969 46.3974 7.5261C42.7224 11.2606 39.0587 14.9979 35.406 18.738C34.9709 19.1984 34.4223 19.5306 33.8179 19.6997C33.2135 19.8688 32.5758 19.8687 31.9716 19.6992C31.3673 19.5296 30.8188 19.1972 30.384 18.7365C29.9492 18.2759 29.644 17.7042 29.5004 17.0814C29.4378 16.7871 29.4123 16.4857 29.4251 16.1848C29.4251 13.3755 29.4251 10.5746 29.4251 7.76519C29.4251 7.42362 29.4836 7.29553 29.8517 7.30407C30.822 7.33823 31.7923 7.33823 32.7627 7.30407C33.1391 7.30407 33.181 7.43216 33.181 7.75665C33.181 10.3184 33.181 12.8802 33.181 15.4419L33.2897 15.5615Z" fill="#214FA2"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M22.7979 41.7459C19.2596 45.3494 15.8049 48.8761 12.3586 52.4028C12.0993 52.676 11.9655 52.7273 11.6894 52.4028C11.0119 51.6513 10.2925 50.9425 9.56474 50.2253C9.39744 50.063 9.37234 49.9692 9.56474 49.7812C13.2537 46.0326 16.9259 42.2582 20.6231 38.5095C21.0958 37.9946 21.713 37.6419 22.3901 37.4998C23.067 37.3576 23.7706 37.4329 24.404 37.7153C25.0702 37.9721 25.6407 38.4357 26.0354 39.0407C26.43 39.6458 26.6289 40.3619 26.604 41.0884C26.604 43.9148 26.604 46.7412 26.604 49.5678C26.604 49.9094 26.5203 49.9947 26.1857 49.9863C25.1987 49.9863 24.2115 49.9863 23.2329 49.9863C22.8983 49.9863 22.8147 49.9094 22.8147 49.5678C22.8147 47.0914 22.8147 44.615 22.8147 42.1302L22.7979 41.7459Z" fill="#214FA2"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M17.1001 9.68949L22.7965 15.5133V15.0009C22.7965 10.1506 22.7965 5.31173 22.7965 0.484249C22.7965 0.142682 22.8552 0.0231344 23.2148 0.0316735C24.2018 0.0316735 25.1889 0.0316735 26.176 0.0316735C26.4603 0.0316735 26.5774 0.0743716 26.5774 0.4074C26.5774 5.71024 26.5774 11.0216 26.5774 16.3159C26.6048 17.0231 26.4125 17.7211 26.0279 18.3101C25.6434 18.8991 25.0862 19.3487 24.4361 19.595C23.8235 19.8879 23.1362 19.9772 22.4715 19.85C21.8066 19.7229 21.1976 19.3857 20.7304 18.8862C18.681 16.8538 16.6818 14.7703 14.6576 12.7124C14.5488 12.5928 14.4149 12.5074 14.599 12.3196C15.4104 11.4486 16.2301 10.5861 17.1001 9.68949Z" fill="#214FA2"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M15.1576 34.0629H13.7523C9.31892 34.0629 4.88555 34.0629 0.460541 34.0629C0.0924868 34.0629 -0.00789095 33.969 0.000473909 33.5933C0.000473909 32.5771 0.000473909 31.5524 0.000473909 30.5362C0.000473909 30.2886 0.00047441 30.2033 0.30161 30.2033C5.5882 30.2033 10.8664 30.2033 16.153 30.2033C16.8153 30.1973 17.4628 30.4045 18.0033 30.7954C18.5438 31.1862 18.9501 31.7409 19.1644 32.3807C19.4499 33.0001 19.5389 33.6951 19.4189 34.3686C19.2991 35.0423 18.976 35.6608 18.4952 36.1379C16.496 38.2385 14.4383 40.288 12.4139 42.3629C12.2717 42.5167 12.1797 42.5594 12.0041 42.3629C11.2596 41.5859 10.5235 40.8174 9.7539 40.066C9.52805 39.8524 9.61169 39.7586 9.7539 39.5877C11.5105 37.8116 13.2504 36.0184 14.9987 34.2422C15.0547 34.1943 15.1165 34.1541 15.1826 34.1227C15.1995 34.1312 15.1743 34.097 15.1576 34.0629Z" fill="#214FA2"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M33.1561 41.8189C33.1207 41.959 33.1207 42.1059 33.1561 42.2458C33.1561 47.1132 33.1561 51.9805 33.1561 56.8564C33.1561 57.2407 33.0642 57.3176 32.7044 57.3089C31.7174 57.3089 30.7304 57.3089 29.7432 57.3089C29.4672 57.3089 29.4003 57.2407 29.4003 56.9589C29.4003 51.6219 29.4003 46.2935 29.4003 40.9564C29.3769 40.2585 29.5719 39.5711 29.9569 38.9938C30.3419 38.4165 30.897 37.9793 31.5418 37.7458C32.1726 37.4532 32.8779 37.3717 33.557 37.5127C34.236 37.6538 34.854 38.0103 35.3226 38.5313C36.6693 39.872 37.9911 41.2467 39.321 42.6045C39.9734 43.2706 40.626 43.9537 41.2952 44.6112C41.4708 44.7821 41.521 44.8845 41.2952 45.0895C40.5423 45.8323 39.7978 46.5838 39.0785 47.3524C38.8777 47.5658 38.7773 47.5231 38.6017 47.3524C36.8729 45.5648 35.133 43.7915 33.3821 42.0324C33.3319 41.9384 33.29 41.8189 33.1561 41.8189Z" fill="#214FA2"/>
                            </g>
                        </g>
                        <defs>
                            <clipPath id="clip0_1163_2">
                                <rect width="200" height="57" fill="white"/>
                            </clipPath>
                        </defs>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/js/all.min.js" integrity="sha512-6BTOlkauINO65nLhXhthZMtepgJSghyimIalb+crKRPhvhmsCdnIuGcVbR5/aQY2A+260iC1OPy1oCdB6pSSwQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
</body>
</html>
