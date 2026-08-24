<?php

return [
    'name' => 'SolarMitra',

    'country_id_india' => 1,
    'state_id_rajasthan' => 21,
    
    'projects_status' => [
        '1' => 'Draft',
        '2' => 'Running',
        '3' => 'Completed',
        '4' => 'Hold',
        '5' => 'Archived',
    ],

    'projects_status_keys' => [
        'Draft' => '1',
        'Running' => '2',
        'Completed' => '3',
        'Hold' => '4',
        'Archived' => '5',
    ],

    'work_location' => [
        'office' => 'Office',
        'remote' => 'Remote',
        'field' => 'Field',
    ],

    'salary_type' => [
        'per_project' => 'Per Project',
        'monthly' => 'Monthly',
        'contract_based' => 'Contract Based',
    ],

    'followup_logs_status' => [
        '1' => 'Pending',
        '2' => 'Done',
        '3' => 'Missed',
        '4' => 'skipped',
    ],
    
    'business_config_value_types' => [
        'string' => 'String',
        'number' => 'Number',
        'boolean' => 'Boolean',
        'json' => 'Json',
        'date' => 'Date'
    ],

    'business_config' => [
        'modules' => [
            'global' => 'Global',
            'staff' => 'Staff',
            'user' => 'User',
            'invoice' => 'Invoice',
            'quotation' => 'Quotation',
            'lead' => 'Lead',
            'tax' => 'Tax',
            'solar' => 'Solar',
            'solar_project' => 'Solar Project',
            'projects' => 'Projects',
            'documents' => 'Documents',
        ],
    ],

    'projects_attachment_types' => [
        '1' => 'Site Photo',
        '2' => 'Site Completion Photos',
        '3' => 'Feedback',
        '4' => 'Structure',
        '5' => 'Panel Installation',
    ],

    'abbreviations' => ['Mr.', 'Mrs.', 'Ms.', 'Miss.', 'Dr.', 'Prof.', 'Mx.'],

    'source_types' => [
        '1' => 'Platform',
        '2' => 'Company',
        '3' => 'Person',
        '4' => 'Affiliate',
    ],

    'quotations_status' => [
        '1' => 'Draft',
        '2' => 'Sent',
        '3' => 'In Discussion',
        '4' => 'On Hold',
        '5' => 'Client Confirmed',
        '6' => 'Rejected',
    ],

    'lead_potentials' => [
        '1' => 'Low',
        '2' => 'Medium',
        '3' => 'High',
    ],

    'repeat_followups' => [
        '1' => 'No Repeated followup',
        '2' => 'Weekly',
        '3' => 'Monthly',
        '4' => 'Quarterly',
        '5' => 'Annually',

    ],
    'subsidy_type' => [
        '1' => 'Central Govt Subsidy',
        '2' => 'State Govt Subsidy',
        '3' => 'Both',
    ],

    'campaigns_status' => [
        '1' => 'Draft',
        '2' => 'Active',
        '3' => 'Closed',
        '4' => 'Paused',
    ],

    'transfer_modes' => [
        '1' => 'Cash',
        '2' => 'Bank Transfer',
        '3' => 'Cheque',
    ],

    'address_type' => [
        '1' => 'Billing Address',
        '2' => 'Shipping Address',
        '3' => 'Project Address',
    ],
    
    'transfer_types' => [
        'dr' => 'Debit',
        'cr' => 'Credit',
    ],
    
    'payment_for' => [
        '1' => 'Labor Payment',
        '2' => 'Material Payment',
        '3' => 'Invoice Payment',
        '4' => 'Project Expenses',
        '5' => 'Other Expenses',
        '6' => 'Company Expenses',
    ],
    
    'reference_type' => [
        'invoice' => 'Invoice Payment',
    ],
    
    'transaction_type' => [
        'income' => 1,
        'expense' => 2,
    ],
    
    'business_user_types' => [
        'clients' => 'Client',
        'suppliers' => 'Supplier',
        'investors' => 'Investor',
        'contractors' => 'Contractor',
        'partners' => 'Partner',
        'staff' => 'Staff',
    ],

    'contact_types' => [
        '1' => 'Business',
        '2' => 'Business User',
    ],
    
    'business_user_roles' => [
        'staff' => 'Business Staff',
        'clients' => 'Business Clients',
        'contractors' => 'Business Contractor',
        'suppliers' => 'Business Suppliers',
        'investors' => 'Business Investors',
        'partners' => 'Business Partners',
    ],
    
    'gst_rates' => [
        '0',
        '5',
        '8.90',
        '12',
        '18',
        '28',
    ],
    
    'partner_types' => [
        'referral' => 'Referral',
        'dealer' => 'Dealer',
        'distributor' => 'Distributor',
    ],
    
    'client_types' => [
        'residential' => 'Residential',
        'commercial' => 'Commercial',
        'industrial' => 'Industrial',
    ],
    
    'payment_terms' => [
        'advance'=>'Advance',
        'due_on_receipt'=>'Due on Receipt',
        '7_days'=>'7 Days',
        '15_days'=>'15 Days',
        '30_days'=>'30 Days',
    ],
    
    'staff_departments' => [
        'admin' => 'Admin',
        'management' => 'Management',
        'sales' => 'Sales',
        'technical' => 'Technical',
        'installation' => 'Installation',
        'maintenance' => 'Maintenance',
        'procurement_&_inventory' => 'Procurement & Inventory',
        'finance' => 'Finance',
        'customer_support' => 'Customer Support',
    ],
    'partner_types' => [
        'referral' => 'Referral',
        'dealer' => 'Dealer',
        'distributor' => 'Distributor',
    ],
    
    'attachment_object_types' => [
        'transaction',
        'invoice',
        'quotation',
    ],
 
    'project_kits' => [
        'TATA',
        'Adani',
        'Vikram',
        'Waaree',
        'RenewSys',
        'Emmvee',
        'Loom',
        'Goldi',
        'Mundra',
        'Websol',
    ],

    'project_types' => [
        'On-Grid',
        'Off-Grid',
        'Hybrid',
    ],

    'projects_capacity' => [
        '1 kW',
        '2 kW',
        '3 kW',
        '4 kW',
        '5 kW',
        '6 kW',
        '7.5 kW',
        '8 kW',
        '10 kW',
        '12 kW',
        '15 kW',
        '20 kW',
        '25 kW',
        '30 kW',
        '40 kW',
        '50 kW',
        '75 kW',
        '100 kW',
        '125 kW',
        '150 kW',
        '200 kW',
        '250 kW',
        '300 kW',
        '400 kW',
        '500 kW',
        '1 MW',
        '2 MW',
        '3 MW',
        '5 MW',
        '10 MW',
    ],

    'payment-input-color' => 'success',
    'payment-output-color' => 'danger',
    'party-to-party-payment-color' => 'dark',
    'debit-note-color' => 'info',
    'credit-note-color' => 'warning',
    'sales-invoice-color' => 'dark',
    'material-purchase-color' => 'dark',
    'material-return-color' => 'dark',
    'material-transfer-color' => 'dark',
    'other-expense-color' => 'dark',


    'payment-output-svg' => '<svg width="25" height="15" viewBox="0 0 25 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9.02481 4.16244L8.6928 5.14798H0L0.321955 4.16244H9.02481ZM6.0266 14.1759L0.825011 8.4579L0.81495 7.63042H2.4046C3.18266 7.63042 3.82657 7.49406 4.33634 7.22133C4.8461 6.9486 5.23178 6.5891 5.49336 6.14282C5.75495 5.69653 5.88575 5.21616 5.88575 4.7017C5.88575 4.08186 5.74154 3.5426 5.45312 3.08393C5.1647 2.62525 4.74214 2.26884 4.18542 2.01471C3.62871 1.75438 2.94455 1.62421 2.13295 1.62421H0.150917L0.492994 0.638672H2.13295C3.17931 0.638672 4.07475 0.799829 4.81927 1.12214C5.56379 1.43826 6.13057 1.90004 6.5196 2.50748C6.91533 3.11492 7.1132 3.84942 7.1132 4.711C7.1132 5.41141 6.95558 6.05914 6.64033 6.65418C6.33179 7.24303 5.8388 7.7172 5.16135 8.0767C4.49061 8.43001 3.60858 8.60666 2.51528 8.60666L7.45528 14.055V14.1759H6.0266ZM9.02481 0.638672L8.6928 1.62421H0.895438L1.22746 0.638672H9.02481Z"fill="#ff4c41" /><path d="M18.7174 2.12232L22.9238 6.03389C23.0494 6.15058 23.2196 6.21614 23.3972 6.21614C23.5747 6.21614 23.745 6.15058 23.8705 6.03389C23.996 5.91719 24.0665 5.75891 24.0665 5.59388C24.0665 5.42885 23.996 5.27057 23.8705 5.15388L18.5222 0.18207C18.4601 0.124194 18.3863 0.0782738 18.3051 0.0469437C18.2239 0.0156136 18.1368 -0.000513077 18.0489 -0.000513077C17.961 -0.000513077 17.8739 0.0156136 17.7927 0.0469437C17.7115 0.0782738 17.6377 0.124194 17.5756 0.18207L12.2273 5.15388C12.1651 5.21166 12.1158 5.28026 12.0822 5.35575C12.0486 5.43125 12.0312 5.51216 12.0312 5.59388C12.0312 5.6756 12.0486 5.75651 12.0822 5.83201C12.1158 5.90751 12.1651 5.9761 12.2273 6.03389C12.2895 6.09167 12.3633 6.1375 12.4445 6.16877C12.5257 6.20005 12.6127 6.21614 12.7006 6.21614C12.7885 6.21614 12.8756 6.20005 12.9568 6.16877C13.038 6.1375 13.1118 6.09167 13.174 6.03389L17.3804 2.12232V14.2945C17.3804 14.4594 17.4508 14.6174 17.5762 14.734C17.7015 14.8505 17.8716 14.916 18.0489 14.916C18.2262 14.916 18.3962 14.8505 18.5216 14.734C18.647 14.6174 18.7174 14.4594 18.7174 14.2945V2.12232Z"fill="#ff4c41" /></svg>',

    'payment-input-svg' => '<svg width="25" height="15" viewBox="0 0 25 15" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_564_2)"> <path d="M9.02481 4.16244L8.6928 5.14798H0L0.321955 4.16244H9.02481ZM6.0266 14.1759L0.825011 8.4579L0.81495 7.63042H2.4046C3.18266 7.63042 3.82657 7.49406 4.33634 7.22133C4.8461 6.9486 5.23178 6.5891 5.49336 6.14282C5.75495 5.69653 5.88575 5.21616 5.88575 4.7017C5.88575 4.08186 5.74154 3.5426 5.45312 3.08393C5.1647 2.62525 4.74214 2.26884 4.18542 2.01471C3.62871 1.75438 2.94455 1.62421 2.13295 1.62421H0.150917L0.492994 0.638672H2.13295C3.17931 0.638672 4.07475 0.799829 4.81927 1.12214C5.56379 1.43826 6.13057 1.90004 6.5196 2.50748C6.91533 3.11492 7.1132 3.84942 7.1132 4.711C7.1132 5.41141 6.95558 6.05914 6.64033 6.65418C6.33179 7.24303 5.8388 7.7172 5.16135 8.0767C4.49061 8.43001 3.60858 8.60666 2.51528 8.60666L7.45528 14.055V14.1759H6.0266ZM9.02481 0.638672L8.6928 1.62421H0.895438L1.22746 0.638672H9.02481Z" fill="#68cf29"/> <path d="M17.3802 12.7932L13.1738 8.88161C13.0482 8.76492 12.878 8.69936 12.7004 8.69936C12.5229 8.69936 12.3526 8.76492 12.2271 8.88161C12.1016 8.99831 12.0311 9.15659 12.0311 9.32162C12.0311 9.48665 12.1016 9.64493 12.2271 9.76162L17.5754 14.7334C17.6375 14.7913 17.7113 14.8372 17.7925 14.8686C17.8737 14.8999 17.9608 14.916 18.0487 14.916C18.1366 14.916 18.2237 14.8999 18.3049 14.8686C18.3861 14.8372 18.4599 14.7913 18.522 14.7334L23.8703 9.76162C23.9325 9.70384 23.9818 9.63524 24.0154 9.55975C24.049 9.48425 24.0664 9.40334 24.0664 9.32162C24.0664 9.2399 24.049 9.15899 24.0154 9.08349C23.9818 9.00799 23.9325 8.9394 23.8703 8.88161C23.8081 8.82383 23.7343 8.778 23.6531 8.74673C23.5719 8.71545 23.4849 8.69936 23.397 8.69936C23.3091 8.69936 23.222 8.71545 23.1408 8.74673C23.0596 8.778 22.9858 8.82383 22.9236 8.88161L18.7172 12.7932V0.621002C18.7172 0.456102 18.6468 0.298102 18.5214 0.181502C18.3961 0.0650023 18.226 -0.000497818 18.0487 -0.000497818C17.8714 -0.000497818 17.7014 0.0650023 17.576 0.181502C17.4506 0.298102 17.3802 0.456102 17.3802 0.621002V12.7932Z" fill="#68cf29"/></g><defs><clipPath id="clip0_564_2"><rect width="25" height="15" fill="white"/></clipPath></defs></svg>',

    'party-to-party-payment-svg' => '<svg width="31" height="13" viewBox="0 0 31 13" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_583_11)"><path d="M19.0733 3.93347L18.7927 4.76648H11.4453L11.7174 3.93347H19.0733ZM16.5392 12.3971L12.1426 7.56412L12.1341 6.86471H13.4778C14.1354 6.86471 14.6796 6.74945 15.1105 6.51893C15.5414 6.28842 15.8674 5.98455 16.0885 5.60734C16.3096 5.23013 16.4201 4.82411 16.4201 4.38927C16.4201 3.86536 16.2982 3.40957 16.0544 3.02188C15.8107 2.63419 15.4535 2.33294 14.983 2.11814C14.5124 1.8981 13.9341 1.78808 13.2481 1.78808H11.5729L11.862 0.955078H13.2481C14.1326 0.955078 14.8894 1.09129 15.5187 1.36372C16.148 1.63091 16.627 2.02122 16.9559 2.53465C17.2904 3.04807 17.4576 3.6689 17.4576 4.39713C17.4576 4.98914 17.3244 5.53662 17.0579 6.03956C16.7971 6.53727 16.3804 6.93806 15.8078 7.24192C15.2409 7.54055 14.4954 7.68986 13.5713 7.68986L17.7467 12.295V12.3971H16.5392ZM19.0733 0.955078L18.7927 1.78808H12.2022L12.4828 0.955078H19.0733Z" fill="var(--bs-dark)"></path><path d="M24.8572 10.8136L21.3018 7.50744C21.1957 7.4088 21.0518 7.35339 20.9017 7.35339C20.7517 7.35339 20.6077 7.4088 20.5016 7.50744C20.3955 7.60607 20.3359 7.73985 20.3359 7.87934C20.3359 8.01883 20.3955 8.15261 20.5016 8.25125L25.0222 12.4536C25.0746 12.5025 25.137 12.5413 25.2057 12.5678C25.2743 12.5943 25.3479 12.6079 25.4222 12.6079C25.4965 12.6079 25.5701 12.5943 25.6388 12.5678C25.7074 12.5413 25.7698 12.5025 25.8223 12.4536L30.3428 8.25125C30.3953 8.20241 30.437 8.14443 30.4654 8.08062C30.4939 8.0168 30.5085 7.94841 30.5085 7.87934C30.5085 7.81027 30.4939 7.74188 30.4654 7.67807C30.437 7.61426 30.3953 7.55628 30.3428 7.50744C30.2903 7.4586 30.2279 7.41986 30.1592 7.39342C30.0906 7.36699 30.017 7.35339 29.9427 7.35339C29.8684 7.35339 29.7949 7.36699 29.7262 7.39342C29.6576 7.41986 29.5952 7.4586 29.5427 7.50744L25.9873 10.8136V0.525289C25.9873 0.385974 25.9278 0.252365 25.8218 0.153854C25.7158 0.0553429 25.5721 0 25.4222 0C25.2724 0 25.1286 0.0553429 25.0227 0.153854C24.9167 0.252365 24.8572 0.385974 24.8572 0.525289V10.8136Z" fill="var(--bs-dark)"></path><path d="M5.65136 1.79819L9.20674 5.10436C9.31284 5.203 9.45675 5.25841 9.6068 5.25841C9.75686 5.25841 9.90077 5.203 10.0069 5.10436C10.113 5.00573 10.1726 4.87195 10.1726 4.73246C10.1726 4.59296 10.113 4.45919 10.0069 4.36055L5.48636 0.15823C5.43387 0.109313 5.37151 0.0704985 5.30286 0.0440178C5.23421 0.0175362 5.16062 0.00390625 5.08629 0.00390625C5.01197 0.00390625 4.93837 0.0175362 4.86972 0.0440178C4.80107 0.0704985 4.73872 0.109313 4.68623 0.15823L0.165713 4.36055C0.113175 4.40939 0.0715003 4.46737 0.0430673 4.53118C0.0146343 4.59499 0 4.66339 0 4.73246C0 4.80152 0.0146343 4.86992 0.0430673 4.93373C0.0715003 4.99754 0.113175 5.05552 0.165713 5.10436C0.21825 5.1532 0.280621 5.19194 0.349264 5.21837C0.417907 5.2448 0.491479 5.25841 0.565778 5.25841C0.640077 5.25841 0.713649 5.2448 0.782292 5.21837C0.850936 5.19194 0.913306 5.1532 0.965844 5.10436L4.52123 1.79819V12.0865C4.52123 12.2259 4.58076 12.3595 4.68673 12.458C4.7927 12.5565 4.93643 12.6118 5.08629 12.6118C5.23616 12.6118 5.37988 12.5565 5.48585 12.458C5.59182 12.3595 5.65136 12.2259 5.65136 12.0865V1.79819Z" fill="var(--bs-dark)"></path></g><defs><clipPath id="clip0_583_11"><rect width="31" height="13" fill="white"></rect></clipPath></defs></svg>',

    'sales-invoice-svg' => '<svg width="25" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.125 16C13 16 12.7188 15.0625 12.7188 14.5938V9.4375M14.125 16C14.75 16 16 15.7188 16 14.5938V9.4375H12.7188M14.125 16H3.34375C1.46875 16 1 14.4375 1 13.6562V1L3.8125 2.40625L6.625 1L9.90625 2.40625L12.7188 1V9.4375M5.21875 6.15625H8.5M3.34375 9.4375H9.90625M3.34375 12.7188H9.90625" stroke="var(--bs-primary)" stroke-width="0.777778" stroke-linecap="round" stroke-linejoin="round"></path></svg>',

    'debit-note-svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M14 2H6C5.46956 2 4.96086 2.21071 4.58578 2.58579C4.21071 2.96086 4 3.46957 4 4V20C4 20.5304 4 21.5 4 22L7 20L9.5 22L12 20L14.5 22L17 20L20 22C20 22 20 20.5304 20 20V8V4C20 2.89543 19.1046 2 18 2H14Z" stroke="#58bad7 " stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 13H7" stroke="#58bad7 " stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 16H7" stroke="#58bad7 " stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M16 13H15" stroke="#58bad7 " stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M16 16H15" stroke="#58bad7 " stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M8.26 6.47498V9.99998H7.28V6.47498H8.26Z" fill="#58bad7 "/><path d="M12.5831 9.99998H11.6031L10.2981 8.02998V9.99998H9.31809V6.47498H10.2981L11.6031 8.46998V6.47498H12.5831V9.99998Z" fill="#58bad7 "/><path d="M17.0713 6.47498L15.8563 9.99998H14.6013L13.3813 6.47498H14.4313L15.2313 9.01998L16.0263 6.47498H17.0713Z" fill="#58bad7 "/></svg>',

    'credit-note-svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M14 2H6C5.46956 2 4.96086 2.21071 4.58578 2.58579C4.21071 2.96086 4 3.46957 4 4V20C4 20.5304 4 21.5 4 22L7 20L9.5 22L12 20L14.5 22L17 20L20 22C20 22 20 20.5304 20 20V8V4C20 2.89543 19.1046 2 18 2H14Z" stroke="#FF9F00 " stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 13H7" stroke="#FF9F00 " stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 16H7" stroke="#FF9F00 " stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M16 13H15" stroke="#FF9F00 " stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M16 16H15" stroke="#FF9F00 " stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M8.26 6.47498V9.99998H7.28V6.47498H8.26Z" fill="#FF9F00 "/><path d="M12.5831 9.99998H11.6031L10.2981 8.02998V9.99998H9.31809V6.47498H10.2981L11.6031 8.46998V6.47498H12.5831V9.99998Z" fill="#FF9F00 "/><path d="M17.0713 6.47498L15.8563 9.99998H14.6013L13.3813 6.47498H14.4313L15.2313 9.01998L16.0263 6.47498H17.0713Z" fill="#FF9F00 "/></svg>',

    'permission_description' => [

        // =====================================================================
        // BUSINESS — AuthController
        // =====================================================================
        'SolarMitra > Business > AuthController > register'              => 'Register a new business user account via the registration form.',
        'SolarMitra > Business > AuthController > login'                 => 'Access the business login page and authenticate with credentials.',
        'SolarMitra > Business > AuthController > check_user_exists'     => 'Check whether a user account already exists before registration or login.',
        'SolarMitra > Business > AuthController > login_with_otp'        => 'Authenticate using a one-time password (OTP) sent to email or mobile.',
        'SolarMitra > Business > AuthController > send_login_otp'        => 'Send an OTP to the user\'s registered email or mobile for login verification.',
        'SolarMitra > Business > AuthController > verification'          => 'Access the account verification page after registration.',
        'SolarMitra > Business > AuthController > verify_email'          => 'Verify a user\'s email address via the verification link.',
        'SolarMitra > Business > AuthController > verify_mobile'         => 'Verify a user\'s mobile number via OTP.',
        'SolarMitra > Business > AuthController > verify_user'           => 'Admin-level direct verification of a user account without email/mobile OTP.',
        'SolarMitra > Business > AuthController > resend_otp'            => 'Resend a verification OTP to the user\'s email or mobile.',
        'SolarMitra > Business > AuthController > store'                 => 'Enable or disable two-factor authentication for the logged-in account.',
        'SolarMitra > Business > AuthController > destroy'               => 'Remove two-factor authentication from the logged-in account.',
        'SolarMitra > Business > AuthController > regenerateRecoveryCodes' => 'Regenerate backup recovery codes for two-factor authentication.',
        'SolarMitra > Business > AuthController > profile'               => 'View and edit the logged-in user\'s profile information.',
        'SolarMitra > Business > AuthController > logout'                => 'Log out the currently authenticated business user.',
        'SolarMitra > Business > AuthController > update_user'           => 'Update profile details such as name, phone, and profile image.',
        'SolarMitra > Business > AuthController > update_password'       => 'Change the logged-in user\'s account password.',

        // =====================================================================
        // BUSINESS — BusinessController
        // =====================================================================
        'SolarMitra > Business > BusinessController > dashboard'         => 'View the main business dashboard with overview widgets and KPIs.',
        'SolarMitra > Business > BusinessController > get_invoice_series' => 'Fetch the next invoice series number for the business.',
        'SolarMitra > Business > BusinessController > settings'          => 'Access the business settings page for configuration and branding.',
        'SolarMitra > Business > BusinessController > save_business'     => 'Save changes to business profile, logo, and general settings.',
        'SolarMitra > Business > BusinessController > bank_account'      => 'Add or manage bank account details for payment processing.',
        'SolarMitra > Business > BusinessController > bank_account_destroy' => 'Remove a saved bank account from the business.',
        'SolarMitra > Business > BusinessController > address'           => 'Add or manage business address entries.',
        'SolarMitra > Business > BusinessController > address_make_primary' => 'Set a specific address as the primary/default business address.',
        'SolarMitra > Business > BusinessController > address_destroy'   => 'Delete a saved business address.',

        // =====================================================================
        // BUSINESS — ProjectsController
        // =====================================================================
        'SolarMitra > Business > ProjectsController > index'             => 'View the list of all solar installation projects.',
        'SolarMitra > Business > ProjectsController > dashboard'         => 'View the projects dashboard with status breakdown and progress charts.',
        'SolarMitra > Business > ProjectsController > create'            => 'Open the form to create a new solar installation project.',
        'SolarMitra > Business > ProjectsController > store'             => 'Save a new project with client, capacity, type, and location details.',
        'SolarMitra > Business > ProjectsController > edit'              => 'Open the form to edit an existing project\'s details.',
        'SolarMitra > Business > ProjectsController > update'            => 'Save changes to an existing project.',
        'SolarMitra > Business > ProjectsController > destroy'           => 'Permanently delete a project and its associated data.',
        'SolarMitra > Business > ProjectsController > assign_project'    => 'Assign staff members or teams to work on a project.',
        'SolarMitra > Business > ProjectsController > documents'         => 'Manage project documents such as electricity bills, Aadhaar cards, and PAN cards.',
        'SolarMitra > Business > ProjectsController > verification'     => 'Submit and review document verification for project approval.',
        'SolarMitra > Business > ProjectsController > subsidy'           => 'Manage government subsidy registration and tracking for a project.',
        'SolarMitra > Business > ProjectsController > structure'         => 'Track solar panel installation, cabling, and civil work progress.',
        'SolarMitra > Business > ProjectsController > netmeter'          => 'Manage net meter installation steps including demand note, payment, and activation.',
        'SolarMitra > Business > ProjectsController > handover'          => 'Complete project handover with confirmation signature and status update.',
        'SolarMitra > Business > ProjectsController > remove_document'   => 'Remove a specific document type (electricity bill, Aadhaar, PAN, etc.) from a project.',
        'SolarMitra > Business > ProjectsController > remove_project_attachment' => 'Delete an attachment file from a project\'s document collection.',
        'SolarMitra > Business > ProjectsController > get_contact_projects' => 'Fetch projects associated with a specific contact for dropdown population.',
        'SolarMitra > Business > ProjectsController > save_project_phase' => 'Save progress updates for a specific project phase (verification, subsidy, structure, etc.).',
        'SolarMitra > Business > ProjectsController > archived_projects' => 'View the list of archived or completed projects.',
        'SolarMitra > Business > ProjectsController > move_to_projects'  => 'Restore an archived project back to the active projects list.',

        // =====================================================================
        // BUSINESS — TransactionsController
        // =====================================================================
        'SolarMitra > Business > TransactionsController > index'         => 'View the list of all financial transactions (income and expenses).',
        'SolarMitra > Business > TransactionsController > create'        => 'Open the form to record a new income or expense transaction.',
        'SolarMitra > Business > TransactionsController > store'         => 'Save a new transaction with sender, receiver, amount, and payment method.',
        'SolarMitra > Business > TransactionsController > edit'          => 'Open the form to edit an existing transaction\'s details.',
        'SolarMitra > Business > TransactionsController > update'        => 'Save changes to an existing transaction.',
        'SolarMitra > Business > TransactionsController > destroy'       => 'Permanently delete a transaction record.',

        // =====================================================================
        // BUSINESS — ContactsController
        // =====================================================================
        'SolarMitra > Business > ContactsController > index'             => 'View the list of all contacts (clients, staff, suppliers, etc.).',
        'SolarMitra > Business > ContactsController > create'            => 'Open the form to add a new contact to the system.',
        'SolarMitra > Business > ContactsController > store'             => 'Save a new contact with personal, role-specific, and address details.',
        'SolarMitra > Business > ContactsController > edit'              => 'Open the form to edit an existing contact\'s information.',
        'SolarMitra > Business > ContactsController > update'            => 'Save changes to an existing contact.',
        'SolarMitra > Business > ContactsController > assign_type'       => 'Change or assign a contact type (client, staff, supplier, contractor, etc.).',
        'SolarMitra > Business > ContactsController > destroy'           => 'Permanently delete a contact from the system.',
        'SolarMitra > Business > ContactsController > multi_destroy'     => 'Bulk delete multiple selected contacts at once.',
        'SolarMitra > Business > ContactsController > assign_login'      => 'Create a login account for a contact who does not yet have system access.',
        'SolarMitra > Business > ContactsController > verify_user_direct' => 'Directly verify a contact\'s user account without requiring email or mobile OTP.',
        'SolarMitra > Business > ContactsController > clients'           => 'View the filtered list of contacts who are clients.',
        'SolarMitra > Business > ContactsController > staff'             => 'View the filtered list of contacts who are staff members.',
        'SolarMitra > Business > ContactsController > contractors'       => 'View the filtered list of contacts who are contractors.',
        'SolarMitra > Business > ContactsController > suppliers'         => 'View the filtered list of contacts who are suppliers.',
        'SolarMitra > Business > ContactsController > investors'         => 'View the filtered list of contacts who are investors.',
        'SolarMitra > Business > ContactsController > partners'          => 'View the filtered list of contacts who are business partners.',

        // =====================================================================
        // BUSINESS — BusinessConfigMasterController
        // =====================================================================
        'SolarMitra > Business > BusinessConfigMasterController > manage' => 'Access the business configuration management page for system settings.',
        'SolarMitra > Business > BusinessConfigMasterController > reset_business_configs' => 'Reset all business-specific configurations back to their default values.',

        // =====================================================================
        // BUSINESS — QuotationsController
        // =====================================================================
        'SolarMitra > Business > QuotationsController > index'           => 'View the list of all quotations with status tabs (Draft, Sent, Confirmed, etc.).',
        'SolarMitra > Business > QuotationsController > create'          => 'Open the form to create a new quotation with items, pricing, and project details.',
        'SolarMitra > Business > QuotationsController > store'           => 'Save a new quotation with line items, taxes, discounts, and validity period.',
        'SolarMitra > Business > QuotationsController > edit'            => 'Open the form to edit an existing quotation\'s items and financial details.',
        'SolarMitra > Business > QuotationsController > show'            => 'View the detailed breakdown of a specific quotation.',
        'SolarMitra > Business > QuotationsController > update'          => 'Save changes to an existing quotation.',
        'SolarMitra > Business > QuotationsController > destroy'         => 'Permanently delete a quotation and its line items.',
        'SolarMitra > Business > QuotationsController > confirm_quotation' => 'Mark a quotation as confirmed by the client, making it eligible for invoice conversion.',
        'SolarMitra > Business > QuotationsController > convert_to_invoice' => 'Convert a confirmed quotation into a new invoice, copying all items and financial data.',
        'SolarMitra > Business > QuotationsController > get_item_by_category' => 'Fetch material items filtered by category for quotation item selection.',
        'SolarMitra > Business > QuotationsController > get_brands_by_category' => 'Fetch material brands/companies filtered by category for quotation item selection.',
        'SolarMitra > Business > QuotationsController > add_quotation_item' => 'Add a single line item to a quotation via AJAX.',
        'SolarMitra > Business > QuotationsController > add_quotation_category' => 'Add a category group to organize quotation line items.',
        'SolarMitra > Business > QuotationsController > ajax_quotation_addmore_item' => 'Dynamically add additional item rows to the quotation form via AJAX.',
        'SolarMitra > Business > QuotationsController > ajax_quotation_items' => 'Fetch existing quotation items via AJAX for display in the edit form.',
        'SolarMitra > Business > QuotationsController > share_quotation'  => 'Open the share dialog to send a quotation to the client via email or link.',
        'SolarMitra > Business > QuotationsController > ajax_quotation_calculate' => 'Recalculate quotation totals (subtotal, tax, discount, grand total) via AJAX.',
        'SolarMitra > Business > QuotationsController > view_quotation'   => 'View and download the quotation PDF document.',
        'SolarMitra > Business > QuotationsController > download_quotation' => 'Download the quotation PDF document to the local device.',

        // =====================================================================
        // BUSINESS — MaterialsController
        // =====================================================================
        'SolarMitra > Business > MaterialsController > index'            => 'View the list of all material items in the inventory.',
        'SolarMitra > Business > MaterialsController > create'           => 'Open the form to add a new material item with pricing and category details.',
        'SolarMitra > Business > MaterialsController > store'            => 'Save a new material item to the inventory.',
        'SolarMitra > Business > MaterialsController > edit'             => 'Open the form to edit an existing material item\'s details.',
        'SolarMitra > Business > MaterialsController > show'             => 'View the detailed information of a specific material item.',
        'SolarMitra > Business > MaterialsController > update'           => 'Save changes to an existing material item.',
        'SolarMitra > Business > MaterialsController > destroy'          => 'Permanently delete a material item from the inventory.',
        'SolarMitra > Business > MaterialsController > export'           => 'Export the material inventory list to a file (CSV/Excel).',
        'SolarMitra > Business > MaterialsController > import'           => 'Import material items from a CSV/Excel file into the inventory.',
        'SolarMitra > Business > MaterialsController > get_unit_by_category' => 'Fetch available measurement units filtered by material category.',

        // =====================================================================
        // BUSINESS — MaterialCategoriesController
        // =====================================================================
        'SolarMitra > Business > MaterialCategoriesController > list'    => 'View the list of all material categories.',
        'SolarMitra > Business > MaterialCategoriesController > destroy' => 'Delete a material category from the system.',
        'SolarMitra > Business > MaterialCategoriesController > moveup'  => 'Move a material category one position up in the display order.',
        'SolarMitra > Business > MaterialCategoriesController > movedown' => 'Move a material category one position down in the display order.',

        // =====================================================================
        // BUSINESS — MaterialCompaniesController
        // =====================================================================
        'SolarMitra > Business > MaterialCompaniesController > ajax_modal' => 'Load the material company add/edit form in a modal popup via AJAX.',
        'SolarMitra > Business > MaterialCompaniesController > index'    => 'View the list of all material brands/companies.',
        'SolarMitra > Business > MaterialCompaniesController > store'    => 'Save a new material brand/company.',
        'SolarMitra > Business > MaterialCompaniesController > update'   => 'Save changes to an existing material brand/company.',
        'SolarMitra > Business > MaterialCompaniesController > destroy'  => 'Delete a material brand/company from the system.',

        // =====================================================================
        // BUSINESS — MaterialUnitsController
        // =====================================================================
        'SolarMitra > Business > MaterialUnitsController > list'         => 'View the list of all measurement units (kg, piece, metre, etc.).',
        'SolarMitra > Business > MaterialUnitsController > destroy'      => 'Delete a measurement unit from the system.',

        // =====================================================================
        // BUSINESS — QuotationItemsController
        // =====================================================================
        'SolarMitra > Business > QuotationItemsController > index'       => 'View the list of all quotation line items across quotations.',
        'SolarMitra > Business > QuotationItemsController > create'      => 'Open the form to add a new quotation line item.',
        'SolarMitra > Business > QuotationItemsController > store'       => 'Save a new quotation line item with quantity, rate, and tax details.',
        'SolarMitra > Business > QuotationItemsController > edit'        => 'Open the form to edit an existing quotation line item.',
        'SolarMitra > Business > QuotationItemsController > update'      => 'Save changes to an existing quotation line item.',
        'SolarMitra > Business > QuotationItemsController > destroy'     => 'Delete a line item from a quotation.',

        // =====================================================================
        // BUSINESS — InvoicesController
        // =====================================================================
        'SolarMitra > Business > InvoicesController > index'             => 'View the list of all invoices with payment status.',
        'SolarMitra > Business > InvoicesController > create'            => 'Open the form to create a new invoice from a confirmed quotation.',
        'SolarMitra > Business > InvoicesController > store'             => 'Save a new invoice with line items, due date, and financial details.',
        'SolarMitra > Business > InvoicesController > edit'              => 'Open the form to edit an existing invoice\'s details.',
        'SolarMitra > Business > InvoicesController > update'            => 'Save changes to an existing invoice.',
        'SolarMitra > Business > InvoicesController > destroy'           => 'Permanently delete an invoice and its line items.',
        'SolarMitra > Business > InvoicesController > share_invoice'     => 'Open the share dialog to send an invoice to the client via email.',
        'SolarMitra > Business > InvoicesController > get_contact_invoices' => 'Fetch invoices for a specific contact for use in transaction forms.',
        'SolarMitra > Business > InvoicesController > change_to_paid'    => 'Mark an invoice as paid after verifying all payments have been received.',
        'SolarMitra > Business > InvoicesController > view_invoice'      => 'View and stream the invoice PDF document in the browser.',
        'SolarMitra > Business > InvoicesController > download_invoice'  => 'Download the invoice PDF document to the local device.',

        // =====================================================================
        // BUSINESS — LeadsController
        // =====================================================================
        'SolarMitra > Business > LeadsController > index'                => 'View the list of all leads in grid, list, or pipeline view.',
        'SolarMitra > Business > LeadsController > create'               => 'Open the form to add a new lead with contact and project details.',
        'SolarMitra > Business > LeadsController > store'                => 'Save a new lead to the sales pipeline.',
        'SolarMitra > Business > LeadsController > lead_followed'        => 'Mark a lead as followed or toggle follow-up status for tracking.',
        'SolarMitra > Business > LeadsController > details'              => 'View the detailed information and activity history of a lead.',
        'SolarMitra > Business > LeadsController > edit'                 => 'Open the form to edit an existing lead\'s information.',
        'SolarMitra > Business > LeadsController > update'               => 'Save changes to an existing lead.',
        'SolarMitra > Business > LeadsController > destroy'              => 'Permanently delete a lead from the system.',
        'SolarMitra > Business > LeadsController > multi_destroy'        => 'Bulk delete multiple selected leads at once.',
        'SolarMitra > Business > LeadsController > assign_lead'          => 'Assign a lead to a specific sales team member for follow-up.',
        'SolarMitra > Business > LeadsController > lead_change_stage'    => 'Move a lead to a different stage in the sales pipeline (New, Contacted, Qualified, etc.).',
        'SolarMitra > Business > LeadsController > lead_client_group'    => 'Assign or change a lead\'s client group classification.',
        'SolarMitra > Business > LeadsController > lead_source'          => 'Set or update the source of a lead (Referral, Website, Walk-in, etc.).',
        'SolarMitra > Business > LeadsController > lead_potential'       => 'Rate or update the conversion potential of a lead.',
        'SolarMitra > Business > LeadsController > export'               => 'Export the leads list to a file (CSV/Excel).',
        'SolarMitra > Business > LeadsController > import'               => 'Import leads from a CSV/Excel file into the system.',
        'SolarMitra > Business > LeadsController > client_group'         => 'View the list of all client groups for lead classification.',
        'SolarMitra > Business > LeadsController > destroy_client_group' => 'Delete a client group from the system.',
        'SolarMitra > Business > LeadsController > sources'              => 'View the list of all lead sources configured in the system.',
        'SolarMitra > Business > LeadsController > destroy_source'       => 'Delete a lead source from the system.',
        'SolarMitra > Business > LeadsController > channels'             => 'View the list of all lead channels configured in the system.',
        'SolarMitra > Business > LeadsController > destroy_channel'      => 'Delete a lead channel from the system.',

        // =====================================================================
        // BUSINESS — CampaignsController
        // =====================================================================
        'SolarMitra > Business > CampaignsController > index'            => 'View the list of all marketing campaigns.',
        'SolarMitra > Business > CampaignsController > create'           => 'Open the form to create a new marketing campaign.',
        'SolarMitra > Business > CampaignsController > store'            => 'Save a new campaign with name, type, and target details.',
        'SolarMitra > Business > CampaignsController > edit'             => 'Open the form to edit an existing campaign.',
        'SolarMitra > Business > CampaignsController > update'           => 'Save changes to an existing campaign.',
        'SolarMitra > Business > CampaignsController > destroy'          => 'Permanently delete a campaign.',

        // =====================================================================
        // BUSINESS — BusinessRolesController
        // =====================================================================
        'SolarMitra > Business > BusinessRolesController > index'        => 'View the list of all business roles and their permission counts.',
        'SolarMitra > Business > BusinessRolesController > dashboard'    => 'View the roles dashboard showing department structure and role descriptions.',
        'SolarMitra > Business > BusinessRolesController > create'       => 'Open the form to create a new business role.',
        'SolarMitra > Business > BusinessRolesController > store'        => 'Save a new business role with name, guard, and description.',
        'SolarMitra > Business > BusinessRolesController > edit'         => 'Open the form to edit an existing business role.',
        'SolarMitra > Business > BusinessRolesController > update'       => 'Save changes to an existing business role.',
        'SolarMitra > Business > BusinessRolesController > destroy'      => 'Delete a business role (only if not assigned to any users).',

        // =====================================================================
        // BUSINESS — PermissionsController
        // =====================================================================
        'SolarMitra > Business > PermissionsController > index'                    => 'View the master permissions page with all module-wise permission toggles.',
        'SolarMitra > Business > PermissionsController > roles_permissions'        => 'View the roles vs permissions matrix with toggle switches for each role.',
        'SolarMitra > Business > PermissionsController > get_role_permissions'     => 'View the detailed permissions list for a specific role in a popup.',
        'SolarMitra > Business > PermissionsController > user_permissions'         => 'View the list of users with permission management buttons.',
        'SolarMitra > Business > PermissionsController > manage_user_permissions'  => 'Manage individual permission toggles for a specific user.',
        'SolarMitra > Business > PermissionsController > manage_role_all_permissions' => 'Toggle all permissions on or off for a specific role in one action.',
        'SolarMitra > Business > PermissionsController > manage_role_permission'   => 'Toggle a single permission on or off for a specific role.',
        'SolarMitra > Business > PermissionsController > manage_user_permission'   => 'Toggle a single permission on, off, or deny for a specific user.',
        'SolarMitra > Business > PermissionsController > delete_user_permission'   => 'Remove a specific permission from a user\'s direct permission list.',
        'SolarMitra > Business > PermissionsController > manage_user_all_permission' => 'Grant or revoke all permissions for a specific user in one action.',
        'SolarMitra > Business > PermissionsController > temp_permissions'         => 'View the generated temp permissions tree before syncing to the permissions table.',
        'SolarMitra > Business > PermissionsController > generate_permissions'     => 'Scan all registered routes and generate temp permissions entries for new routes.',
        'SolarMitra > Business > PermissionsController > add_to_permissions'       => 'Sync temp permissions into the actual permissions table, adding any missing entries.',
        'SolarMitra > Business > PermissionsController > permission_by_action'     => 'Fetch the role or user toggle switches for a specific permission via AJAX.',
        'SolarMitra > Business > PermissionsController > get_users_by_role'        => 'Fetch all users assigned to a specific role for display in the permissions view.',
        'SolarMitra > Business > PermissionsController > get_permission_by_user'   => 'Fetch the permission toggle state for a specific user and permission.',

        // =====================================================================
        // ADMIN — BusinessesController
        // =====================================================================
        'SolarMitra > Admin > BusinessesController > index'              => 'View the list of all registered businesses on the platform.',
        'SolarMitra > Admin > BusinessesController > create'             => 'Open the form to register a new business account.',
        'SolarMitra > Admin > BusinessesController > store'              => 'Save a new business with owner, plan, and configuration details.',
        'SolarMitra > Admin > BusinessesController > edit'               => 'Open the form to edit an existing business\'s details.',
        'SolarMitra > Admin > BusinessesController > update'             => 'Save changes to an existing business.',
        'SolarMitra > Admin > BusinessesController > destroy'            => 'Permanently delete a business and all associated data.',

        // =====================================================================
        // ADMIN — ConfigMasterController
        // =====================================================================
        'SolarMitra > Admin > ConfigMasterController > index'            => 'View the list of all system configuration fields.',
        'SolarMitra > Admin > ConfigMasterController > create'           => 'Open the form to add a new system configuration field.',
        'SolarMitra > Admin > ConfigMasterController > store'            => 'Save a new configuration field with key, default value, and display title.',
        'SolarMitra > Admin > ConfigMasterController > edit'             => 'Open the form to edit an existing configuration field.',
        'SolarMitra > Admin > ConfigMasterController > update'           => 'Save changes to an existing configuration field.',
        'SolarMitra > Admin > ConfigMasterController > destroy'          => 'Delete a configuration field from the system.',
        'SolarMitra > Admin > ConfigMasterController > manage'           => 'Access the configuration management page for editing field values.',

        // =====================================================================
        // ADMIN — TransactionTypesController
        // =====================================================================
        'SolarMitra > Admin > TransactionTypesController > list'         => 'View the list of all transaction type categories (income/expense heads).',
        'SolarMitra > Admin > TransactionTypesController > destroy'      => 'Delete a transaction type from the system.',

        // =====================================================================
        // ADMIN — ProjectsController
        // =====================================================================
        'SolarMitra > Admin > ProjectsController > project_phases'       => 'Manage the configurable project phase steps and their ordering.',
        'SolarMitra > Admin > ProjectsController > project_phases_view'  => 'View the project phases configuration without edit access.',
        'SolarMitra > Admin > ProjectsController > destory_project_phase' => 'Delete a project phase step from the configuration.',

        // =====================================================================
        // ADMIN — QuotationsController
        // =====================================================================
        'SolarMitra > Admin > QuotationsController > get_brands_by_category' => 'Fetch material brands filtered by category for quotation item selection (admin).',

        // =====================================================================
        // ADMIN — MaterialsController
        // =====================================================================
        'SolarMitra > Admin > MaterialsController > index'               => 'View the list of all material items across all businesses (admin overview).',
        'SolarMitra > Admin > MaterialsController > create'              => 'Open the form to add a new material item as an administrator.',
        'SolarMitra > Admin > MaterialsController > store'               => 'Save a new material item to the global inventory.',
        'SolarMitra > Admin > MaterialsController > edit'                => 'Open the form to edit an existing material item (admin).',
        'SolarMitra > Admin > MaterialsController > update'              => 'Save changes to an existing material item (admin).',
        'SolarMitra > Admin > MaterialsController > destroy'             => 'Delete a material item from the global inventory.',
        'SolarMitra > Admin > MaterialsController > get_unit_by_category' => 'Fetch measurement units filtered by material category (admin).',

        // =====================================================================
        // ADMIN — MaterialCategoriesController
        // =====================================================================
        'SolarMitra > Admin > MaterialCategoriesController > list'       => 'View the list of all material categories (admin).',
        'SolarMitra > Admin > MaterialCategoriesController > destroy'    => 'Delete a material category (admin).',
        'SolarMitra > Admin > MaterialCategoriesController > moveup'     => 'Move a material category one position up in display order (admin).',
        'SolarMitra > Admin > MaterialCategoriesController > movedown'   => 'Move a material category one position down in display order (admin).',

        // =====================================================================
        // ADMIN — MaterialCompaniesController
        // =====================================================================
        'SolarMitra > Admin > MaterialCompaniesController > ajax_modal'  => 'Load the material company form in a modal popup via AJAX (admin).',
        'SolarMitra > Admin > MaterialCompaniesController > index'       => 'View the list of all material brands/companies (admin).',
        'SolarMitra > Admin > MaterialCompaniesController > store'       => 'Save a new material brand/company (admin).',
        'SolarMitra > Admin > MaterialCompaniesController > update'      => 'Save changes to an existing material brand/company (admin).',
        'SolarMitra > Admin > MaterialCompaniesController > destroy'     => 'Delete a material brand/company (admin).',

        // =====================================================================
        // ADMIN — MaterialUnitsController
        // =====================================================================
        'SolarMitra > Admin > MaterialUnitsController > list'            => 'View the list of all measurement units (admin).',
        'SolarMitra > Admin > MaterialUnitsController > destroy'         => 'Delete a measurement unit (admin).',

        // =====================================================================
        // ADMIN — BusinessRolesController
        // =====================================================================
        'SolarMitra > Admin > BusinessRolesController > index'           => 'View the list of all business roles (admin overview).',
        'SolarMitra > Admin > BusinessRolesController > create'          => 'Open the form to create a new business role (admin).',
        'SolarMitra > Admin > BusinessRolesController > store'           => 'Save a new business role (admin).',
        'SolarMitra > Admin > BusinessRolesController > edit'            => 'Open the form to edit an existing business role (admin).',
        'SolarMitra > Admin > BusinessRolesController > update'          => 'Save changes to an existing business role (admin).',
        'SolarMitra > Admin > BusinessRolesController > destroy'         => 'Delete a business role (admin).',

        // =====================================================================
        // API — AuthController
        // =====================================================================
        'SolarMitra > Api > AuthController > login_with_email'           => 'Authenticate with email and OTP via the API.',
        'SolarMitra > Api > AuthController > login_with_password'        => 'Authenticate with email and password via the API.',
        'SolarMitra > Api > AuthController > login_with_mobile'          => 'Authenticate with mobile number and OTP via the API.',
        'SolarMitra > Api > AuthController > verify_otp'                 => 'Verify an OTP code for account registration or login via the API.',
        'SolarMitra > Api > AuthController > profile'                    => 'View or update the authenticated user\'s profile via the API.',
        'SolarMitra > Api > AuthController > logout'                     => 'Log out the authenticated user and invalidate the API token.',

        // =====================================================================
        // API — DashboardController
        // =====================================================================
        'SolarMitra > Api > DashboardController > dashboard'             => 'Fetch dashboard data (KPIs, project counts, revenue) via the API.',

        // =====================================================================
        // API — ProjectsController
        // =====================================================================
        'SolarMitra > Api > ProjectsController > list'                   => 'Fetch the list of projects with filters via the API.',
        'SolarMitra > Api > ProjectsController > save_project'           => 'Create or update a project with all details via the API.',
        'SolarMitra > Api > ProjectsController > destroy'                => 'Delete a project via the API.',
        'SolarMitra > Api > ProjectsController > assign_staff'           => 'Assign staff members to a project via the API.',
        'SolarMitra > Api > ProjectsController > documents'              => 'Manage project documents via the API.',
        'SolarMitra > Api > ProjectsController > verification'           => 'Submit or review document verification via the API.',
        'SolarMitra > Api > ProjectsController > subsidy'                => 'Manage government subsidy registration via the API.',
        'SolarMitra > Api > ProjectsController > structure'              => 'Track solar panel installation progress via the API.',
        'SolarMitra > Api > ProjectsController > netmeter'               => 'Manage net meter installation steps via the API.',
        'SolarMitra > Api > ProjectsController > handover'               => 'Complete project handover via the API.',
        'SolarMitra > Api > ProjectsController > remove_review_video'    => 'Remove a review video attachment from a project via the API.',
        'SolarMitra > Api > ProjectsController > remove_document'        => 'Remove a document from a project via the API.',
        'SolarMitra > Api > ProjectsController > remove_project_attachment' => 'Remove an attachment from a project via the API.',

        // =====================================================================
        // API — ContactsController
        // =====================================================================
        'SolarMitra > Api > ContactsController > list'                   => 'Fetch the list of contacts with type filters via the API.',
        'SolarMitra > Api > ContactsController > store'                  => 'Create or update a contact with role-specific details via the API.',
        'SolarMitra > Api > ContactsController > destroy'                => 'Delete a contact via the API.',

        // =====================================================================
        // API — QuotationsController
        // =====================================================================
        'SolarMitra > Api > QuotationsController > list'                 => 'Fetch the list of quotations with status filters via the API.',
        'SolarMitra > Api > QuotationsController > get_dropdown_list'    => 'Fetch quotations formatted for dropdown selection via the API.',
        'SolarMitra > Api > QuotationsController > save_quotation'       => 'Create or update a quotation with items and project details via the API.',
        'SolarMitra > Api > QuotationsController > destroy'              => 'Delete a quotation via the API.',
        'SolarMitra > Api > QuotationsController > status_change'        => 'Change the status of a quotation (Draft, Sent, Confirmed, etc.) via the API.',
        'SolarMitra > Api > QuotationsController > item_destroy'         => 'Delete a specific line item from a quotation via the API.',
        'SolarMitra > Api > QuotationsController > convert_to_invoice'   => 'Convert a confirmed quotation into an invoice via the API.',
        'SolarMitra > Api > QuotationsController > view_quotation'       => 'Fetch quotation details and PDF URL via the API.',
        'SolarMitra > Api > QuotationsController > download_quotation'   => 'Download the quotation PDF via the API.',

        // =====================================================================
        // API — InvoicesController
        // =====================================================================
        'SolarMitra > Api > InvoicesController > list'                   => 'Fetch the list of invoices with payment status filters via the API.',
        'SolarMitra > Api > InvoicesController > store'                  => 'Create a new invoice from a confirmed quotation via the API.',
        'SolarMitra > Api > InvoicesController > destroy'                => 'Delete an invoice via the API.',
        'SolarMitra > Api > InvoicesController > update'                 => 'Update invoice details (date, due date, status) via the API.',
        'SolarMitra > Api > InvoicesController > view_invoice'           => 'Fetch invoice details and PDF URL via the API.',
        'SolarMitra > Api > InvoicesController > download_invoice'       => 'Download the invoice PDF via the API.',

        // =====================================================================
        // API — MaterialsController
        // =====================================================================
        'SolarMitra > Api > MaterialsController > list'                  => 'Fetch the list of material items via the API.',
        'SolarMitra > Api > MaterialsController > get_category_with_company' => 'Fetch material categories with their associated companies via the API.',
        'SolarMitra > Api > MaterialsController > get_companies_by_category' => 'Fetch material companies filtered by category via the API.',
        'SolarMitra > Api > MaterialsController > get_items_by_company_and_category' => 'Fetch material items filtered by both company and category via the API.',
        'SolarMitra > Api > MaterialsController > get_item_by_category'  => 'Fetch material items filtered by category via the API.',

        // =====================================================================
        // API — LeadsController
        // =====================================================================
        'SolarMitra > Api > LeadsController > index'                     => 'Fetch the list of leads via the API.',
        'SolarMitra > Api > LeadsController > save_multiple'             => 'Bulk create or update multiple leads in a single API call.',
        'SolarMitra > Api > LeadsController > lead_resources'            => 'Fetch lead sources, channels, and client groups for dropdown population via the API.',
        'SolarMitra > Api > LeadsController > save_lead'                 => 'Create or update a single lead with all details via the API.',
        'SolarMitra > Api > LeadsController > destroy'                   => 'Delete a lead via the API.',
        'SolarMitra > Api > LeadsController > assign_lead'               => 'Assign a lead to a team member via the API.',

        // =====================================================================
        // ADMIN – ChannelsController
        // =====================================================================
        'SolarMitra > Admin > ChannelsController > index'                => 'View the list of all lead channels configured in the system (admin).',
        'SolarMitra > Admin > ChannelsController > create'               => 'Open the form to add a new lead channel (admin).',
        'SolarMitra > Admin > ChannelsController > store'                => 'Save a new lead channel to the system (admin).',
        'SolarMitra > Admin > ChannelsController > edit'                 => 'Open the form to edit an existing lead channel (admin).',
        'SolarMitra > Admin > ChannelsController > update'               => 'Save changes to an existing lead channel (admin).',
        'SolarMitra > Admin > ChannelsController > destroy'              => 'Delete a lead channel from the system (admin).',

        // =====================================================================
        // ADMIN – SourcesController
        // =====================================================================
        'SolarMitra > Admin > SourcesController > index'                 => 'View the list of all lead sources configured in the system (admin).',
        'SolarMitra > Admin > SourcesController > create'                => 'Open the form to add a new lead source (admin).',
        'SolarMitra > Admin > SourcesController > store'                 => 'Save a new lead source to the system (admin).',
        'SolarMitra > Admin > SourcesController > edit'                  => 'Open the form to edit an existing lead source (admin).',
        'SolarMitra > Admin > SourcesController > update'                => 'Save changes to an existing lead source (admin).',
        'SolarMitra > Admin > SourcesController > destroy'               => 'Delete a lead source from the system (admin).',

        // =====================================================================
        // ADMIN – AppFeedbacksController
        // =====================================================================
        'SolarMitra > Admin > AppFeedbacksController > index'            => 'View the list of all app feedback submissions received (admin).',

        // =====================================================================
        // API – AppFeedbacksController
        // =====================================================================
        'SolarMitra > Api > AppFeedbacksController > store'              => 'Submit new app feedback from the mobile or web client via the API.',

        // =====================================================================
        // API – InvoicesController (additional)
        // =====================================================================
        'SolarMitra > Api > InvoicesController > show'                   => 'Fetch the detailed information of a specific invoice via the API.',
        'SolarMitra > Api > InvoicesController > change_to_paid'         => 'Mark an invoice as paid via the API.',

        // =====================================================================
        // API – TransactionsController
        // =====================================================================
        'SolarMitra > Api > TransactionsController > list'               => 'Fetch the list of financial transactions via the API.',
        'SolarMitra > Api > TransactionsController > show'               => 'Fetch the detailed information of a specific transaction via the API.',
        'SolarMitra > Api > TransactionsController > store'              => 'Create a new income or expense transaction via the API.',
        'SolarMitra > Api > TransactionsController > update'             => 'Update an existing transaction\'s details via the API.',
        'SolarMitra > Api > TransactionsController > destroy'            => 'Delete a transaction via the API.',
        'SolarMitra > Api > TransactionsController > get_expense_head'   => 'Fetch the list of expense transaction type heads via the API.',
        'SolarMitra > Api > TransactionsController > get_income_head'    => 'Fetch the list of income transaction type heads via the API.',

        // =====================================================================
        // BUSINESS – AuthController (additional)
        // =====================================================================
        'SolarMitra > Business > AuthController > update_contact_form'  => 'Open the form to update the logged-in user\'s contact details.',
        'SolarMitra > Business > AuthController > update_contact'       => 'Save changes to the logged-in user\'s contact details.',

        // =====================================================================
        // BUSINESS – ContactsController (additional)
        // =====================================================================
        'SolarMitra > Business > ContactsController > verify_user_modal' => 'Open the modal to verify a contact\'s user account directly.',
        'SolarMitra > Business > ContactsController > verify_user_field' => 'Verify a specific contact field (email or mobile) directly without OTP.',

        // =====================================================================
        // BUSINESS – InvoicesController (additional)
        // =====================================================================
        'SolarMitra > Business > InvoicesController > show'              => 'View the detailed breakdown of a specific invoice.',
    ]

];
