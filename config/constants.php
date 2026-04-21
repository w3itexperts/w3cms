<?php



return [

	/*
	* Version of W3cms
	*/
	'version' => '2.7',

	/*
	* Default Image for user and category
	*/
	'user_default_img' => env('ASSET_URL').'/images/no-user.png',
	'category_default_img' => env('ASSET_URL').'/images/no-category.png',

	/*
	* Usage for super admin condition
	*/
	'roles' => array(
		'admin' => 'Super Admin'
	),

	/*
	* Default translable language
	*/
	'available_langs' => [
	  'en' => 'English',
	  'ru' => 'Russian',
	  'fr' => 'French',
	  'hi' => 'Hindi',

	],

	/*
	* for insert widget & sidebar Cpt at run time 
	* if not exist
	*/
	'default_cpts' => array(
		array(
			'blog' 		=> array(
				'title' => 'Widgets',
				'slug' => 'widgets',
				'status' => 1,
				'post_type' => 'cpt',
				'visibility' => 'pu',
			),
			'cpt' 		=> array(
				'cpt_label' => 'Widgets',
				'cpt_name' => 'widgets' ,
				'cpt_singular_name' => 'Widget',
				'cpt_description' => '',
				'cpt_public' => 1,
				'cpt_show_ui' => 1,
				'cpt_show_in_menu' => 0,
				'cpt_icon_slug' => '',
				'cpt_supports' => 'a:3:{i:0;s:5:"Title";i:1;s:6:"Editor";i:2;s:4:"Slug";}',
				'cpt_builtin_taxonomies' => 'a:1:{i:0;s:10:"Categories";}',
			)
		),
		array(
			'blog' 		=> array(
				'title' => 'Sidebars',
				'slug' => 'sidebars',
				'status' => 1,
				'post_type' => 'cpt',
				'visibility' => 'pu',
			),
			'cpt' 		=> array(
				'cpt_label' => 'Sidebars',
				'cpt_name' => 'sidebars' ,
				'cpt_singular_name' => 'Sidebar',
				'cpt_description' => '',
				'cpt_public' => 1,
				'cpt_show_ui' => 1,
				'cpt_show_in_menu' => 0,
				'cpt_icon_slug' => '',
				'cpt_supports' => 'a:3:{i:0;s:5:"Title";i:1;s:6:"Editor";i:2;s:4:"Slug";}',
				'cpt_builtin_taxonomies' => 'a:1:{i:0;s:10:"Categories";}',
			)
		),
	),

	/*
	|--------------------------------------------------------------------------
	| Permalink Option Format
	|--------------------------------------------------------------------------
	|
	| These configuration options determine permalink option.
	|
	*/
	'routesType' => array(
		'Plain'             => '',
		'DayName'           => '/%year%/%month%/%day%/%slug%/',
		'MonthName'         => '/%year%/%month%/%slug%/',
		'Numeric'           => '/archives/%post_id%',
		'PostName'          => '/%slug%/',
		'CustomeStructure'  => 'custom',
    ),
	
	'post_formats' => array(
		'0' 		=> 'Standard',
		'aside' 	=> 'Aside',
		'chat' 		=> 'Chat',
		'gallery' 	=> 'Gallery',
		'link' 		=> 'Link',
		'image' 	=> 'Image',
		'quote' 	=> 'Quote',
		'status' 	=> 'Status',
		'video' 	=> 'Video',
		'audio' 	=> 'Audio',
    ),

	/*
	|--------------------------------------------------------------------------
	| Discussion Comment Cookie
	|--------------------------------------------------------------------------
	|
	| These configuration options determine hash cookie.
	|
	*/
	'comment_cookie_hash' => md5(env('APP_URL')),

	'Placeholder'   => array(
		'User' => array(
			'username'=>array('placeholder'=>'#USERNAME#','guideline'=>'Username can display with this placeholder.'),
			'name'=>array('placeholder'=>'#FULLNAME#','guideline'=>'Name can display with this placeholder.'),
			'email'=>array('placeholder'=>'#EMAIL#','guideline'=>'Email can display with this placeholder.'),
			'firstname'=>array('placeholder'=>'#FIRSTNAME#','guideline'=>'Firstname can display with this placeholder.'),
			'lastname'=>array('placeholder'=>'#LASTNAME#','guideline'=>'Lastname can display with this placeholder.'),
			'password'=>array('placeholder'=>'#PASSWORD#','guideline'=>'password can display with this placeholder.'),
			'role'=>array('placeholder'=>'#ROLE#','guideline'=>'User role can display with this placeholder.'),
			'profile'=>array('placeholder'=>'#PROFILE#','guideline'=>'User profile can display with this placeholder.')
		),
		'Role' => array(
			'username'=>array('placeholder'=>'#USERNAME#','guideline'=>'Username can display with this placeholder.'),
			'name'=>array('placeholder'=>'#NAME#','guideline'=>'Firstname can display with this placeholder.')
		),
		'Config' => array(
			'Site.title'=>array('placeholder'=>'#SITETITLE#','guideline'=>'Site title can display with this placeholder.'),
			'Site.link'=>array('placeholder'=>'#SITELINK#','guideline'=>'Site link can display with this placeholder.'),
			'Site.admin_email'=>array('placeholder'=>'#ADMINEMAIL#','guideline'=>'Admin email can display with this placeholder.'),
			'Site.support_email'=>array('placeholder'=>'#SUPPORTEMAIL#','guideline'=>'Support email can display with this placeholder.'),
			'Site.company_address'=>array('placeholder'=>'#SITEADDRESS#','guideline'=>'Site address can display with this placeholder.')
		),
		'Generate' => array(
			'activation_link'=>array('placeholder'=>'#ACTIVATIONLINK#','guideline'=>'Activation link can display with this placeholder.'),
			'site_logo'=>array('placeholder'=>'#SITELOGO#','guideline'=>'Site logo can display with this placeholder.'),
			'login_link' =>array('placeholder'=>'#LOGINLINK#','guideline'=>'Login link can display with this placeholder.'),
			'register_link' =>array('placeholder'=>'#REGESTERLINK#','guideline'=>'Registration link can display with this placeholder.')
		),
		'Contact' => array(
			'username'=>array('placeholder'=>'#USERNAME#','guideline'=>'Username can display with this placeholder.'),
			'first_name'=>array('placeholder'=>'#FIRSTNAME#','guideline'=>'Contact First name can display with this placeholder.'),
			'last_name'=>array('placeholder'=>'#LASTNAME#','guideline'=>'Contact Last name can display with this placeholder.'),
			'email'=>array('placeholder'=>'#EMAIL#','guideline'=>'Contact user email can display with this placeholder.'),
			'phone_number'=>array('placeholder'=>'#PHONENUMBER#','guideline'=>'Contact user phone number can display with this placeholder.'),
			'message'=>array('placeholder'=>'#MESSAGE#','guideline'=>'Contact user message can display with this placeholder.'),
			
			'contact_name'=>array('placeholder'=>'#CONTACTNAME#','guideline'=>'Contact Full Name can display with this placeholder.'),
			'contact_detail'=>array('placeholder'=>'#CONTACTDETAIL#','guideline'=>'Contact Name - Email - Phone Number can display with this placeholder.'),
			'email'=>array('placeholder'=>'#EMAIL#','guideline'=>'Contact Email can display with this placeholder.'),
			'phone'=>array('placeholder'=>'#PHONE#','guideline'=>'Contact Phone can display with this placeholder.'),
			'type'=>array('placeholder'=>'#TYPE#','guideline'=>'Contact Type can display with this placeholder.'),
		),
		'Subscribe' => array(
			'name'=>array('placeholder'=>'#USERNAME#','guideline'=>'Subscribe user email can display with this placeholder.')
		),
		'Blog' => array(
			'username'=>array('placeholder'=>'#USERNAME#','guideline'=>'Username can display with this placeholder.'),
			'title'=>array('placeholder'=>'#BLOGTITLE#','guideline'=>'Blog title can display with this placeholder.'),
			'content'=>array('placeholder'=>'#BLOGCONTENT#','guideline'=>'Blog content can display with this placeholder.'),
			'taxonomy_title'=>array('placeholder'=>'#TAXONOMYTITLE#','guideline'=>'Taxonomy title can display with this placeholder.'),
			'taxonomy_content'=>array('placeholder'=>'#TAXONOMYCONTENT#','guideline'=>'Taxonomy content can display with this placeholder.'),
			'post_type_title'=>array('placeholder'=>'#POSTTYPETITLE#','guideline'=>'Post type title can display with this placeholder.'),
			'post_type_content'=>array('placeholder'=>'#POSTTYPECONTENT#','guideline'=>'Post type content can display with this placeholder.'),
		),
		'Comment' => array(
			'username'=>array('placeholder'=>'#USERNAME#','guideline'=>'Username can display with this placeholder.'),
			'comment'=>array('placeholder'=>'#BLOGCOMMENT#','guideline'=>'Blog comment can display with this placeholder.'),
			'title'=>array('placeholder'=>'#BLOGTITLE#','guideline'=>'Blog title can display with this placeholder.'),
		),
		'BlogCategory' => array(
			'username'=>array('placeholder'=>'#USERNAME#','guideline'=>'Username can display with this placeholder.'),
			'title'=>array('placeholder'=>'#BLOGCATEGORYTITLE#','guideline'=>'Blog category title can display with this placeholder.'),
			'content'=>array('placeholder'=>'#BLOGCATEGORYCONTENT#','guideline'=>'Blog category content can display with this placeholder.'),
		),
		'BlogTag' => array(
			'username'=>array('placeholder'=>'#USERNAME#','guideline'=>'Username can display with this placeholder.'),
			'title'=>array('placeholder'=>'#BLOGTAGTITLE#','guideline'=>'Blog tag title can display with this placeholder.'),
		),
		'Page' => array(
			'username'=>array('placeholder'=>'#USERNAME#','guideline'=>'Username can display with this placeholder.'),
			'title'=>array('placeholder'=>'#PAGETITLE#','guideline'=>'Page title can display with this placeholder.'),
			'content'=>array('placeholder'=>'#PAGECONTENT#','guideline'=>'Page content can display with this placeholder.'),
		),
		'Lead' => array(
			'username'=>array('placeholder'=>'#USERNAME#','guideline'=>'Username can display with this placeholder.'),
			'lead_name'=>array('placeholder'=>'#LEADNAME#','guideline'=>'Lead Full Name can display with this placeholder.'),
			'lead_detail'=>array('placeholder'=>'#LEADDETAIL#','guideline'=>'Lead Name - Email - Phone Number can display with this placeholder.'),
			'email'=>array('placeholder'=>'#EMAIL#','guideline'=>'Lead Email can display with this placeholder.'),
			'phone'=>array('placeholder'=>'#PHONE#','guideline'=>'Lead Phone can display with this placeholder.'),
		),
		'ClientGroup' => array(
			'username'=>array('placeholder'=>'#USERNAME#','guideline'=>'Username can display with this placeholder.'),
			'title'=>array('placeholder'=>'#CLIENTGROUPTITLE#','guideline'=>'Client Group Title can display with this placeholder.'),
		),
		'Source' => array(
			'username'=>array('placeholder'=>'#USERNAME#','guideline'=>'Username can display with this placeholder.'),
			'name'=>array('placeholder'=>'#SOURCENAME#','guideline'=>'Source Name can display with this placeholder.'),
			'type'=>array('placeholder'=>'#TYPE#','guideline'=>'Source Type can display with this placeholder.'),
			'channel'=>array('placeholder'=>'#CHANNEL#','guideline'=>'Source Channel can display with this placeholder.'),
		),
		'Channel' => array(
			'username'=>array('placeholder'=>'#USERNAME#','guideline'=>'Username can display with this placeholder.'),
			'title'=>array('placeholder'=>'#CHANNELTITLE#','guideline'=>'Channel Title can display with this placeholder.'),
			'description'=>array('placeholder'=>'#DESCRIPTION#','guideline'=>'Channel Description can display with this placeholder.'),
		),
		'Campaign' => array(
			'username'=>array('placeholder'=>'#USERNAME#','guideline'=>'Username can display with this placeholder.'),
			'purpose'=>array('placeholder'=>'#PURPOSE#','guideline'=>'Campaign Purpose can display with this placeholder.'),
			'channel'=>array('placeholder'=>'#CHANNEL#','guideline'=>'Campaign Channel can display with this placeholder.'),
			'source'=>array('placeholder'=>'#SOURCE#','guideline'=>'Campaign Source can display with this placeholder.'),
		),
		'Invoice' => array(
			'username'=>array('placeholder'=>'#USERNAME#','guideline'=>'Username can display with this placeholder.'),
			'title'=>array('placeholder'=>'#INVOICETITLE#','guideline'=>'Invoice Title can display with this placeholder.'),
			'client_name'=>array('placeholder'=>'#CLIENTNAME#','guideline'=>'Invoice Client Name can display with this placeholder.'),
			'invoice_number'=>array('placeholder'=>'#INVOICENUMBER#','guideline'=>'Invoice Number can display with this placeholder.'),
			'total_amount'=>array('placeholder'=>'#TOTALAMOUNT#','guideline'=>'Invoice Total Amount can display with this placeholder.'),
			'status'=>array('placeholder'=>'#STATUS#','guideline'=>'Invoice Status can display with this placeholder.'),
		),
		'QuotationItem' => array(
			'username'=>array('placeholder'=>'#USERNAME#','guideline'=>'Username can display with this placeholder.'),
			'item_title'=>array('placeholder'=>'#QUOTATIONITEMTITLE#','guideline'=>'Quotation Item Title can display with this placeholder.'),
			'quotation_title'=>array('placeholder'=>'#QUOTATIONTITLE#','guideline'=>'Quotation Title can display with this placeholder.'),
			'rates_per_units'=>array('placeholder'=>'#RATESPERUNITS#','guideline'=>'Rates Per Units can display with this placeholder.'),
			'amount'=>array('placeholder'=>'#AMOUNT#','guideline'=>'Amount can display with this placeholder.'),
		),
		'MaterialCompany' => array(
			'username'=>array('placeholder'=>'#USERNAME#','guideline'=>'Username can display with this placeholder.'),
			'title'=>array('placeholder'=>'#MATERIALCOMPANYTITLE#','guideline'=>'Material Company Title can display with this placeholder.'),
			'description'=>array('placeholder'=>'#DESCRIPTION#','guideline'=>'Description can display with this placeholder.'),
		),
		'MaterialCategory' => array(
			'username'=>array('placeholder'=>'#USERNAME#','guideline'=>'Username can display with this placeholder.'),
			'title'=>array('placeholder'=>'#MATERIALCATEGORYTITLE#','guideline'=>'Material Category Title can display with this placeholder.'),
			'description'=>array('placeholder'=>'#DESCRIPTION#','guideline'=>'Description can display with this placeholder.'),
		),
		'Material' => array(
			'username'=>array('placeholder'=>'#USERNAME#','guideline'=>'Username can display with this placeholder.'),
			'title'=>array('placeholder'=>'#MATERIALTITLE#','guideline'=>'Material Title can display with this placeholder.'),
			'description'=>array('placeholder'=>'#DESCRIPTION#','guideline'=>'Description can display with this placeholder.'),
			'material_company'=>array('placeholder'=>'#MATERIALCOMPANY#','guideline'=>'Material Company can display with this placeholder.'),
			'material_category'=>array('placeholder'=>'#MATERIALCATEGORY#','guideline'=>'Material Category can display with this placeholder.'),
		),
		'Quotation' => array(
			'username'=>array('placeholder'=>'#USERNAME#','guideline'=>'Username can display with this placeholder.'),
			'title'=>array('placeholder'=>'#QUOTATIONTITLE#','guideline'=>'Quotation Title can display with this placeholder.'),
			'description'=>array('placeholder'=>'#DESCRIPTION#','guideline'=>'Description can display with this placeholder.'),
			'client_name'=>array('placeholder'=>'#CLIENTNAME#','guideline'=>'Quotation Client Name can display with this placeholder.'),
			'quotation_number'=>array('placeholder'=>'#QUOTATIONNUMBER#','guideline'=>'Quotation Number can display with this placeholder.'),
			'quotation_status'=>array('placeholder'=>'#QUOTATIONSTATUS#','guideline'=>'Quotation status can display with this placeholder.'),
		),
		'BusinessConfigMaster' => array(
			'username'=>array('placeholder'=>'#USERNAME#','guideline'=>'Username can display with this placeholder.'),
			'business_owner_name'=>array('placeholder'=>'#BUSINESSOWNERNAME#','guideline'=>'Business Owner Name can display with this placeholder.'),
			'business_company_name'=>array('placeholder'=>'#BUSINESSCOMPANYNAME#','guideline'=>'Business Company Name can display with this placeholder.'),
		),
		'Transaction' => array(
			'username'=>array('placeholder'=>'#USERNAME#','guideline'=>'Username can display with this placeholder.'),
			'transaction_type'=>array('placeholder'=>'#TRANSACTIONTYPE#','guideline'=>'Transaction Type can display with this placeholder.'),
			'transaction_number'=>array('placeholder'=>'#TRANSACTIONNUMBER#','guideline'=>'Transaction Number can display with this placeholder.'),
			'amount'=>array('placeholder'=>'#AMOUNT#','guideline'=>'Transaction Amount can display with this placeholder.'),
			'sender_party'=>array('placeholder'=>'#SENDERPARTY#','guideline'=>'Transaction sender can display with this placeholder.'),
			'reciever_party'=>array('placeholder'=>'#RECIEVERPARTY#','guideline'=>'Transaction Reciever can display with this placeholder.'),
			'description'=>array('placeholder'=>'#DESCRIPTION#','guideline'=>'Transaction Description can display with this placeholder.'),
		),
		'Project' => array(
			'username'=>array('placeholder'=>'#USERNAME#','guideline'=>'Username can display with this placeholder.'),
			'title'=>array('placeholder'=>'#PROJECTTITLE#','guideline'=>'Project Title can display with this placeholder.'),
			'description'=>array('placeholder'=>'#DESCRIPTION#','guideline'=>'Description can display with this placeholder.'),
			'client_name'=>array('placeholder'=>'#CLIENTNAME#','guideline'=>'Project Client Name can display with this placeholder.'),
			'capacity'=>array('placeholder'=>'#CAPACITY#','guideline'=>'Project Capacity can display with this placeholder.'),
			'project_type'=>array('placeholder'=>'#PROJECTTYPE#','guideline'=>'Project Type can display with this placeholder.'),
			'status'=>array('placeholder'=>'#STATUS#','guideline'=>'Project Status can display with this placeholder.'),
		),
		'Business' => array(
			'username'=>array('placeholder'=>'#USERNAME#','guideline'=>'Username can display with this placeholder.'),
			'owner_name'=>array('placeholder'=>'#BUSINESSOWNERNAME#','guideline'=>'Business Owner Name can display with this placeholder.'),
			'company_name'=>array('placeholder'=>'#COMPANYNAME#','guideline'=>'Company Name can display with this placeholder.'),
			'about'=>array('placeholder'=>'#ABOUT#','guideline'=>'Business About can display with this placeholder.'),
			'phone'=>array('placeholder'=>'#PHONE#','guideline'=>'Business Phone Number can display with this placeholder.'),
		),
		'BankAccount' => array(
			'username'=>array('placeholder'=>'#USERNAME#','guideline'=>'Username can display with this placeholder.'),
			'business_name'=>array('placeholder'=>'#BUSINESSNAME#','guideline'=>'Account Business Name can display with this placeholder.'),
			'contact_name'=>array('placeholder'=>'#CONTACTNAME#','guideline'=>'Bank Account Contact Name can display with this placeholder.'),
			'account_holder'=>array('placeholder'=>'#ACCOUNTHOLDER#','guideline'=>'Bank Account Holder can display with this placeholder.'),
			'account_number'=>array('placeholder'=>'#ACCOUNTNUMBER#','guideline'=>'Bank Account Number can display with this placeholder.'),
			'bank_name'=>array('placeholder'=>'#BANKNAME#','guideline'=>'Bank Account Bank Name can display with this placeholder.'),
		),
		'Address' => array(
			'username'=>array('placeholder'=>'#USERNAME#','guideline'=>'Username can display with this placeholder.'),
			'address_title'=>array('placeholder'=>'#ADDRESSTITLE#','guideline'=>'Address Title can display with this placeholder.'),
			'address'=>array('placeholder'=>'#ADDRESS#','guideline'=>'Address can display with this placeholder.'),
			'business_name'=>array('placeholder'=>'#BUSINESSNAME#','guideline'=>'Address Business Name can display with this placeholder.'),
			'contact_name'=>array('placeholder'=>'#CONTACTNAME#','guideline'=>'Address Contact Name can display with this placeholder.'),
		)
    ),

	/*
	|--------------------------------------------------------------------------
	| Super Admin Id
	|--------------------------------------------------------------------------
	|
	| These configuration options determine superadmin user id.
	|
	*/
	'superadmin' => '1',

	/* Admin theme layouts start */
	'dezThemeSet0' => array( /* Default Theme */
		'typography' => "roboto",
		'version' => "light",
		'layout' => "vertical",
		'headerBg' => "color_1",
		'primary' => "color_2",
		'navheaderBg' => "color_1",
		'sidebarBg' => "color_1",
		'sidebarStyle' => "full",
		'sidebarPosition' => "fixed",
		'headerPosition' => "fixed",
		'containerLayout' => "full",
		'direction' => 'ltr'
	),

	'dezThemeSet1' => array(
		'typography' => "poppins",
		'version' => "light",
		'layout' => "vertical",
		'primary' => "color_15",
		'headerBg' => "color_1",
		'navheaderBg' => "color_13",
		'sidebarBg' => "color_13",
		'sidebarStyle' => "full",
		'sidebarPosition' => "fixed",
		'headerPosition' => "fixed",
		'containerLayout' => "full",
		'direction' => 'ltr'
	),

	'dezThemeSet2' => array(
		'typography' => "poppins",
		'version' => "light",
		'layout' => "vertical",
		'primary' => "color_7",
		'headerBg' => "color_1",
		'navheaderBg' => "color_7",
		'sidebarBg' => "color_1",
		'sidebarStyle' => "modern",
		'sidebarPosition' => "static",
		'headerPosition' => "fixed",
		'containerLayout' => "full",
		'direction' => 'ltr'
	),


	'dezThemeSet3' => array(
		'typography' => "poppins",
		'version' => "light",
		'layout' => "horizontal",
		'primary' => "color_3",
		'headerBg' => "color_1",
		'navheaderBg' => "color_1",
		'sidebarBg' => "color_3",
		'sidebarStyle' => "full",
		'sidebarPosition' => "fixed",
		'headerPosition' => "fixed",
		'containerLayout' => "full",
		'direction' => 'ltr'
	),

	'dezThemeSet4' => array(
		'typography' => "poppins",
		'version' => "light",
		'layout' => "vertical",
		'primary' => "color_9",
		'headerBg' => "color_9",
		'navheaderBg' => "color_9",
		'sidebarBg' => "color_1",
		'sidebarStyle' => "compact",
		'sidebarPosition' => "fixed",
		'headerPosition' => "fixed",
		'containerLayout' => "full",
		'direction' => 'ltr'
	),

	'dezThemeSet5' => array(
		'typography' => "poppins",
		'version' => "light",
		'layout' => "vertical",
		'primary' => "color_7",
		'headerBg' => "color_1",
		'navheaderBg' => "color_7",
		'sidebarBg' => "color_7",
		'sidebarStyle' => "icon-hover",
		'sidebarPosition' => "fixed",
		'headerPosition' => "fixed",
		'containerLayout' => "full",
		'direction' => 'ltr'
	),

	'dezThemeSet6' => array(
		'typography' => "poppins",
		'version' => "light",
		'layout' => "vertical",
		'primary' => "color_3",
		'headerBg' => "color_3",
		'navheaderBg' => "color_1",
		'sidebarBg' => "color_1",
		'sidebarStyle' => "mini",
		'sidebarPosition' => "fixed",
		'headerPosition' => "fixed",
		'containerLayout' => "full",
		'direction' => 'ltr'
	),

	'dezThemeSet7' => array(
		'typography' => "poppins",
		'version' => "light",
		'layout' => "vertical",
		'primary' => "color_2",
		'headerBg' => "color_1",
		'navheaderBg' => "color_2",
		'sidebarBg' => "color_2",
		'sidebarStyle' => "mini",
		'sidebarPosition' => "fixed",
		'headerPosition' => "fixed",
		'containerLayout' => "full",
		'direction' => 'ltr'
	),

	'dezThemeSet8' => array(
		'typography' => "poppins",
		'version' => "light",
		'layout' => "vertical",
		'primary' => "color_2",
		'headerBg' => "color_14",
		'navheaderBg' => "color_14",
		'sidebarBg' => "color_2",
		'sidebarStyle' => "full",
		'sidebarPosition' => "fixed",
		'headerPosition' => "fixed",
		'containerLayout' => "full",
		'direction' => 'ltr'
	),
	/* Admin theme layouts end */

	'cf_settings' => array(
        'Admin' => array(
            'roles' => 'Role',
            'users' => 'User',
        ),
        'Blogs' => array(
			'blogs'	=> 'Blogs',
			'blog_categories'	=> 'Blog Categories',
		),
        'Pages' => array(
			'pages'	=> 'Pages',
		),
        'Leads' => array(
			'leads'	=> 'Leads',
		),
		
    ),

	'custom_field_input_types' => array(
		'text' => 'Text',
		'textarea' => 'Textarea',
		'radio' => 'Radio',
		'checkbox' => 'Checkbox',
		'checkbox_multi' => 'Checkbox Multi',
		'select' => 'Select',
		'multi_select' => 'Multi Select',
		'color' => 'Color',
		'date' => 'Date',
		'media' => 'Media',
		'gallery' => 'Gallery',
		'password' => 'Password',
		'editor' => 'Editor',
		'group' => 'Group',
		'switch' => 'Switch',
    ),



	'themes_api' => 'https://w3cms.in/api/api/themes',
    'language_api' => 'https://w3cms.in/api/get-language-file/',
    'client_information_api' => 'https://w3cms.in/api/client-information-api/',
];
