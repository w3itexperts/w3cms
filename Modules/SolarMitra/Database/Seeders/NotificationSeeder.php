<?php

namespace Modules\SolarMitra\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $notifications = [
            [
                'title' => 'Add New Lead',
                'code' => 'LEAD-ANL',
                'table_model' => 'Lead',
                'notification_types' => '1',
                'placeholders' => 'Lead Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#LEADNAME#: Lead Full Name can display with this placeholder.<br />
#LEADDETAIL#: Lead Name - Email - Phone Number can display with this placeholder.<br />
#EMAIL#: Lead Email can display with this placeholder.<br />
#PHONE#: Lead Phone can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Created New Lead #LEADNAME#',
                    'slug' => 'w3-c-m-s:-created-new-lead#-l-e-a-d-n-a-m-e#',
                    'content' => '<p>New Lead Added by: #USERNAME#<br />
Lead Details : #LEADDETAIL#</p>',
                ],
            ],
            [
                'title' => 'Update Lead',
                'code' => 'LEAD-UL',
                'table_model' => 'Lead',
                'notification_types' => '1',
                'placeholders' => 'Lead Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#LEADNAME#: Lead Full Name can display with this placeholder.<br />
#LEADDETAIL#: Lead Name - Email - Phone Number can display with this placeholder.<br />
#EMAIL#: Lead Email can display with this placeholder.<br />
#PHONE#: Lead Phone can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Updated Lead #LEADNAME#',
                    'slug' => 'w3-c-m-s:-updated-lead#-l-e-a-d-n-a-m-e#',
                    'content' => 'Lead Updated by: #USERNAME#<br />
Lead Details : #LEADDETAIL#',
                ],
            ],
            [
                'title' => 'Delete Lead',
                'code' => 'LEAD-DL',
                'table_model' => 'Lead',
                'notification_types' => '1',
                'placeholders' => 'Lead Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#LEADNAME#: Lead Full Name can display with this placeholder.<br />
#LEADDETAIL#: Lead Name - Email - Phone Number can display with this placeholder.<br />
#EMAIL#: Lead Email can display with this placeholder.<br />
#PHONE#: Lead Phone can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Deleted Lead #LEADNAME#',
                    'slug' => 'w3-c-m-s:-deleted-lead#-l-e-a-d-n-a-m-e#',
                    'content' => 'Lead Deleted by: #USERNAME#<br />
Lead Details : #LEADDETAIL#',
                ],
            ],
            [
                'title' => 'Delete Multiple Lead',
                'code' => 'LEAD-DML',
                'table_model' => 'Lead',
                'notification_types' => '1',
                'placeholders' => 'Lead Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#LEADNAME#: Lead Full Name can display with this placeholder.<br />
#LEADDETAIL#: Lead Name - Email - Phone Number can display with this placeholder.<br />
#EMAIL#: Lead Email can display with this placeholder.<br />
#PHONE#: Lead Phone can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Deleted Multiple Leads',
                    'slug' => 'w3-c-m-s:-deleted-multiple-leads',
                    'content' => 'Deleted Multiple Leads by: #USERNAME#',
                ],
            ],
            [
                'title' => 'Assign Lead',
                'code' => 'LEAD-AL',
                'table_model' => 'Lead',
                'notification_types' => '1',
                'placeholders' => 'Lead Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#LEADNAME#: Lead Full Name can display with this placeholder.<br />
#LEADDETAIL#: Lead Name - Email - Phone Number can display with this placeholder.<br />
#EMAIL#: Lead Email can display with this placeholder.<br />
#PHONE#: Lead Phone can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Assign Lead #LEADNAME#',
                    'slug' => 'w3-c-m-s:-assign-lead#-l-e-a-d-n-a-m-e#',
                    'content' => 'Lead Details : #LEADDETAIL#',
                ],
            ],
            [
                'title' => 'Lead Status Change Bulk',
                'code' => 'LEAD-LSCB',
                'table_model' => 'Lead',
                'notification_types' => '1',
                'placeholders' => 'Lead Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#LEADNAME#: Lead Full Name can display with this placeholder.<br />
#LEADDETAIL#: Lead Name - Email - Phone Number can display with this placeholder.<br />
#EMAIL#: Lead Email can display with this placeholder.<br />
#PHONE#: Lead Phone can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Lead Bulk Status Changed',
                    'slug' => 'w3-c-m-s:-lead-bulk-status-changed',
                    'content' => 'Lead Bulk Status Changed by: #USERNAME#<br />
Lead Details : #LEADDETAIL#',
                ],
            ],
            [
                'title' => 'Change Lead Client Group Bulk',
                'code' => 'LEAD-CLCGB',
                'table_model' => 'Lead',
                'notification_types' => '1',
                'placeholders' => 'Lead Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#LEADNAME#: Lead Full Name can display with this placeholder.<br />
#LEADDETAIL#: Lead Name - Email - Phone Number can display with this placeholder.<br />
#EMAIL#: Lead Email can display with this placeholder.<br />
#PHONE#: Lead Phone can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Changed Leads Client Group Bulk',
                    'slug' => 'w3-c-m-s:-changed-leads-client-group-bulk',
                    'content' => 'Changed Leads Client Group Bulk by: #USERNAME#<br />
Lead Details : #LEADDETAIL#',
                ],
            ],
            [
                'title' => 'Change Lead Source Bulk',
                'code' => 'LEAD-CLSB',
                'table_model' => 'Lead',
                'notification_types' => '1',
                'placeholders' => 'Lead Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#LEADNAME#: Lead Full Name can display with this placeholder.<br />
#LEADDETAIL#: Lead Name - Email - Phone Number can display with this placeholder.<br />
#EMAIL#: Lead Email can display with this placeholder.<br />
#PHONE#: Lead Phone can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Lead Bulk Source Changed',
                    'slug' => 'w3-c-m-s:-lead-bulk-source-changed',
                    'content' => 'Lead Bulk Status Changed by: #USERNAME#<br />
Lead Details : #LEADDETAIL#<br />
 ',
                ],
            ],
            [
                'title' => 'Change Lead Potential Bulk',
                'code' => 'LEAD-CLPB',
                'table_model' => 'Lead',
                'notification_types' => '1',
                'placeholders' => 'Lead Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#LEADNAME#: Lead Full Name can display with this placeholder.<br />
#LEADDETAIL#: Lead Name - Email - Phone Number can display with this placeholder.<br />
#EMAIL#: Lead Email can display with this placeholder.<br />
#PHONE#: Lead Phone can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Lead Bulk Potential Changed',
                    'slug' => 'w3-c-m-s:-lead-bulk-potential-changed',
                    'content' => 'Lead Bulk Potential Changed by: #USERNAME#<br />
Lead Details : #LEADDETAIL#',
                ],
            ],
            [
                'title' => 'Export Lead',
                'code' => 'LEAD-EL',
                'table_model' => 'Lead',
                'notification_types' => '1',
                'placeholders' => 'Lead Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#LEADNAME#: Lead Full Name can display with this placeholder.<br />
#LEADDETAIL#: Lead Name - Email - Phone Number can display with this placeholder.<br />
#EMAIL#: Lead Email can display with this placeholder.<br />
#PHONE#: Lead Phone can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Lead Exported',
                    'slug' => 'w3-c-m-s:-lead-exported',
                    'content' => 'Leads Exported by: #USERNAME#',
                ],
            ],
            [
                'title' => 'Import Lead',
                'code' => 'LEAD-IL',
                'table_model' => 'Lead',
                'notification_types' => '1',
                'placeholders' => 'Lead Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#LEADNAME#: Lead Full Name can display with this placeholder.<br />
#LEADDETAIL#: Lead Name - Email - Phone Number can display with this placeholder.<br />
#EMAIL#: Lead Email can display with this placeholder.<br />
#PHONE#: Lead Phone can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Leads Imported',
                    'slug' => 'w3-c-m-s:-leads-imported',
                    'content' => 'Leads Imported by: #USERNAME#',
                ],
            ],
            [
                'title' => 'Add New Client Group',
                'code' => 'CLIENTGROUP-ANCG',
                'table_model' => 'ClientGroup',
                'notification_types' => '1',
                'placeholders' => 'Client Group Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#CLIENTGROUPTITLE#: Client Group Title can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Created New Client Group #CLIENTGROUPTITLE#',
                    'slug' => 'w3-c-m-s:-created-new-client-group#-c-l-i-e-n-t-g-r-o-u-p-t-i-t-l-e#',
                    'content' => 'New Client Group Added by: #USERNAME#<br />
Client Group Details : #CLIENTGROUPTITLE#',
                ],
            ],
            [
                'title' => 'Delete Client Group',
                'code' => 'CLIENTGROUP-DCG',
                'table_model' => 'ClientGroup',
                'notification_types' => '1',
                'placeholders' => 'Client Group Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#CLIENTGROUPTITLE#: Client Group Title can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Deleted Client Group #CLIENTGROUPTITLE#',
                    'slug' => 'w3-c-m-s:-deleted-client-group#-c-l-i-e-n-t-g-r-o-u-p-t-i-t-l-e#',
                    'content' => 'Client Group Deleted by: #USERNAME#<br />
Client Group Details : #CLIENTGROUPTITLE#',
                ],
            ],
            [
                'title' => 'Add New Source',
                'code' => 'SOURCE-ANS',
                'table_model' => 'Source',
                'notification_types' => '1',
                'placeholders' => 'Source Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#SOURCENAME#: Source Name can display with this placeholder.<br />
#TYPE#: Source Type can display with this placeholder.<br />
#CHANNEL#: Source Channel can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Created New Source #SOURCENAME#',
                    'slug' => 'w3-c-m-s:-created-new-source#-s-o-u-r-c-e-n-a-m-e#',
                    'content' => 'New Source Added by: #USERNAME#<br />
Source Details : #SOURCENAME#',
                ],
            ],
            [
                'title' => 'Update Source',
                'code' => 'SOURCE-US',
                'table_model' => 'Source',
                'notification_types' => '1',
                'placeholders' => 'Source Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#SOURCENAME#: Source Name can display with this placeholder.<br />
#TYPE#: Source Type can display with this placeholder.<br />
#CHANNEL#: Source Channel can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Updated Source #SOURCENAME#',
                    'slug' => 'w3-c-m-s:-updated-source#-s-o-u-r-c-e-n-a-m-e#',
                    'content' => 'Source Updated by: #USERNAME#<br />
Source Details : #SOURCENAME#',
                ],
            ],
            [
                'title' => 'Delete Source',
                'code' => 'SOURCE-DS',
                'table_model' => 'Source',
                'notification_types' => '1',
                'placeholders' => 'Source Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#SOURCENAME#: Source Name can display with this placeholder.<br />
#TYPE#: Source Type can display with this placeholder.<br />
#CHANNEL#: Source Channel can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Deleted Source #SOURCENAME#',
                    'slug' => 'w3-c-m-s:-deleted-source#-s-o-u-r-c-e-n-a-m-e#',
                    'content' => 'Lead Source Deleted by: #USERNAME#<br />
Lead Source Details : #SOURCENAME#',
                ],
            ],
            [
                'title' => 'Add New Channel',
                'code' => 'CHANNEL-ANC',
                'table_model' => 'Channel',
                'notification_types' => '1',
                'placeholders' => 'Channel Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#CHANNELTITLE#: Channel Title can display with this placeholder.<br />
#DESCRIPTION#: Channel Description can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Created New Channel #CHANNELTITLE#',
                    'slug' => 'w3-c-m-s:-created-new-channel#-c-h-a-n-n-e-l-t-i-t-l-e#',
                    'content' => 'New Channel Added by: #USERNAME#<br />
Channel Details : #CHANNELTITLE#',
                ],
            ],
            [
                'title' => 'Update Channel',
                'code' => 'CHANNEL-UC',
                'table_model' => 'Channel',
                'notification_types' => '1',
                'placeholders' => 'Channel Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#CHANNELTITLE#: Channel Title can display with this placeholder.<br />
#DESCRIPTION#: Channel Description can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Updated Channel #CHANNELTITLE#',
                    'slug' => 'w3-c-m-s:-updated-channel#-c-h-a-n-n-e-l-t-i-t-l-e#',
                    'content' => 'Channel Updated by: #USERNAME#<br />
Channel Details : #CHANNELTITLE#',
                ],
            ],
            [
                'title' => 'Delete Channel',
                'code' => 'CHANNEL-DC',
                'table_model' => 'Channel',
                'notification_types' => '1',
                'placeholders' => 'Channel Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#CHANNELTITLE#: Channel Title can display with this placeholder.<br />
#DESCRIPTION#: Channel Description can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Deleted Channel #CHANNELTITLE#',
                    'slug' => 'w3-c-m-s:-deleted-channel#-c-h-a-n-n-e-l-t-i-t-l-e#',
                    'content' => 'Channel Deleted by: #USERNAME#<br />
Channel Details : #CHANNELTITLE#',
                ],
            ],
            [
                'title' => 'Add New Campaign',
                'code' => 'CAMPAIGN-ANC',
                'table_model' => 'Campaign',
                'notification_types' => '1',
                'placeholders' => 'Campaign Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#PURPOSE#: Campaign Purpose can display with this placeholder.<br />
#CHANNEL#: Campaign Channel can display with this placeholder.<br />
#SOURCE#: Campaign Source can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Created New Campaign #PURPOSE#',
                    'slug' => 'w3-c-m-s:-created-new-campaign#-p-u-r-p-o-s-e#',
                    'content' => 'New Campaign Added by: #USERNAME#<br />
Campaign Details : #PURPOSE#',
                ],
            ],
            [
                'title' => 'Update Campaign',
                'code' => 'CAMPAIGN-UC',
                'table_model' => 'Campaign',
                'notification_types' => '1',
                'placeholders' => 'Campaign Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#PURPOSE#: Campaign Purpose can display with this placeholder.<br />
#CHANNEL#: Campaign Channel can display with this placeholder.<br />
#SOURCE#: Campaign Source can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Updated Campaign #PURPOSE#',
                    'slug' => 'w3-c-m-s:-updated-campaign#-p-u-r-p-o-s-e#',
                    'content' => 'Campaign Updatet by: #USERNAME#<br />
Campaign Details : #PURPOSE#',
                ],
            ],
            [
                'title' => 'Delete Campaign',
                'code' => 'CAMPAIGN-DC',
                'table_model' => 'Campaign',
                'notification_types' => '1',
                'placeholders' => 'Campaign Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#PURPOSE#: Campaign Purpose can display with this placeholder.<br />
#CHANNEL#: Campaign Channel can display with this placeholder.<br />
#SOURCE#: Campaign Source can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Deleted Campaign #PURPOSE#',
                    'slug' => 'w3-c-m-s:-deleted-campaign#-p-u-r-p-o-s-e#',
                    'content' => 'Campaign Deleted by: #USERNAME#<br />
Campaign Details : #PURPOSE#',
                ],
            ],
            [
                'title' => 'Add New Invoice',
                'code' => 'INVOICE-ANI',
                'table_model' => 'Invoice',
                'notification_types' => '1',
                'placeholders' => 'Invoice Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#INVOICETITLE#: Invoice Title can display with this placeholder.<br />
#CLIENTNAME#: Invoice Client Name can display with this placeholder.<br />
#INVOICENUMBER#: Invoice Number can display with this placeholder.<br />
#TOTALAMOUNT#: Invoice Total Amount can display with this placeholder.<br />
#STATUS#: Invoice Status can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Created New Invoice #INVOICETITLE#',
                    'slug' => 'w3-c-m-s:-created-new-invoice#-i-n-v-o-i-c-e-t-i-t-l-e#',
                    'content' => 'New Invoice Added by: #USERNAME#<br />
Invoice Details : #INVOICETITLE#',
                ],
            ],
            [
                'title' => 'Update Invoice',
                'code' => 'INVOICE-UI',
                'table_model' => 'Invoice',
                'notification_types' => '1',
                'placeholders' => 'Invoice Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#INVOICETITLE#: Invoice Title can display with this placeholder.<br />
#CLIENTNAME#: Invoice Client Name can display with this placeholder.<br />
#INVOICENUMBER#: Invoice Number can display with this placeholder.<br />
#TOTALAMOUNT#: Invoice Total Amount can display with this placeholder.<br />
#STATUS#: Invoice Status can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Updated Invoice #INVOICETITLE#',
                    'slug' => 'w3-c-m-s:-updated-invoice#-i-n-v-o-i-c-e-t-i-t-l-e#',
                    'content' => 'Invoice Updated by: #USERNAME#<br />
Invoice Details : #INVOICETITLE#',
                ],
            ],
            [
                'title' => 'Delete Invoice',
                'code' => 'INVOICE-DI',
                'table_model' => 'Invoice',
                'notification_types' => '1',
                'placeholders' => 'Invoice Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#INVOICETITLE#: Invoice Title can display with this placeholder.<br />
#CLIENTNAME#: Invoice Client Name can display with this placeholder.<br />
#INVOICENUMBER#: Invoice Number can display with this placeholder.<br />
#TOTALAMOUNT#: Invoice Total Amount can display with this placeholder.<br />
#STATUS#: Invoice Status can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Deleted Invoice #INVOICETITLE#',
                    'slug' => 'w3-c-m-s:-deleted-invoice#-i-n-v-o-i-c-e-t-i-t-l-e#',
                    'content' => 'Invoice Deleted by: #USERNAME#<br />
Invoice Details : #INVOICETITLE#',
                ],
            ],
            [
                'title' => 'Download Invoice',
                'code' => 'INVOICE-DLI',
                'table_model' => 'Invoice',
                'notification_types' => '1',
                'placeholders' => 'Invoice Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#INVOICETITLE#: Invoice Title can display with this placeholder.<br />
#CLIENTNAME#: Invoice Client Name can display with this placeholder.<br />
#INVOICENUMBER#: Invoice Number can display with this placeholder.<br />
#TOTALAMOUNT#: Invoice Total Amount can display with this placeholder.<br />
#STATUS#: Invoice Status can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Downloaded Invoice #INVOICETITLE#',
                    'slug' => 'w3-c-m-s:-downloaded-invoice#-i-n-v-o-i-c-e-t-i-t-l-e#',
                    'content' => 'Invoice Downloaded by: #USERNAME#<br />
Invoice Details : #INVOICETITLE#',
                ],
            ],
            [
                'title' => 'Add New Quotation Item',
                'code' => 'QUOTATIONITEM-ANQI',
                'table_model' => 'QuotationItem',
                'notification_types' => '1',
                'placeholders' => 'Quotation Item Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#QUOTATIONITEMTITLE#: Quotation Item Title can display with this placeholder.<br />
#QUOTATIONTITLE#: Quotation Title can display with this placeholder.<br />
#RATESPERUNITS#: Rates Per Units can display with this placeholder.<br />
#AMOUNT#: Amount can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Created New Quotation Item #QUOTATIONITEMTITLE#',
                    'slug' => 'w3-c-m-s:-created-new-quotation-item#-q-u-o-t-a-t-i-o-n-i-t-e-m-t-i-t-l-e#',
                    'content' => 'New Quotation Item Added by: #USERNAME#<br />
Quotation Item Details : #QUOTATIONITEMTITLE#',
                ],
            ],
            [
                'title' => 'Update Quotation Item',
                'code' => 'QUOTATIONITEM-UQI',
                'table_model' => 'QuotationItem',
                'notification_types' => '1',
                'placeholders' => 'Quotation Item Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#QUOTATIONITEMTITLE#: Quotation Item Title can display with this placeholder.<br />
#QUOTATIONTITLE#: Quotation Title can display with this placeholder.<br />
#RATESPERUNITS#: Rates Per Units can display with this placeholder.<br />
#AMOUNT#: Amount can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Updated Quotation Item #QUOTATIONITEMTITLE#',
                    'slug' => 'w3-c-m-s:-updated-quotation-item#-q-u-o-t-a-t-i-o-n-i-t-e-m-t-i-t-l-e#',
                    'content' => 'Quotation Item Updated by: #USERNAME#<br />
Quotation Item Details : #QUOTATIONITEMTITLE#',
                ],
            ],
            [
                'title' => 'Delete Quotation Item',
                'code' => 'QUOTATIONITEM-DQI',
                'table_model' => 'QuotationItem',
                'notification_types' => '1',
                'placeholders' => 'Quotation Item Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#QUOTATIONITEMTITLE#: Quotation Item Title can display with this placeholder.<br />
#QUOTATIONTITLE#: Quotation Title can display with this placeholder.<br />
#RATESPERUNITS#: Rates Per Units can display with this placeholder.<br />
#AMOUNT#: Amount can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Deleted Quotation Item #QUOTATIONITEMTITLE#',
                    'slug' => 'w3-c-m-s:-deleted-quotation-item#-q-u-o-t-a-t-i-o-n-i-t-e-m-t-i-t-l-e#',
                    'content' => 'Quotation Item Deleted by: #USERNAME#<br />
Quotation Item Details : #QUOTATIONITEMTITLE#',
                ],
            ],
            [
                'title' => 'Add New Material Company',
                'code' => 'MATERIALCOMPANY-ANMC',
                'table_model' => 'MaterialCompany',
                'notification_types' => '1',
                'placeholders' => 'Material Company Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#MATERIALCOMPANYTITLE#: Material Company Title can display with this placeholder.<br />
#DESCRIPTION#: Description can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Created New Material Company #MATERIALCOMPANYTITLE#',
                    'slug' => 'w3-c-m-s:-created-new-material-company#-m-a-t-e-r-i-a-l-c-o-m-p-a-n-y-t-i-t-l-e#',
                    'content' => 'New Material Company Added by: #USERNAME#<br />
Material Company Details : #MATERIALCOMPANYTITLE#',
                ],
            ],
            [
                'title' => 'Update Material Company',
                'code' => 'MATERIALCOMPANY-UMC',
                'table_model' => 'MaterialCompany',
                'notification_types' => '1',
                'placeholders' => 'Material Company Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#MATERIALCOMPANYTITLE#: Material Company Title can display with this placeholder.<br />
#DESCRIPTION#: Description can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Updated Material Company #MATERIALCOMPANYTITLE#',
                    'slug' => 'w3-c-m-s:-updated-material-company#-m-a-t-e-r-i-a-l-c-o-m-p-a-n-y-t-i-t-l-e#',
                    'content' => 'Material Company Updated by: #USERNAME#<br />
Material Company Details : #MATERIALCOMPANYTITLE#',
                ],
            ],
            [
                'title' => 'Delete Material Company',
                'code' => 'MATERIALCOMPANY-DMC',
                'table_model' => 'MaterialCompany',
                'notification_types' => '1',
                'placeholders' => 'Material Company Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#MATERIALCOMPANYTITLE#: Material Company Title can display with this placeholder.<br />
#DESCRIPTION#: Description can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Deleted Material Company #MATERIALCOMPANYTITLE#',
                    'slug' => 'w3-c-m-s:-deleted-material-company#-m-a-t-e-r-i-a-l-c-o-m-p-a-n-y-t-i-t-l-e#',
                    'content' => 'Material Company Delete by: #USERNAME#<br />
Material Company Details : #MATERIALCOMPANYTITLE#',
                ],
            ],
            [
                'title' => 'Add New Material',
                'code' => 'MATERIAL-ANM',
                'table_model' => 'Material',
                'notification_types' => '1',
                'placeholders' => 'Material Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#MATERIALTITLE#: Material Title can display with this placeholder.<br />
#DESCRIPTION#: Description can display with this placeholder.<br />
#MATERIALCOMPANY#: Material Company can display with this placeholder.<br />
#MATERIALCATEGORY#: Material Category can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Created New Material #MATERIALTITLE#',
                    'slug' => 'w3-c-m-s:-created-new-material#-m-a-t-e-r-i-a-l-t-i-t-l-e#',
                    'content' => 'New Material Added by: #USERNAME#<br />
Material Details : #MATERIALTITLE#',
                ],
            ],
            [
                'title' => 'Update Material',
                'code' => 'MATERIAL-UM',
                'table_model' => 'Material',
                'notification_types' => '1',
                'placeholders' => 'Material Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#MATERIALTITLE#: Material Title can display with this placeholder.<br />
#DESCRIPTION#: Description can display with this placeholder.<br />
#MATERIALCOMPANY#: Material Company can display with this placeholder.<br />
#MATERIALCATEGORY#: Material Category can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Updated Material #MATERIALTITLE#',
                    'slug' => 'w3-c-m-s:-updated-material#-m-a-t-e-r-i-a-l-t-i-t-l-e#',
                    'content' => 'Material Updated by: #USERNAME#<br />
Material Details : #MATERIALTITLE#',
                ],
            ],
            [
                'title' => 'Delete Material',
                'code' => 'MATERIAL-DM',
                'table_model' => 'Material',
                'notification_types' => '1',
                'placeholders' => 'Material Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#MATERIALTITLE#: Material Title can display with this placeholder.<br />
#DESCRIPTION#: Description can display with this placeholder.<br />
#MATERIALCOMPANY#: Material Company can display with this placeholder.<br />
#MATERIALCATEGORY#: Material Category can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Deleted Material #MATERIALTITLE#',
                    'slug' => 'w3-c-m-s:-deleted-material#-m-a-t-e-r-i-a-l-t-i-t-l-e#',
                    'content' => 'Material Deleted by: #USERNAME#<br />
Material Details : #MATERIALTITLE#',
                ],
            ],
            [
                'title' => 'Export Material',
                'code' => 'MATERIAL-EM',
                'table_model' => 'Material',
                'notification_types' => '1',
                'placeholders' => 'Material Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#MATERIALTITLE#: Material Title can display with this placeholder.<br />
#DESCRIPTION#: Description can display with this placeholder.<br />
#MATERIALCOMPANY#: Material Company can display with this placeholder.<br />
#MATERIALCATEGORY#: Material Category can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Materials Exported',
                    'slug' => 'w3-c-m-s:-materials-exported',
                    'content' => 'Material Exported by: #USERNAME#',
                ],
            ],
            [
                'title' => 'Import Material',
                'code' => 'MATERIAL-IM',
                'table_model' => 'Material',
                'notification_types' => '1',
                'placeholders' => 'Material Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#MATERIALTITLE#: Material Title can display with this placeholder.<br />
#DESCRIPTION#: Description can display with this placeholder.<br />
#MATERIALCOMPANY#: Material Company can display with this placeholder.<br />
#MATERIALCATEGORY#: Material Category can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Materials Imported',
                    'slug' => 'w3-c-m-s:-materials-imported',
                    'content' => 'Materials Imported by: #USERNAME#',
                ],
            ],
            [
                'title' => 'Add New Material Category',
                'code' => 'MATERIALCATEGORY-ANMC',
                'table_model' => 'MaterialCategory',
                'notification_types' => '1',
                'placeholders' => 'Material Category Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#MATERIALCATEGORYTITLE#: Material Category Title can display with this placeholder.<br />
#DESCRIPTION#: Description can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Created New Material Category #MATERIALCATEGORYTITLE#',
                    'slug' => 'w3-c-m-s:-created-new-material-category#-m-a-t-e-r-i-a-l-c-a-t-e-g-o-r-y-t-i-t-l-e#',
                    'content' => 'New Material Category Added by: #USERNAME#<br />
Material Category Details : #MATERIALCATEGORYTITLE#',
                ],
            ],
            [
                'title' => 'Update Material Category',
                'code' => 'MATERIALCATEGORY-UMC',
                'table_model' => 'MaterialCategory',
                'notification_types' => '1',
                'placeholders' => 'Material Category Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#MATERIALCATEGORYTITLE#: Material Category Title can display with this placeholder.<br />
#DESCRIPTION#: Description can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Updated Material Category #MATERIALCATEGORYTITLE#',
                    'slug' => 'w3-c-m-s:-updated-material-category#-m-a-t-e-r-i-a-l-c-a-t-e-g-o-r-y-t-i-t-l-e#',
                    'content' => 'Material Category Updated by: #USERNAME#<br />
Material Category Details : #MATERIALCATEGORYTITLE#',
                ],
            ],
            [
                'title' => 'Delete Material Category',
                'code' => 'MATERIALCATEGORY-DMC',
                'table_model' => 'MaterialCategory',
                'notification_types' => '1',
                'placeholders' => 'Material Category Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#MATERIALCATEGORYTITLE#: Material Category Title can display with this placeholder.<br />
#DESCRIPTION#: Description can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Deleted Material Category #MATERIALCATEGORYTITLE#',
                    'slug' => 'w3-c-m-s:-deleted-material-category#-m-a-t-e-r-i-a-l-c-a-t-e-g-o-r-y-t-i-t-l-e#',
                    'content' => 'Material Category Deleted by: #USERNAME#<br />
Material Category Details : #MATERIALCATEGORYTITLE#',
                ],
            ],
            [
                'title' => 'Add New Quotation',
                'code' => 'QUOTATION-ANQ',
                'table_model' => 'Quotation',
                'notification_types' => '1',
                'placeholders' => 'Quotation Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#QUOTATIONTITLE#: Quotation Title can display with this placeholder.<br />
#DESCRIPTION#: Description can display with this placeholder.<br />
#CLIENTNAME#: Quotation Client Name can display with this placeholder.<br />
#QUOTATIONNUMBER#: Quotation Number can display with this placeholder.<br />
#QUOTATIONSTATUS#: Quotation status can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Created New Quotation #QUOTATIONTITLE#',
                    'slug' => 'w3-c-m-s:-created-new-quotation#-q-u-o-t-a-t-i-o-n-t-i-t-l-e#',
                    'content' => 'New Quotation Added by: #USERNAME#<br />
Quotation Details : #QUOTATIONTITLE#',
                ],
            ],
            [
                'title' => 'Update Quotation',
                'code' => 'QUOTATION-UQ',
                'table_model' => 'Quotation',
                'notification_types' => '1',
                'placeholders' => 'Quotation Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#QUOTATIONTITLE#: Quotation Title can display with this placeholder.<br />
#DESCRIPTION#: Description can display with this placeholder.<br />
#CLIENTNAME#: Quotation Client Name can display with this placeholder.<br />
#QUOTATIONNUMBER#: Quotation Number can display with this placeholder.<br />
#QUOTATIONSTATUS#: Quotation status can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Updated Quotation #QUOTATIONTITLE#',
                    'slug' => 'w3-c-m-s:-updated-quotation#-q-u-o-t-a-t-i-o-n-t-i-t-l-e#',
                    'content' => 'Quotation Updated by: #USERNAME#<br />
Quotation Details : #QUOTATIONTITLE#',
                ],
            ],
            [
                'title' => 'Delete Quotation',
                'code' => 'QUOTATION-DQ',
                'table_model' => 'Quotation',
                'notification_types' => '1',
                'placeholders' => 'Quotation Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#QUOTATIONTITLE#: Quotation Title can display with this placeholder.<br />
#DESCRIPTION#: Description can display with this placeholder.<br />
#CLIENTNAME#: Quotation Client Name can display with this placeholder.<br />
#QUOTATIONNUMBER#: Quotation Number can display with this placeholder.<br />
#QUOTATIONSTATUS#: Quotation status can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Deleted Quotation #QUOTATIONTITLE#',
                    'slug' => 'w3-c-m-s:-deleted-quotation#-q-u-o-t-a-t-i-o-n-t-i-t-l-e#',
                    'content' => 'Quotation Deleted by: #USERNAME#<br />
Quotation Details : #QUOTATIONTITLE#',
                ],
            ],
            [
                'title' => 'Convert Quotation To Invoice',
                'code' => 'QUOTATION-CQTI',
                'table_model' => 'Quotation',
                'notification_types' => '1',
                'placeholders' => 'Quotation Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#QUOTATIONTITLE#: Quotation Title can display with this placeholder.<br />
#DESCRIPTION#: Description can display with this placeholder.<br />
#CLIENTNAME#: Quotation Client Name can display with this placeholder.<br />
#QUOTATIONNUMBER#: Quotation Number can display with this placeholder.<br />
#QUOTATIONSTATUS#: Quotation status can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Quotation Converted To Invoice #QUOTATIONTITLE#',
                    'slug' => 'w3-c-m-s:-quotation-converted-to-invoice#-q-u-o-t-a-t-i-o-n-t-i-t-l-e#',
                    'content' => 'Quotation Converted To Invoice by: #USERNAME#<br />
Quotation Details : #QUOTATIONTITLE#',
                ],
            ],
            [
                'title' => 'Download Quotation',
                'code' => 'QUOTATION-DLQ',
                'table_model' => 'Quotation',
                'notification_types' => '1',
                'placeholders' => 'Quotation Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#QUOTATIONTITLE#: Quotation Title can display with this placeholder.<br />
#DESCRIPTION#: Description can display with this placeholder.<br />
#CLIENTNAME#: Quotation Client Name can display with this placeholder.<br />
#QUOTATIONNUMBER#: Quotation Number can display with this placeholder.<br />
#QUOTATIONSTATUS#: Quotation status can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Downloaded Quotation #QUOTATIONTITLE#',
                    'slug' => 'w3-c-m-s:-downloaded-quotation#-q-u-o-t-a-t-i-o-n-t-i-t-l-e#',
                    'content' => 'Quotation Downloaded by: #USERNAME#<br />
Quotation Details : #QUOTATIONTITLE#',
                ],
            ],
            [
                'title' => 'Business Configurations Update',
                'code' => 'BUSINESSCONFIGMASTER-BCU',
                'table_model' => 'BusinessConfigMaster',
                'notification_types' => '1',
                'placeholders' => 'Business Config Master Configuration<br />
#USERNAME#: Username can display with this placeholder.<br />
#BUSNESSOWNERNAME#: Busness Owner Name can display with this placeholder.<br />
#BUSNESSCOMPANYNAME#: Busness Company Name can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Updated Business Configurations',
                    'slug' => 'w3-c-m-s:-updated-business-configurations',
                    'content' => 'Business Configurations Updated by: #USERNAME#<br />
Business Owner: #BUSNESSOWNERNAME#<br />
Business Comany Name: #BUSNESSCOMPANYNAME#',
                ],
            ],
            [
                'title' => 'Business Configurations Reset',
                'code' => 'BUSINESSCONFIGMASTER-BCR',
                'table_model' => 'BusinessConfigMaster',
                'notification_types' => '1',
                'placeholders' => 'Business Config Master Configuration<br />
#USERNAME#: Username can display with this placeholder.<br />
#BUSNESSOWNERNAME#: Busness Owner Name can display with this placeholder.<br />
#BUSNESSCOMPANYNAME#: Busness Company Name can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Business Configurations Reset',
                    'slug' => 'w3-c-m-s:-business-configurations-reset',
                    'content' => 'Business Configurations Updated by: #USERNAME#<br />
Business Owner: #BUSNESSOWNERNAME#<br />
Business Comany Name: #BUSNESSCOMPANYNAME#',
                ],
            ],
            [
                'title' => 'Add New Contact',
                'code' => 'CONTACT-ANC',
                'table_model' => 'Contact',
                'notification_types' => '1',
                'placeholders' => 'Contact Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#CONTACTNAME#: Contact Full Name can display with this placeholder.<br />
#CONTACTDETAIL#: Contact Name - Email - Phone Number can display with this placeholder.<br />
#EMAIL#: Contact Email can display with this placeholder.<br />
#PHONE#: Contact Phone can display with this placeholder.<br />
#TYPE#: Contact Type can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Created New Contact #CONTACTNAME#',
                    'slug' => 'w3-c-m-s:-created-new-contact#-c-o-n-t-a-c-t-n-a-m-e#',
                    'content' => 'New Contact Added by: #USERNAME#<br />
Contact Details : #CONTACTDETAIL#',
                ],
            ],
            [
                'title' => 'Update Contact',
                'code' => 'CONTACT-UC',
                'table_model' => 'Contact',
                'notification_types' => '1',
                'placeholders' => 'Contact Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#CONTACTNAME#: Contact Full Name can display with this placeholder.<br />
#CONTACTDETAIL#: Contact Name - Email - Phone Number can display with this placeholder.<br />
#EMAIL#: Contact Email can display with this placeholder.<br />
#PHONE#: Contact Phone can display with this placeholder.<br />
#TYPE#: Contact Type can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Updated Contact #CONTACTNAME#',
                    'slug' => 'w3-c-m-s:-updated-contact#-c-o-n-t-a-c-t-n-a-m-e#',
                    'content' => 'Contact Updated by: #USERNAME#<br />
Contact Details : #CONTACTDETAIL#',
                ],
            ],
            [
                'title' => 'Delete Contact',
                'code' => 'CONTACT-DC',
                'table_model' => 'Contact',
                'notification_types' => '1',
                'placeholders' => 'Contact Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#CONTACTNAME#: Contact Full Name can display with this placeholder.<br />
#CONTACTDETAIL#: Contact Name - Email - Phone Number can display with this placeholder.<br />
#EMAIL#: Contact Email can display with this placeholder.<br />
#PHONE#: Contact Phone can display with this placeholder.<br />
#TYPE#: Contact Type can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Deleted Contact #CONTACTNAME#',
                    'slug' => 'w3-c-m-s:-deleted-contact#-c-o-n-t-a-c-t-n-a-m-e#',
                    'content' => 'Contact Delete by: #USERNAME#<br />
Contact Details : #CONTACTDETAIL#',
                ],
            ],
            [
                'title' => 'Assign Login Contact',
                'code' => 'CONTACT-ALC',
                'table_model' => 'Contact',
                'notification_types' => '1',
                'placeholders' => 'Contact Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#CONTACTNAME#: Contact Full Name can display with this placeholder.<br />
#CONTACTDETAIL#: Contact Name - Email - Phone Number can display with this placeholder.<br />
#EMAIL#: Contact Email can display with this placeholder.<br />
#PHONE#: Contact Phone can display with this placeholder.<br />
#TYPE#: Contact Type can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Login Assigned to Contact #CONTACTNAME#',
                    'slug' => 'w3-c-m-s:-login-assigned-to-contact#-c-o-n-t-a-c-t-n-a-m-e#',
                    'content' => 'Contact Login Assigned by: #USERNAME#<br />
Contact Details : #CONTACTDETAIL#',
                ],
            ],
            [
                'title' => 'Assign Contact Type',
                'code' => 'CONTACT-ACT',
                'table_model' => 'Contact',
                'notification_types' => '1',
                'placeholders' => 'Contact Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#CONTACTNAME#: Contact Full Name can display with this placeholder.<br />
#CONTACTDETAIL#: Contact Name - Email - Phone Number can display with this placeholder.<br />
#EMAIL#: Contact Email can display with this placeholder.<br />
#PHONE#: Contact Phone can display with this placeholder.<br />
#TYPE#: Contact Type can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Type Assigned To Contact #CONTACTNAME#',
                    'slug' => 'w3-c-m-s:-type-assigned-to-contact#-c-o-n-t-a-c-t-n-a-m-e#',
                    'content' => 'Contact Type Assigned by: #USERNAME#<br />
Contact Details : #CONTACTDETAIL#',
                ],
            ],
            [
                'title' => 'Add New Transaction',
                'code' => 'TRANSACTION-ANT',
                'table_model' => 'Transaction',
                'notification_types' => '1',
                'placeholders' => 'Transaction Configuration <br />
#USERNAME#; Username can display with this placeholder.<br />
#TRANSACTIONTYPE#; Transaction Type can display with this placeholder.<br />
#TRANSACTIONNUMBER#; Transaction Number can display with this placeholder.<br />
#AMOUNT#; Transaction Amount can display with this placeholder.<br />
#SENDERPARTY#; Transaction sender can display with this placeholder.<br />
#RECIEVERPARTY#; Transaction Reciever can display with this placeholder.<br />
#DESCRIPTION#; Transaction Description can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Created New Transaction #TRANSACTIONTYPE#',
                    'slug' => 'w3-c-m-s:-created-new-transaction#-t-r-a-n-s-a-c-t-i-o-n-t-y-p-e#',
                    'content' => 'New Transaction Added by: #USERNAME#<br />
Transaction Details : #DESCRIPTION#',
                ],
            ],
            [
                'title' => 'Update Transaction',
                'code' => 'TRANSACTION-UT',
                'table_model' => 'Transaction',
                'notification_types' => '1',
                'placeholders' => 'Transaction Configuration <br />
#USERNAME#; Username can display with this placeholder.<br />
#TRANSACTIONTYPE#; Transaction Type can display with this placeholder.<br />
#TRANSACTIONNUMBER#; Transaction Number can display with this placeholder.<br />
#AMOUNT#; Transaction Amount can display with this placeholder.<br />
#SENDERPARTY#; Transaction sender can display with this placeholder.<br />
#RECIEVERPARTY#; Transaction Reciever can display with this placeholder.<br />
#DESCRIPTION#; Transaction Description can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Updated Transaction #TRANSACTIONTYPE#',
                    'slug' => 'w3-c-m-s:-updated-transaction#-t-r-a-n-s-a-c-t-i-o-n-t-y-p-e#',
                    'content' => 'Transaction Updated by: #USERNAME#<br />
Transaction Details : #DESCRIPTION#',
                ],
            ],
            [
                'title' => 'Delete Transaction',
                'code' => 'TRANSACTION-DT',
                'table_model' => 'Transaction',
                'notification_types' => '1',
                'placeholders' => 'Transaction Configuration <br />
#USERNAME#; Username can display with this placeholder.<br />
#TRANSACTIONTYPE#; Transaction Type can display with this placeholder.<br />
#TRANSACTIONNUMBER#; Transaction Number can display with this placeholder.<br />
#AMOUNT#; Transaction Amount can display with this placeholder.<br />
#SENDERPARTY#; Transaction sender can display with this placeholder.<br />
#RECIEVERPARTY#; Transaction Reciever can display with this placeholder.<br />
#DESCRIPTION#; Transaction Description can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Deleted Transaction #TRANSACTIONTYPE#',
                    'slug' => 'w3-c-m-s:-deleted-transaction#-t-r-a-n-s-a-c-t-i-o-n-t-y-p-e#',
                    'content' => 'Transaction Deleted by: #USERNAME#<br />
Transaction Details : #DESCRIPTION#',
                ],
            ],
            [
                'title' => 'Add New Project',
                'code' => 'PROJECT-ANP',
                'table_model' => 'Project',
                'notification_types' => '1',
                'placeholders' => 'Project Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#PROJECTTITLE#: Project Title can display with this placeholder.<br />
#DESCRIPTION#: Description can display with this placeholder.<br />
#CLIENTNAME#: Project Client Name can display with this placeholder.<br />
#CAPACITY#: Project Capacity can display with this placeholder.<br />
#PROJECTTYPE#: Project Type can display with this placeholder.<br />
#STATUS#: Project Status can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Created New Project #PROJECTTITLE#',
                    'slug' => 'w3-c-m-s:-created-new-project#-p-r-o-j-e-c-t-t-i-t-l-e#',
                    'content' => 'New Project Added by: #USERNAME#<br />
Project Details : #PROJECTTITLE#',
                ],
            ],
            [
                'title' => 'Update Project',
                'code' => 'PROJECT-UP',
                'table_model' => 'Project',
                'notification_types' => '1',
                'placeholders' => 'Project Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#PROJECTTITLE#: Project Title can display with this placeholder.<br />
#DESCRIPTION#: Description can display with this placeholder.<br />
#CLIENTNAME#: Project Client Name can display with this placeholder.<br />
#CAPACITY#: Project Capacity can display with this placeholder.<br />
#PROJECTTYPE#: Project Type can display with this placeholder.<br />
#STATUS#: Project Status can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Updated Project #PROJECTTITLE#',
                    'slug' => 'w3-c-m-s:-updated-project#-p-r-o-j-e-c-t-t-i-t-l-e#',
                    'content' => 'Project Updated by: #USERNAME#<br />
Project Details : #PROJECTTITLE#',
                ],
            ],
            [
                'title' => 'Delete Project',
                'code' => 'PROJECT-DP',
                'table_model' => 'Project',
                'notification_types' => '1',
                'placeholders' => 'Project Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#PROJECTTITLE#: Project Title can display with this placeholder.<br />
#DESCRIPTION#: Description can display with this placeholder.<br />
#CLIENTNAME#: Project Client Name can display with this placeholder.<br />
#CAPACITY#: Project Capacity can display with this placeholder.<br />
#PROJECTTYPE#: Project Type can display with this placeholder.<br />
#STATUS#: Project Status can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Deleted Project #PROJECTTITLE#',
                    'slug' => 'w3-c-m-s:-deleted-project#-p-r-o-j-e-c-t-t-i-t-l-e#',
                    'content' => 'Project Deleted by: #USERNAME#<br />
Project Details : #PROJECTTITLE#',
                ],
            ],
            [
                'title' => 'Assign Project Staff',
                'code' => 'PROJECT-APS',
                'table_model' => 'Project',
                'notification_types' => '1',
                'placeholders' => 'Project Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#PROJECTTITLE#: Project Title can display with this placeholder.<br />
#DESCRIPTION#: Description can display with this placeholder.<br />
#CLIENTNAME#: Project Client Name can display with this placeholder.<br />
#CAPACITY#: Project Capacity can display with this placeholder.<br />
#PROJECTTYPE#: Project Type can display with this placeholder.<br />
#STATUS#: Project Status can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Assigned Staff To Project #PROJECTTITLE#',
                    'slug' => 'w3-c-m-s:-assigned-staff-to-project#-p-r-o-j-e-c-t-t-i-t-l-e#',
                    'content' => 'Assigned Staff To Project by: #USERNAME#<br />
Project Details : #PROJECTTITLE#',
                ],
            ],
            [
                'title' => 'Register Business',
                'code' => 'BUSINESS-RB',
                'table_model' => 'Business',
                'notification_types' => '1',
                'placeholders' => 'Business Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#BUSNESSOWNERNAME#: Busness Owner Name can display with this placeholder.<br />
#COMPANYNAME#: Company Name can display with this placeholder.<br />
#ABOUT#: Busness About can display with this placeholder.<br />
#PHONE#: Busness Phone Number can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Registered Business #BUSNESSOWNERNAME#',
                    'slug' => 'w3-c-m-s:-registered-business#-b-u-s-n-e-s-s-o-w-n-e-r-n-a-m-e#',
                    'content' => 'Business Owner: #BUSNESSOWNERNAME#<br />
Business Comany Name: #BUSNESSCOMPANYNAME#',
                ],
            ],
            [
                'title' => 'Add New Business',
                'code' => 'BUSINESS-ANB',
                'table_model' => 'Business',
                'notification_types' => '1',
                'placeholders' => 'Business Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#BUSNESSOWNERNAME#: Busness Owner Name can display with this placeholder.<br />
#COMPANYNAME#: Company Name can display with this placeholder.<br />
#ABOUT#: Busness About can display with this placeholder.<br />
#PHONE#: Busness Phone Number can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Created New Business #BUSNESSOWNERNAME#',
                    'slug' => 'w3-c-m-s:-created-new-business#-b-u-s-n-e-s-s-o-w-n-e-r-n-a-m-e#',
                    'content' => 'New Business Added by: #USERNAME#<br />
Business Owner: #BUSNESSOWNERNAME#<br />
Business Comany Name: #COMPANYNAME#',
                ],
            ],
            [
                'title' => 'Update Business',
                'code' => 'BUSINESS-UB',
                'table_model' => 'Business',
                'notification_types' => '1',
                'placeholders' => 'Business Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#BUSNESSOWNERNAME#: Busness Owner Name can display with this placeholder.<br />
#COMPANYNAME#: Company Name can display with this placeholder.<br />
#ABOUT#: Busness About can display with this placeholder.<br />
#PHONE#: Busness Phone Number can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Updated Business #BUSNESSOWNERNAME#',
                    'slug' => 'w3-c-m-s:-updated-business#-b-u-s-n-e-s-s-o-w-n-e-r-n-a-m-e#',
                    'content' => 'Business Updated by: #USERNAME#<br />
Business Owner: #BUSNESSOWNERNAME#<br />
Business Comany Name: #COMPANYNAME#',
                ],
            ],
            [
                'title' => 'Add New Bank Account',
                'code' => 'BANKACCOUNT-ANBA',
                'table_model' => 'BankAccount',
                'notification_types' => '1',
                'placeholders' => 'Bank Account Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#BUSINESSNAME#: Account Business Name can display with this placeholder.<br />
#CONTACTNAME#: Bank Account Contact Name can display with this placeholder.<br />
#ACCOUNTHOLDER#: Bank Account Holder can display with this placeholder.<br />
#ACCOUNTNUMBER#: Bank Account Number can display with this placeholder.<br />
#BANKNAME#: Bank Account Bank Name can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Created New Bank Account #ACCOUNTHOLDER#',
                    'slug' => 'w3-c-m-s:-created-new-bank-account#-a-c-c-o-u-n-t-h-o-l-d-e-r#',
                    'content' => 'New Bank Account Added by: #USERNAME#<br />
Bank Name : #BANKNAME#<br />
Business : #BUSINESSNAME#<br />
Contact Name: #CONTACTNAME#',
                ],
            ],
            [
                'title' => 'Update Bank Account',
                'code' => 'BANKACCOUNT-UBA',
                'table_model' => 'BankAccount',
                'notification_types' => '1',
                'placeholders' => 'Bank Account Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#BUSINESSNAME#: Account Business Name can display with this placeholder.<br />
#CONTACTNAME#: Bank Account Contact Name can display with this placeholder.<br />
#ACCOUNTHOLDER#: Bank Account Holder can display with this placeholder.<br />
#ACCOUNTNUMBER#: Bank Account Number can display with this placeholder.<br />
#BANKNAME#: Bank Account Bank Name can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Updated Bank Account #ACCOUNTHOLDER#',
                    'slug' => 'w3-c-m-s:-updated-bank-account#-a-c-c-o-u-n-t-h-o-l-d-e-r#',
                    'content' => 'Bank Account Updated by: #USERNAME#<br />
Bank Name : #BANKNAME#<br />
Business : #BUSINESSNAME#<br />
Contact Name: #CONTACTNAME#',
                ],
            ],
            [
                'title' => 'Delete Bank Account',
                'code' => 'BANKACCOUNT-DBA',
                'table_model' => 'BankAccount',
                'notification_types' => '1',
                'placeholders' => 'Bank Account Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#BUSINESSNAME#: Account Business Name can display with this placeholder.<br />
#CONTACTNAME#: Bank Account Contact Name can display with this placeholder.<br />
#ACCOUNTHOLDER#: Bank Account Holder can display with this placeholder.<br />
#ACCOUNTNUMBER#: Bank Account Number can display with this placeholder.<br />
#BANKNAME#: Bank Account Bank Name can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Delete Bank Account #ACCOUNTHOLDER#',
                    'slug' => 'w3-c-m-s:-delete-bank-account#-a-c-c-o-u-n-t-h-o-l-d-e-r#',
                    'content' => 'Bank Account Deleted by: #USERNAME#<br />
Bank Name : #BANKNAME#<br />
Business : #BUSINESSNAME#<br />
Contact Name: #CONTACTNAME#',
                ],
            ],
            [
                'title' => 'Add New Address',
                'code' => 'ADDRESS-ANA',
                'table_model' => 'Address',
                'notification_types' => '1',
                'placeholders' => 'Address Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#ADDRESSTITLE#: Address Title can display with this placeholder.<br />
#ADDRESS#: Address can display with this placeholder.<br />
#BUSINESSNAME#: Address Business Name can display with this placeholder.<br />
#CONTACTNAME#: Address Contact Name can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Created New Address #ADDRESSTITLE#',
                    'slug' => 'w3-c-m-s:-created-new-address#-a-d-d-r-e-s-s-t-i-t-l-e#',
                    'content' => 'New Address Added by: #USERNAME#<br />
Address Title : #ADDRESSTITLE#<br />
Address : #ADDRESS#',
                ],
            ],
            [
                'title' => 'Update Address',
                'code' => 'ADDRESS-UA',
                'table_model' => 'Address',
                'notification_types' => '1',
                'placeholders' => 'Address Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#ADDRESSTITLE#: Address Title can display with this placeholder.<br />
#ADDRESS#: Address can display with this placeholder.<br />
#BUSINESSNAME#: Address Business Name can display with this placeholder.<br />
#CONTACTNAME#: Address Contact Name can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Updated Address #ADDRESSTITLE#',
                    'slug' => 'w3-c-m-s:-updated-address#-a-d-d-r-e-s-s-t-i-t-l-e#',
                    'content' => 'Address Updated by: #USERNAME#<br />
Address Title : #ADDRESSTITLE#<br />
Address : #ADDRESS#',
                ],
            ],
            [
                'title' => 'Delete Address',
                'code' => 'ADDRESS-DA',
                'table_model' => 'Address',
                'notification_types' => '1',
                'placeholders' => 'Address Configuration <br />
#USERNAME#: Username can display with this placeholder.<br />
#ADDRESSTITLE#: Address Title can display with this placeholder.<br />
#ADDRESS#: Address can display with this placeholder.<br />
#BUSINESSNAME#: Address Business Name can display with this placeholder.<br />
#CONTACTNAME#: Address Contact Name can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Deleted Address #ADDRESSTITLE#',
                    'slug' => 'w3-c-m-s:-deleted-address#-a-d-d-r-e-s-s-t-i-t-l-e#',
                    'content' => 'Address Deleted by: #USERNAME#<br />
Address Title : #ADDRESSTITLE#<br />
Address : #ADDRESS#',
                ],
            ],
            [
                'title' => 'Add New ProjectPhase',
                'code' => 'PROJECTPHASE-ANPP',
                'table_model' => 'ProjectPhase',
                'notification_types' => '1',
                'placeholders' => 'ProjectPhase Configuration<br />
#USERNAME#: Username can display with this placeholder.<br />
#PROJECTPHASETITLE#: ProjectPhase Title can display with this placeholder.<br />
#DESCRIPTION#: Description can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Created New ProjectPhase #PROJECTPHASETITLE#',
                    'slug' => 'w3-c-m-s:-created-new-projectphase#-p-r-o-j-e-c-t-p-h-a-s-e-t-i-t-l-e#',
                    'content' => 'New ProjectPhase Added by: #USERNAME#<br />
ProjectPhase Details : #PROJECTPHASETITLE#',
                ],
            ],
            [
                'title' => 'Update ProjectPhase',
                'code' => 'PROJECTPHASE-UPP',
                'table_model' => 'ProjectPhase',
                'notification_types' => '1',
                'placeholders' => 'ProjectPhase Configuration<br />
#USERNAME#: Username can display with this placeholder.<br />
#PROJECTPHASETITLE#: ProjectPhase Title can display with this placeholder.<br />
#DESCRIPTION#: Description can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Updated ProjectPhase #PROJECTPHASETITLE#',
                    'slug' => 'w3-c-m-s:-updated-projectphase#-p-r-o-j-e-c-t-p-h-a-s-e-t-i-t-l-e#',
                    'content' => 'ProjectPhase Updated by: #USERNAME#<br />
ProjectPhase Details : #PROJECTPHASETITLE#',
                ],
            ],
            [
                'title' => 'Delete ProjectPhase',
                'code' => 'PROJECTPHASE-DPP',
                'table_model' => 'ProjectPhase',
                'notification_types' => '1',
                'placeholders' => 'ProjectPhase Configuration<br />
#USERNAME#: Username can display with this placeholder.<br />
#PROJECTPHASETITLE#: ProjectPhase Title can display with this placeholder.<br />
#DESCRIPTION#: Description can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Deleted ProjectPhase #PROJECTPHASETITLE#',
                    'slug' => 'w3-c-m-s:-deleted-projectphase#-p-r-o-j-e-c-t-p-h-a-s-e-t-i-t-l-e#',
                    'content' => 'ProjectPhase Deleted by: #USERNAME#<br />
ProjectPhase Details : #PROJECTPHASETITLE#',
                ],
            ],
            [
                'title' => 'Add New MaterialUnit',
                'code' => 'MATERIALUNIT-ANMU',
                'table_model' => 'MaterialUnit',
                'notification_types' => '1',
                'placeholders' => 'MaterialUnit Configuration<br />
#USERNAME#: Username can display with this placeholder.<br />
#MATERIALUNITTITLE#: MaterialUnit Title can display with this placeholder.<br />
#DESCRIPTION#: Description can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Created New MaterialUnit #MATERIALUNITTITLE#',
                    'slug' => 'w3-c-m-s:-created-new-materialunit#-m-a-t-e-r-i-a-l-u-n-i-t-t-i-t-l-e#',
                    'content' => 'New MaterialUnit Added by: #USERNAME#<br />
MaterialUnit Details : #MATERIALUNITTITLE#',
                ],
            ],
            [
                'title' => 'Update MaterialUnit',
                'code' => 'MATERIALUNIT-UMU',
                'table_model' => 'MaterialUnit',
                'notification_types' => '1',
                'placeholders' => 'MaterialUnit Configuration<br />
#USERNAME#: Username can display with this placeholder.<br />
#MATERIALUNITTITLE#: MaterialUnit Title can display with this placeholder.<br />
#DESCRIPTION#: Description can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Updated MaterialUnit #MATERIALUNITTITLE#',
                    'slug' => 'w3-c-m-s:-updated-materialunit#-m-a-t-e-r-i-a-l-u-n-i-t-t-i-t-l-e#',
                    'content' => 'MaterialUnit Updated by: #USERNAME#<br />
MaterialUnit Details : #MATERIALUNITTITLE#',
                ],
            ],
            [
                'title' => 'Delete MaterialUnit',
                'code' => 'MATERIALUNIT-DMU',
                'table_model' => 'MaterialUnit',
                'notification_types' => '1',
                'placeholders' => 'MaterialUnit Configuration<br />
#USERNAME#: Username can display with this placeholder.<br />
#MATERIALUNITTITLE#: MaterialUnit Title can display with this placeholder.<br />
#DESCRIPTION#: Description can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Deleted MaterialUnit #MATERIALUNITTITLE#',
                    'slug' => 'w3-c-m-s:-deleted-materialunit#-m-a-t-e-r-i-a-l-u-n-i-t-t-i-t-l-e#',
                    'content' => 'MaterialUnit Deleted by: #USERNAME#<br />
MaterialUnit Details : #MATERIALUNITTITLE#',
                ],
            ],
            [
                'title' => 'Add New ConfigMaster',
                'code' => 'CONFIGMASTER-ANCM',
                'table_model' => 'ConfigMaster',
                'notification_types' => '1',
                'placeholders' => 'ConfigMaster Configuration<br />
#USERNAME#: Username can display with this placeholder.<br />
#CONFIGMASTERTITLE#: ConfigMaster Title can display with this placeholder.<br />
#DESCRIPTION#: Description can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Created New ConfigMaster #CONFIGMASTERTITLE#',
                    'slug' => 'w3-c-m-s:-created-new-configmaster#-c-o-n-f-i-g-m-a-s-t-e-r-t-i-t-l-e#',
                    'content' => 'New ConfigMaster Added by: #USERNAME#<br />
ConfigMaster Details : #CONFIGMASTERTITLE#',
                ],
            ],
            [
                'title' => 'Update ConfigMaster',
                'code' => 'CONFIGMASTER-UCM',
                'table_model' => 'ConfigMaster',
                'notification_types' => '1',
                'placeholders' => 'ConfigMaster Configuration<br />
#USERNAME#: Username can display with this placeholder.<br />
#CONFIGMASTERTITLE#: ConfigMaster Title can display with this placeholder.<br />
#DESCRIPTION#: Description can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Updated ConfigMaster #CONFIGMASTERTITLE#',
                    'slug' => 'w3-c-m-s:-updated-configmaster#-c-o-n-f-i-g-m-a-s-t-e-r-t-i-t-l-e#',
                    'content' => 'ConfigMaster Updated by: #USERNAME#<br />
ConfigMaster Details : #CONFIGMASTERTITLE#',
                ],
            ],
            [
                'title' => 'Delete ConfigMaster',
                'code' => 'CONFIGMASTER-DCM',
                'table_model' => 'ConfigMaster',
                'notification_types' => '1',
                'placeholders' => 'ConfigMaster Configuration<br />
#USERNAME#: Username can display with this placeholder.<br />
#CONFIGMASTERTITLE#: ConfigMaster Title can display with this placeholder.<br />
#DESCRIPTION#: Description can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Deleted ConfigMaster #CONFIGMASTERTITLE#',
                    'slug' => 'w3-c-m-s:-deleted-configmaster#-c-o-n-f-i-g-m-a-s-t-e-r-t-i-t-l-e#',
                    'content' => 'ConfigMaster Deleted by: #USERNAME#<br />
ConfigMaster Details : #CONFIGMASTERTITLE#',
                ],
            ],
            [
                'title' => 'Update Project Documents',
                'code' => 'PROJECT-UPD',
                'table_model' => 'Project',
                'notification_types' => '1',
                'placeholders' => 'Project Configuration<br />
#USERNAME#: Username can display with this placeholder.<br />
#PROJECTTITLE#: Project Title can display with this placeholder.<br />
#DESCRIPTION#: Description can display with this placeholder.<br />
#CLIENTNAME#: Project Client Name can display with this placeholder.<br />
#CAPACITY#: Project Capacity can display with this placeholder.<br />
#PROJECTTYPE#: Project Type can display with this placeholder.<br />
#STATUS#: Project Status can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Updated Project Documents #PROJECTTITLE#',
                    'slug' => 'w3-c-m-s:-updated-project-documents#-p-r-o-j-e-c-t-t-i-t-l-e#',
                    'content' => 'Project Documents Updated by: #USERNAME#<br />
Project Details : #PROJECTTITLE#',
                ],
            ],
            [
                'title' => 'Update Project Verification',
                'code' => 'PROJECT-UPV',
                'table_model' => 'Project',
                'notification_types' => '1',
                'placeholders' => 'Project Configuration<br />
#USERNAME#: Username can display with this placeholder.<br />
#PROJECTTITLE#: Project Title can display with this placeholder.<br />
#DESCRIPTION#: Description can display with this placeholder.<br />
#CLIENTNAME#: Project Client Name can display with this placeholder.<br />
#CAPACITY#: Project Capacity can display with this placeholder.<br />
#PROJECTTYPE#: Project Type can display with this placeholder.<br />
#STATUS#: Project Status can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Updated Project Verification #PROJECTTITLE#',
                    'slug' => 'w3-c-m-s:-updated-project-verification#-p-r-o-j-e-c-t-t-i-t-l-e#',
                    'content' => 'Project Verification Updated by: #USERNAME#<br />
Project Details : #PROJECTTITLE#',
                ],
            ],
            [
                'title' => 'Update Project Subsidy',
                'code' => 'PROJECT-UPS',
                'table_model' => 'Project',
                'notification_types' => '1',
                'placeholders' => 'Project Configuration<br />
#USERNAME#: Username can display with this placeholder.<br />
#PROJECTTITLE#: Project Title can display with this placeholder.<br />
#DESCRIPTION#: Description can display with this placeholder.<br />
#CLIENTNAME#: Project Client Name can display with this placeholder.<br />
#CAPACITY#: Project Capacity can display with this placeholder.<br />
#PROJECTTYPE#: Project Type can display with this placeholder.<br />
#STATUS#: Project Status can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Updated Project Subsidy #PROJECTTITLE#',
                    'slug' => 'w3-c-m-s:-updated-project-subsidy#-p-r-o-j-e-c-t-t-i-t-l-e#',
                    'content' => 'Project Subsidy Updated by: #USERNAME#<br />
Project Details : #PROJECTTITLE#',
                ],
            ],
            [
                'title' => 'Update Project Structure',
                'code' => 'PROJECT-UPST',
                'table_model' => 'Project',
                'notification_types' => '1',
                'placeholders' => 'Project Configuration<br />
#USERNAME#: Username can display with this placeholder.<br />
#PROJECTTITLE#: Project Title can display with this placeholder.<br />
#DESCRIPTION#: Description can display with this placeholder.<br />
#CLIENTNAME#: Project Client Name can display with this placeholder.<br />
#CAPACITY#: Project Capacity can display with this placeholder.<br />
#PROJECTTYPE#: Project Type can display with this placeholder.<br />
#STATUS#: Project Status can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Updated Project Structure #PROJECTTITLE#',
                    'slug' => 'w3-c-m-s:-updated-project-structure#-p-r-o-j-e-c-t-t-i-t-l-e#',
                    'content' => 'Project Structure Updated by: #USERNAME#<br />
Project Details : #PROJECTTITLE#',
                ],
            ],
            [
                'title' => 'Update Project Netmeter',
                'code' => 'PROJECT-UPN',
                'table_model' => 'Project',
                'notification_types' => '1',
                'placeholders' => 'Project Configuration<br />
#USERNAME#: Username can display with this placeholder.<br />
#PROJECTTITLE#: Project Title can display with this placeholder.<br />
#DESCRIPTION#: Description can display with this placeholder.<br />
#CLIENTNAME#: Project Client Name can display with this placeholder.<br />
#CAPACITY#: Project Capacity can display with this placeholder.<br />
#PROJECTTYPE#: Project Type can display with this placeholder.<br />
#STATUS#: Project Status can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Updated Project Netmeter #PROJECTTITLE#',
                    'slug' => 'w3-c-m-s:-updated-project-netmeter#-p-r-o-j-e-c-t-t-i-t-l-e#',
                    'content' => 'Project Netmeter Updated by: #USERNAME#<br />
Project Details : #PROJECTTITLE#',
                ],
            ],
            [
                'title' => 'Update Project Handover',
                'code' => 'PROJECT-UPH',
                'table_model' => 'Project',
                'notification_types' => '1',
                'placeholders' => 'Project Configuration<br />
#USERNAME#: Username can display with this placeholder.<br />
#PROJECTTITLE#: Project Title can display with this placeholder.<br />
#DESCRIPTION#: Description can display with this placeholder.<br />
#CLIENTNAME#: Project Client Name can display with this placeholder.<br />
#CAPACITY#: Project Capacity can display with this placeholder.<br />
#PROJECTTYPE#: Project Type can display with this placeholder.<br />
#STATUS#: Project Status can display with this placeholder.',
                'status' => 1,
                'template' => [
                    'notification_type_id' => 1,
                    'subject' => 'W3CMS: Updated Project Handover #PROJECTTITLE#',
                    'slug' => 'w3-c-m-s:-updated-project-handover#-p-r-o-j-e-c-t-t-i-t-l-e#',
                    'content' => 'Project Handover Updated by: #USERNAME#<br />
Project Details : #PROJECTTITLE#',
                ],
            ],
        ];

        DB::transaction(function () use ($notifications, $now): void {
            $configs = array_map(static function (array $notification) use ($now): array {
                return [
                    'title' => $notification['title'],
                    'code' => $notification['code'],
                    'table_model' => $notification['table_model'],
                    'notification_types' => $notification['notification_types'],
                    'placeholders' => $notification['placeholders'],
                    'status' => $notification['status'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }, $notifications);

            DB::table('notification_config')->insert($configs);

            $codes = array_column($configs, 'code');
            $configIds = DB::table('notification_config')
                ->whereIn('code', $codes)
                ->orderByDesc('id')
                ->get(['id', 'code'])
                ->groupBy('code')
                ->map(static fn ($rows) => $rows->first()->id);

            $templates = array_map(static function (array $notification) use ($configIds, $now): array {
                return [
                    'notification_config_id' => $configIds[$notification['code']],
                    'notification_type_id' => $notification['template']['notification_type_id'],
                    'subject' => $notification['template']['subject'],
                    'slug' => $notification['template']['slug'],
                    'content' => $notification['template']['content'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }, $notifications);

            DB::table('notification_templates')->insert($templates);
        });
    }
}
