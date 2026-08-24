<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Ticket;
use Auth;
use Mail;

class Notification extends Model
{
	use HasFactory;

	protected $table = 'notifications';
	protected $fillable = [
		'notification_config_id',
		'notification_types',
		'object_id',
		'sender_id',
		'receiver_id',
		'read',
	];

	public function notification_config()
	{
		return $this->belongsTo(NotificationConfig::class, 'notification_config_id', 'id');
	}

	public function sender()
	{
		return $this->belongsTo(User::class, 'sender_id', 'id');
	}

	public function receiver()
	{
		return $this->belongsTo(User::class, 'reciever_id', 'id');
	}

	public function blog()
	{
		return $this->belongsTo(Blog::class, 'object_id', 'id');
	}

	public function page()
	{
		return $this->belongsTo(Page::class, 'object_id', 'id');
	}

	public function notification_entry($code='', $table_id='', $sender_id='', $receiver_id='')
	{
		$notificationConfig = NotificationConfig::select('id', 'notification_types')->with('notification_templates')->where('code', '=', $code)->where('status', '=', 1)->first();
		if(!empty($notificationConfig))
		{
			$web_notification = array(
							'notification_config_id'    => $notificationConfig->id,
							'notification_types'        => $notificationConfig->notification_types,
							'object_id'                 => $table_id,
							'sender_id'                 => $sender_id,
							'receiver_id'               => $receiver_id,
							);
			$web_notification = Notification::create($web_notification);
			
			$notification_id = $web_notification->id;
			if(\Str::contains($notificationConfig->notification_types, '1'))
			{
				$this->email_notification($notificationConfig->id, 1, $notification_id);
			}
		}
	}

	public function email_notification($notification_config_id='', $notification_type_id='', $notification_id='')
	{
		$email_template     = NotificationTemplate::with('notification_config')->where('notification_config_id', '=', $notification_config_id)
								->where('notification_type_id', '=', $notification_type_id)->first();
		$tableModel         = optional($email_template->notification_config)->table_model;
		
		$notification       = Notification::firstWhere('id', $notification_id);
		$user               = User::find($notification->receiver_id);
		$currentUser		= auth()->user();

		$placeholder_arr = array();
		$assign_users_emails = array();

		if($tableModel == 'Ticket')
		{
			$placeholderData = $this->ticket_notification_settings($tableModel, $user);
			$ticketObj                  = new Ticket();
			$assign_users_emails        = $ticketObj->assign_users(optional($ticket)->id, 'email');
			$assign_users_emails        = array_unique($assign_users_emails);
		}
		elseif($tableModel == 'ACL')
		{
			$placeholderData = $this->acl_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'User')
		{
			$placeholderData = $this->user_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'Role')
		{
			$placeholderData = $this->role_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'Comment')
		{
			$placeholderData = $this->comment_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'Configuration')
		{
			$placeholderData = $this->configuration_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'Blog')
		{
			$placeholderData = $this->blog_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'BlogCategory')
		{
			$placeholderData = $this->blog_category_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'BlogTag')
		{
			$placeholderData = $this->blog_tag_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'Page')
		{
			$placeholderData = $this->page_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'Contact')
		{
			$placeholderData = $this->contact_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'Lead')
		{
			$placeholderData = $this->lead_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'Channel')
		{
			$placeholderData = $this->channel_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'Source')
		{
			$placeholderData = $this->source_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'ClientGroup')
		{
			$placeholderData = $this->clientgroup_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'Campaign')
		{
			$placeholderData = $this->campaign_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'Invoice')
		{
			$placeholderData = $this->invoice_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'QuotationItem')
		{
			$placeholderData = $this->quotation_item_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'MaterialCompany')
		{
			$placeholderData = $this->material_company_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'MaterialCategory')
		{
			$placeholderData = $this->material_category_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'Material')
		{
			$placeholderData = $this->material_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'Quotation')
		{
			$placeholderData = $this->quotation_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'BusinessConfigMaster')
		{
			$placeholderData = $this->business_config_master_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'Transaction')
		{
			$placeholderData = $this->transaction_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'Project')
		{
			$placeholderData = $this->project_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'Business')
		{
			$placeholderData = $this->business_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'BankAccount')
		{
			$placeholderData = $this->bank_account_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'Address')
		{
			$placeholderData = $this->address_notification_settings($notification, $currentUser);
		}

		$to_email                   = $user->email;
		$to_name                    = $user->full_name;
		$from_email                 = optional($currentUser)->email;
		$from_name                  = optional($currentUser)->full_name;
		$placeholder_arr            = $this->getPlaceholders('', $tableModel, $placeholderData);
		$subject                    = str_replace(array_keys($placeholder_arr), array_values($placeholder_arr), $email_template->subject);
		$message                    = str_replace(array_keys($placeholder_arr), array_values($placeholder_arr), $email_template->content);
		$view_data['description']   = $message;
		

		if (env('MAIL_USERNAME') && env('MAIL_PASSWORD') && env('MAIL_HOST')) {
			Mail::send('emails.notification_email', $view_data, function($mail) use($to_email, $to_name, $assign_users_emails, $subject, $from_email, $from_name) {
				$mail->getHeaders()->addTextHeader(
					'MIME-Version', '1.0',
					'Content-type', 'text/html;charset=UTF-8',
				);
				if ($from_email && $from_name) {
					$mail->from($from_email, $from_name);
				}
				$mail->to($to_email, $to_name)->cc($assign_users_emails)->subject($subject);
			});
		}
	}

	private function lead_notification_settings($notificationObj, $userObj)
	{
		$lead = \Modules\SolarMitra\App\Models\Lead::withTrashed()->where('id', '=', $notificationObj->object_id)->first();
		
		$placeholderData    =   ['Lead' =>
									[
										'username' => optional($userObj)->full_name,
										'lead_name' => optional($lead)->first_name . ' ' .optional($lead)->last_name,
										'lead_detail' => optional($lead)->first_name . ' - ' .optional($lead)->last_name. ' - ' .optional($lead)->email. ' - ' .optional($lead)->phone,
										'email' => optional($lead)->email,
										'phone' => optional($lead)->phone,
									]
								];
		
		return $placeholderData;
	}

	private function channel_notification_settings($notificationObj, $userObj)
	{
		$channel = \Modules\SolarMitra\App\Models\Channel::where('id', '=', $notificationObj->object_id)->first();
		
		$placeholderData    =   ['Channel' =>
									[
										'username' => optional($userObj)->full_name,
										'title' => optional($channel)->title,
										'description' => optional($channel)->description,
									]
								];
		
		return $placeholderData;
	}

	private function source_notification_settings($notificationObj, $userObj)
	{
		$source = \Modules\SolarMitra\App\Models\Source::where('id', '=', $notificationObj->object_id)->first();
		
		$placeholderData    =   ['Source' =>
									[
										'username' => optional($userObj)->full_name,
										'name' => optional($source)->name,
										'type' => config('solar_mitra.source_types.'.optional($source)->type),
										'channel' => optional(optional($source)->channel)->title,
									]
								];
		return $placeholderData;
	}

	private function clientgroup_notification_settings($notificationObj, $userObj)
	{
		$clientgroup = \Modules\SolarMitra\App\Models\ClientGroup::where('id', '=', $notificationObj->object_id)->first();
		
		$placeholderData    =   ['ClientGroup' =>
									[
										'username' => optional($userObj)->full_name,
										'title' => optional($clientgroup)->title,
									]
								];
		return $placeholderData;
	}

	private function campaign_notification_settings($notificationObj, $userObj)
	{
		$campaign = \Modules\SolarMitra\App\Models\Campaign::where('id', '=', $notificationObj->object_id)->first();
		
		$placeholderData    =   ['Campaign' =>
									[
										'username' => optional($userObj)->full_name,
										'purpose' => optional($campaign)->purpose,
										'channel' => optional(optional($campaign)->channel)->title,
										'source' => optional(optional($campaign)->source)->name,
									]
								];
		return $placeholderData;
	}

	private function invoice_notification_settings($notificationObj, $userObj)
	{
		$invoice = \Modules\SolarMitra\App\Models\Invoice::where('id', '=', $notificationObj->object_id)->first();
		
		$placeholderData    =   ['Invoice' =>
									[
										'username' => optional($userObj)->full_name,
										'title' => optional($invoice)->title,
										'client_name' => optional(optional($invoice)->client)->name,
										'invoice_number' => optional($invoice)->invoice_number,
										'total_amount' => optional($invoice)->total_amount,
										'status' => optional($invoice)->status == 1 ? 'Unpaid' : 'Paid' ,
									]
								];
		return $placeholderData;
	}

	private function quotation_item_notification_settings($notificationObj, $userObj)
	{
		$quotationitem = \Modules\SolarMitra\App\Models\QuotationItem::where('id', '=', $notificationObj->object_id)->first();
		
		$placeholderData    =   ['QuotationItem' =>
									[
										'username' => optional($userObj)->full_name,
										'item_title' => optional($quotationitem)->item_title,
										'quotation_title' => optional(optional($quotationitem)->quotation)->title,
										'rates_per_units' => optional($quotationitem)->rates_per_units,
										'amount' => optional($quotationitem)->amount ,
									]
								];
		return $placeholderData;
	}

	private function material_company_notification_settings($notificationObj, $userObj)
	{
		$materialcompany = \Modules\SolarMitra\App\Models\MaterialCompany::where('id', '=', $notificationObj->object_id)->first();
		
		$placeholderData    =   ['MaterialCompany' =>
									[
										'username' => optional($userObj)->full_name,
										'title' => optional($materialcompany)->title,
										'description' => optional($materialcompany)->description ,
									]
								];
		return $placeholderData;
	}

	private function material_category_notification_settings($notificationObj, $userObj)
	{
		$materialcategory = \Modules\SolarMitra\App\Models\MaterialCategory::where('id', '=', $notificationObj->object_id)->first();
		
		$placeholderData    =   ['MaterialCategory' =>
									[
										'username' => optional($userObj)->full_name,
										'title' => optional($materialcategory)->title,
										'description' => optional($materialcategory)->description ,
									]
								];
		return $placeholderData;
	}

	private function material_notification_settings($notificationObj, $userObj)
	{
		$material = \Modules\SolarMitra\App\Models\MaterialLibrary::where('id', '=', $notificationObj->object_id)->first();
		
		$placeholderData    =   ['Material' =>
									[
										'username' => optional($userObj)->full_name,
										'title' => optional($material)->title,
										'description' => optional($material)->description ,
										'material_company' => optional(optional($material)->material_company)->title,
										'material_category' => optional(optional($material)->material_category)->title,
									]
								];
		return $placeholderData;
	}

	private function quotation_notification_settings($notificationObj, $userObj)
	{
		$quotation = \Modules\SolarMitra\App\Models\Quotation::where('id', '=', $notificationObj->object_id)->first();
		
		$placeholderData    =   ['Quotation' =>
									[
										'username' => optional($userObj)->full_name,
										'title' => optional($quotation)->title,
										'description' => optional($quotation)->description ,
										'client_name' => optional(optional($quotation)->client)->name ,
										'quotation_number' => optional($quotation)->quotation_number ,
										'quotation_status' => optional(optional($quotation)->status)->title ,
									]
								];
		return $placeholderData;
	}

	private function business_config_master_notification_settings($notificationObj, $userObj)
	{
		$business = \Modules\SolarMitra\App\Models\Business::where('id', '=', $notificationObj->object_id)->first();
		
		$placeholderData    =   ['BusinessConfigMaster' =>
									[
										'username' => optional($userObj)->full_name,
										'business_owner_name' => optional(optional($business)->user)->full_name,
										'business_company_name' => optional($business)->company_name,
									]
								];
		return $placeholderData;
	}

	private function contact_notification_settings($notificationObj, $userObj)
	{
		$contact_types = [];

		if (\Module::collections()->has('SolarMitra')) {
			$contact = \Modules\SolarMitra\App\Models\Contact::where('id', '=', $notificationObj->object_id)->first();
			$contact_types = \Modules\SolarMitra\Helper\SolarMitraHelper::getContactTypes($notificationObj->object_id);
		}else{
			$contact = Contact::where('id', '=', $notificationObj->object_id)->first();
		}

		$placeholderData    =   ['Contact' =>
									[
										'username' => optional($userObj)->full_name,
										'first_name' => optional($contact)->first_name,
										'last_name' => optional($contact)->last_name,
										'email' => optional($contact)->email,
										'phone_number' => optional($contact)->phone_number,
										'message' => optional($contact)->message,
										'contact_name' => optional($contact)->name,
										'contact_detail' => optional($contact)->name . ' - ' . optional($contact)->email . ' - ' . optional($contact)->phone_number,
										'phone' => optional($contact)->phone_number,
										'type' => implode(', ', $contact_types),
									]
								];
		return $placeholderData;
	}

	private function transaction_notification_settings($notificationObj, $userObj)
	{
		$transaction = \Modules\SolarMitra\App\Models\Transaction::where('id', '=', $notificationObj->object_id)->first();
		
		$placeholderData    =   ['Transaction' =>
									[
										'username' => optional($userObj)->full_name,
										'transaction_type' => optional(optional($transaction)->transaction_type)->title,
										'transaction_number' => optional($transaction)->transaction_number ,
										'amount' => optional($transaction)->amount ,
										'sender_party' => optional(optional($transaction)->sender)->name,
										'reciever_party' => optional(optional($transaction)->receiver)->name,
										'description' => optional($transaction)->description ,
									]
								];

		return $placeholderData;
	}

	private function project_notification_settings($notificationObj, $userObj)
	{
		$project = \Modules\SolarMitra\App\Models\Project::where('id', '=', $notificationObj->object_id)->first();
		
		$placeholderData    =   ['Project' =>
									[
										'username' => optional($userObj)->full_name,
										'title' => optional($project)->title,
										'description' => optional($project)->description ,
										'client_name' => optional(optional($project)->client)->name ,
										'capacity' => optional($project)->capacity,
										'project_type' => optional($project)->project_type,
										'status' => config('solar_mitra.projects_status.'.optional($project)->status) ,
									]
								];

		return $placeholderData;
	}

	private function business_notification_settings($notificationObj, $userObj)
	{
		$business = \Modules\SolarMitra\App\Models\Business::where('id', '=', $notificationObj->object_id)->first();
		
		$placeholderData    =   ['Business' =>
									[
										'username' => optional($userObj)->full_name,
										'owner_name' => optional(optional($business)->user)->full_name,
										'company_name' => optional($business)->company_name,
										'about' => optional($business)->about ,
										'phone' => optional($business)->phone,
									]
								];

		return $placeholderData;
	}

	private function bank_account_notification_settings($notificationObj, $userObj)
	{
		$bankaccount = \Modules\SolarMitra\App\Models\BankAccount::where('id', '=', $notificationObj->object_id)->first();
		
		$placeholderData    =   ['BankAccount' =>
									[
										'username' => optional($userObj)->full_name,
										'business_name' => optional(optional($bankaccount)->business)->company_name,
										'contact_name' => optional(optional($bankaccount)->contact)->name,
										'account_holder' => optional($bankaccount)->account_holder ,
										'account_number' => optional($bankaccount)->account_number,
										'bank_name' => optional($bankaccount)->bank_name,
									]
								];

		return $placeholderData;
	}

	private function address_notification_settings($notificationObj, $userObj)
	{
		$address = \Modules\SolarMitra\App\Models\Address::where('id', '=', $notificationObj->object_id)->first();
		
		$placeholderData    =   ['Address' =>
									[
										'username' => optional($userObj)->full_name,
										'address_title' => optional($address)->address_title ,
										'address' => optional($address)->address ,
										'business_name' => optional(optional($address)->business)->company_name,
										'contact_name' => optional(optional($address)->contact)->name,
									]
								];

		return $placeholderData;
	}
	
	private function ticket_notification_settings($notificationObj, $userObj) {
		
		$ticket             = Ticket::with('ticket_attachments', 'category')->where('id', '=', $notificationObj->object_id)->first();
		$ticket_attachments = optional($ticket)->ticket_attachments;
		$ticket_category    = optional($ticket)->category;
		$ticketAttachments  = '';
		if(!empty($ticket_attachments))
		{
			foreach($ticket_attachments as $attachment)
			{
				$ticketAttachments .= '<a href="'.asset('/storage/ticket-images/'.$attachment->attachment).'">'.$attachment->attachment.'</a><br>';
			}
		}
		$ticket_id = optional($ticket)->id;
		$parentTicketId = optional($ticket)->id;
		if(optional($ticket)->parent_id)
		{
			$parentTicketId = optional($ticket)->parent_id;
		}
		$placeholderData    =   ['Support' =>
									[
										'sender_id' => $notificationObj->sender_id,
										'receiver_id' => $notificationObj->receiver_id,
										'ticket_attachment' => $ticketAttachments,
										'ticket_id' => $ticket_id,
										'category_name' => optional($ticket_category)->name,
										'ticket_comment' => optional($ticket)->description,
										'ticket_link' => $parentTicketId ? route('ticket.customer_ticket_detail', $parentTicketId) : '#',
									]
								];
		
		return $placeholderData;
	}

	private function acl_notification_settings($notificationObj, $userObj)
	{
	}

	private function user_notification_settings($notificationObj, $userObj)
	{
		$user = User::where('id', '=', $notificationObj->object_id)->first();
		$roles = $user ? $user->getRoleNames()->implode(',') : '';
		$profile = !empty($user->profile) ? asset('storage/user-images/'.$user->profile) : config('constants.user_default_img');
		$placeholderData    =   ['User' =>
									[
										'username' => optional($userObj)->full_name,
										'name' => optional($user)->full_name,
										'email' => optional($user)->email,
										'firstname' => optional($user)->first_name,
										'lastname' => optional($user)->last_name,
										'password' => optional($user)->password,
										'role' => $roles,
										'profile' => '<img src="'.$profile.'" width="100px" height="100px" alt="'.optional($user)->full_name.'">',
									]
								];
		
		return $placeholderData;
	}

	private function role_notification_settings($notificationObj, $userObj)
	{
		$role = Role::select('name')->where('id', '=', $notificationObj->object_id)->first();
		$placeholderData    =   ['Role' =>
									[
										'username' => optional($userObj)->full_name,
										'name' => optional($role)->name,
									]
								];
		
		return $placeholderData;
	}

	private function comment_notification_settings($notificationObj, $userObj)
	{
		$comment = Comment::select('comment','object_id','commenter')->where('id', '=', $notificationObj->object_id)->where('object_type', '=', 1)->with('blog')->first();
		
		$placeholderData    =   ['Comment' =>
									[
										'username' => optional($comment)->commenter,
										'comment' => optional($comment)->comment,
										'title' => optional(@$comment->blog)->title,
									]
								];
		
		return $placeholderData;
	}

	private function configuration_notification_settings($notificationObj, $userObj)
	{
		$config = Configuration::select('title', 'name')->where('id', '=', $notificationObj->object_id)->first();
		$placeholderData    =   ['Configuration' =>
									[
										'username' => optional($userObj)->full_name,
										'title' => optional($blog)->title,
										'content' => optional($blog)->content,
									]
								];
		
		return $placeholderData;
	}

	private function blog_notification_settings($notificationObj, $userObj)
	{
		$blog = Blog::select('title', 'content')->where('id', '=', $notificationObj->object_id)->first();
		$placeholderData    =   ['Blog' =>
									[
										'username' => optional($userObj)->full_name,
										'title' => optional($blog)->title,
										'content' => optional($blog)->content,
									]
								];
		
		return $placeholderData;
	}

	private function blog_category_notification_settings($notificationObj, $userObj)
	{
		$blogCategory = BlogCategory::select('title', 'description')->where('id', '=', $notificationObj->object_id)->first();
		$placeholderData    =   ['BlogCategory' =>
									[
										'username' => optional($userObj)->full_name,
										'title' => optional($blogCategory)->title,
										'content' => optional($blogCategory)->description,
									]
								];
		
		return $placeholderData;
	}

	private function blog_tag_notification_settings($notificationObj, $userObj)
	{
		$blogTag = BlogTag::select('title')->where('id', '=', $notificationObj->object_id)->first();
		$placeholderData    =   ['BlogTag' =>
									[
										'username' => optional($userObj)->full_name,
										'title' => optional($blogTag)->title,
									]
								];
		
		return $placeholderData;
	}

	private function page_notification_settings($notificationObj, $userObj)
	{
		$page = Page::select('title', 'content')->where('id', '=', $notificationObj->object_id)->first();
		$placeholderData    =   ['Page' =>
									[
										'username' => optional($userObj)->full_name,
										'title' => optional($page)->title,
										'content' => optional($page)->content,
									]
								];
		
		return $placeholderData;
	}
	
	public function sms_notification()
	{
	}

	public function show_notification($user_id, $code=array())
	{
		$notification_configs       = NotificationConfig::whereIn('code', $code)->pluck('code', 'id')->toArray();
		$notification_config_ids    = array_keys($notification_configs);
		$notification_templates     = NotificationTemplate::whereIn('notification_config_id', $notification_config_ids)->where('notification_type_id', '=', 2)->pluck('content', 'notification_config_id');
		$userObj                    = new User();
		$ticket_ids                 = $userObj->assign_tickets($user_id);
		$notifications              = Notification::whereIn('notification_config_id', $notification_config_ids)
							->whereIn('object_id', $ticket_ids)
									->where('read', '=', '0')
									->orderBy('created_at', 'desc')
									->take(15)
									->get();
		$NotificationsArr = array();
		if(!$notifications->isEmpty())
		{
			foreach ($notifications as $key => $notification) {
								$sender_user        = $this->get_user($notification->sender_id);
								$receiver_user      = $this->get_user($notification->receiver_id);
				$placeholderData    =   array('Support' =>
											array(
												'sender_id' => $this->display_you($notification->sender_id, $sender_user->full_name),
												'receiver_id' => $this->display_you($notification->receiver_id, $receiver_user->full_name, true),
												'ticket_id' => $notification->object_id,
											)
										);
				$placeholder_arr    = $this->getPlaceholders('', 'Support', $placeholderData);
				
				$content            = str_replace(array_keys($placeholder_arr), array_values($placeholder_arr), $notification_templates[$notification->notification_config_id]);
				$NotificationsArr[] = array(
										'sender_name'   => $this->display_you($notification->sender_id, $sender_user->full_name),
										'receiver_name' => $this->display_you($notification->receiver_id, $receiver_user->full_name, true),
										'sender_img'    => $sender_user->image,
										'updated_at'    => \Carbon\Carbon::parse($notification->updated_at)->diffForHumans(),
										'message'       => $content,
										'comment'       => $this->get_ticket_comment($notification->object_id),
										'object_id'     => $notification->object_id,
																'code'          => $notification_configs[$notification->notification_config_id],
																'read'          => $notification->read
									);
			}
		}
		return $NotificationsArr;
	}

	public function get_user($id='', $type='')
	{
		$user = User::firstWhere('id', $id);
		if($user && $type == 'name')
		{
			return $user->full_name;
		}
		else if($user && $type == 'email')
		{
			return $user->email;
		}
		else if($user && $type == 'image')
		{
			return $user->image;
		}
		else
		{
			return $user;
		}
	}
	public function getPlaceholders($user_id = NULL, $model='', $data = array())
	{
		$config = config('constants.Placeholder');
		$result = array();
		if($model == 'User')
		{
			$result[$config['User']['username']['placeholder']] = (!empty($data['User']['username'])) ? $data['User']['username'] : '';
			$result[$config['User']['name']['placeholder']] = (!empty($data['User']['name'])) ? $data['User']['name'] : '';
			$result[$config['User']['email']['placeholder']] = (!empty($data['User']['email'])) ? $data['User']['email'] : '';
			$result[$config['User']['firstname']['placeholder']] = (!empty($data['User']['firstname'])) ? $data['User']['firstname'] : '';
			$result[$config['User']['lastname']['placeholder']] = (!empty($data['User']['lastname'])) ? $data['User']['lastname'] : '';
			$result[$config['User']['password']['placeholder']] = (!empty($data['User']['password'])) ? $data['User']['password'] : '';
			$result[$config['User']['role']['placeholder']] = (!empty($data['User']['role'])) ? $data['User']['role'] : '';
			$result[$config['User']['profile']['placeholder']] = (!empty($data['User']['profile'])) ? $data['User']['profile'] : '';
		}

		foreach($config['Config'] as $key => $value)
		{
		
			$result[$value['placeholder']] = config($key);
		}
		
		$result[$config['Generate']['site_logo']['placeholder']] = '<img  src="'.asset('storage/configuration-images/'.config('Site.logo')).'" />';
		$result[$config['Generate']['login_link']['placeholder']] = '<a href="'.route("login").'">Account login link</a>';
		$result[$config['Generate']['register_link']['placeholder']] = '<a href="javascript:void(0);">Account Registration link</a>';
		
		if($model == 'Contact')
		{
			$result[$config['Contact']['first_name']['placeholder']] = (!empty($data['Contact']['first_name'])) ? $data['Contact']['first_name'] : '';
			$result[$config['Contact']['last_name']['placeholder']] = (!empty($data['Contact']['last_name']))?$data['Contact']['last_name'] : '';
			$result[$config['Contact']['email']['placeholder']] = (!empty($data['Contact']['email']))?$data['Contact']['email'] : '';
			$result[$config['Contact']['phone_number']['placeholder']] = (!empty($data['Contact']['phone_number']))?$data['Contact']['phone_number'] : '';
			$result[$config['Contact']['message']['placeholder']] = (!empty($data['Contact']['message']))?$data['Contact']['message'] : '';
		}
		
		if($model == 'Subscribe')
		{
			$result[$config['Subscribe']['name']['placeholder']] = (!empty($data['Subscribe']['name'])) ? $data['Subscribe']['name'] : '';
		}
		
		if($model == 'Support' && !empty($config['Support']))
		{
			$sender_name            = is_int($data['Support']['sender_id']) ? $this->get_user($data['Support']['sender_id'], 'name') : $data['Support']['sender_id'];
			$receiver_name          = is_int($data['Support']['receiver_id']) ? $this->get_user($data['Support']['receiver_id'], 'name') : $data['Support']['receiver_id'];
			$result[$config['Support']['sender_name']['placeholder']] = $sender_name;
			$result[$config['Support']['receiver_name']['placeholder']] = $receiver_name;
			$result[$config['Support']['object_title']['placeholder']] = (!empty($data['Support']['object_title'])) ? $data['Support']['object_title'] : '';
			$result[$config['Support']['category_name']['placeholder']] = (!empty($data['Support']['category_name'])) ? $data['Support']['category_name'] : '';
			$result[$config['Support']['ticket_id']['placeholder']] = (!empty($data['Support']['ticket_id'])) ? $data['Support']['ticket_id'] : '';
			$result[$config['Support']['ticket_attachment']['placeholder']] = (!empty($data['Support']['ticket_attachment'])) ? $data['Support']['ticket_attachment'] : '';
			$result[$config['Support']['ticket_comment']['placeholder']] = (!empty($data['Support']['ticket_comment'])) ? $data['Support']['ticket_comment'] : '';
			$result[$config['Support']['ticket_link']['placeholder']] = (!empty($data['Support']['ticket_link'])) ? $data['Support']['ticket_link'] : '';
		}
		
		if($model == 'Blog' && !empty($config['Blog']))
		{
			$result[$config['Blog']['username']['placeholder']] = (!empty($data['Blog']['username'])) ? $data['Blog']['username'] : '';
			$result[$config['Blog']['title']['placeholder']] = (!empty($data['Blog']['title'])) ? $data['Blog']['title'] : '';
			$result[$config['Blog']['content']['placeholder']] = (!empty($data['Blog']['content'])) ? $data['Blog']['content'] : '';
			$result[$config['Blog']['taxonomy_title']['placeholder']] = (!empty($data['Blog']['title'])) ? $data['Blog']['title'] : '';
			$result[$config['Blog']['taxonomy_content']['placeholder']] = (!empty($data['Blog']['content'])) ? $data['Blog']['content'] : '';
			$result[$config['Blog']['post_type_title']['placeholder']] = (!empty($data['Blog']['title'])) ? $data['Blog']['title'] : '';
			$result[$config['Blog']['post_type_content']['placeholder']] = (!empty($data['Blog']['content'])) ? $data['Blog']['content'] : '';
		}
		
		if($model == 'BlogCategory' && !empty($config['BlogCategory']))
		{
			$result[$config['BlogCategory']['username']['placeholder']] = (!empty($data['BlogCategory']['username'])) ? $data['BlogCategory']['username'] : '';
			$result[$config['BlogCategory']['title']['placeholder']] = (!empty($data['BlogCategory']['title'])) ? $data['BlogCategory']['title'] : '';
			$result[$config['BlogCategory']['content']['placeholder']] = (!empty($data['BlogCategory']['content'])) ? $data['BlogCategory']['content'] : '';
		}
		
		if($model == 'BlogTag' && !empty($config['BlogTag']))
		{
			$result[$config['BlogTag']['username']['placeholder']] = (!empty($data['BlogTag']['username'])) ? $data['BlogTag']['username'] : '';
			$result[$config['BlogTag']['title']['placeholder']] = (!empty($data['BlogTag']['title'])) ? $data['BlogTag']['title'] : '';
		}
		
		if($model == 'Comment' && !empty($config['Comment']))
		{
			$result[$config['Comment']['username']['placeholder']] = (!empty($data['Comment']['username'])) ? $data['Comment']['username'] : '';
			$result[$config['Comment']['comment']['placeholder']] = (!empty($data['Comment']['comment'])) ? $data['Comment']['comment'] : '';
			$result[$config['Comment']['title']['placeholder']] = (!empty($data['Comment']['title'])) ? $data['Comment']['title'] : '';
		}
		
		if($model == 'Page' && !empty($config['Page']))
		{
			$result[$config['Page']['username']['placeholder']] = (!empty($data['Page']['username'])) ? $data['Page']['username'] : '';
			$result[$config['Page']['title']['placeholder']] = (!empty($data['Page']['title'])) ? $data['Page']['title'] : '';
			$result[$config['Page']['content']['placeholder']] = (!empty($data['Page']['content'])) ? $data['Page']['content'] : '';
		}
		
		if($model == 'Role' && !empty($config['Role']))
		{
			$result[$config['Role']['username']['placeholder']] = (!empty($data['Role']['username'])) ? $data['Role']['username'] : '';
			$result[$config['Role']['name']['placeholder']] = (!empty($data['Role']['name'])) ? $data['Role']['name'] : '';
		}
		
		if($model == 'Lead' && !empty($config['Lead']))
		{
			$result[$config['Lead']['username']['placeholder']] = (!empty($data['Lead']['username'])) ? $data['Lead']['username'] : '';
			$result[$config['Lead']['lead_name']['placeholder']] = (!empty($data['Lead']['lead_name'])) ? $data['Lead']['lead_name'] : '';
			$result[$config['Lead']['lead_detail']['placeholder']] = (!empty($data['Lead']['lead_detail'])) ? $data['Lead']['lead_detail'] : '';
			$result[$config['Lead']['email']['placeholder']] = (!empty($data['Lead']['email'])) ? $data['Lead']['email'] : '';
			$result[$config['Lead']['phone']['placeholder']] = (!empty($data['Lead']['phone'])) ? $data['Lead']['phone'] : '';
		}
		
		if($model == 'ClientGroup' && !empty($config['ClientGroup']))
		{
			$result[$config['ClientGroup']['username']['placeholder']] = (!empty($data['ClientGroup']['username'])) ? $data['ClientGroup']['username'] : '';
			$result[$config['ClientGroup']['title']['placeholder']] = (!empty($data['ClientGroup']['title'])) ? $data['ClientGroup']['title'] : '';
		}
		
		if($model == 'Source' && !empty($config['Source']))
		{
			$result[$config['Source']['username']['placeholder']] = (!empty($data['Source']['username'])) ? $data['Source']['username'] : '';
			$result[$config['Source']['name']['placeholder']] = (!empty($data['Source']['name'])) ? $data['Source']['name'] : '';
			$result[$config['Source']['type']['placeholder']] = (!empty($data['Source']['type'])) ? $data['Source']['type'] : '';
			$result[$config['Source']['channel']['placeholder']] = (!empty($data['Source']['channel'])) ? $data['Source']['channel'] : '';
		}
		
		if($model == 'Channel' && !empty($config['Channel']))
		{
			$result[$config['Channel']['username']['placeholder']] = (!empty($data['Channel']['username'])) ? $data['Channel']['username'] : '';
			$result[$config['Channel']['title']['placeholder']] = (!empty($data['Channel']['title'])) ? $data['Channel']['title'] : '';
			$result[$config['Channel']['description']['placeholder']] = (!empty($data['Channel']['description'])) ? $data['Channel']['description'] : '';
		}
		
		if($model == 'Campaign' && !empty($config['Campaign']))
		{
			$result[$config['Campaign']['username']['placeholder']] = (!empty($data['Campaign']['username'])) ? $data['Campaign']['username'] : '';
			$result[$config['Campaign']['purpose']['placeholder']] = (!empty($data['Campaign']['purpose'])) ? $data['Campaign']['purpose'] : '';
			$result[$config['Campaign']['channel']['placeholder']] = (!empty($data['Campaign']['channel'])) ? $data['Campaign']['channel'] : '';
			$result[$config['Campaign']['source']['placeholder']] = (!empty($data['Campaign']['source'])) ? $data['Campaign']['source'] : '';
		}
		
		if($model == 'Invoice' && !empty($config['Invoice']))
		{
			$result[$config['Invoice']['username']['placeholder']] = (!empty($data['Invoice']['username'])) ? $data['Invoice']['username'] : '';
			$result[$config['Invoice']['title']['placeholder']] = (!empty($data['Invoice']['title'])) ? $data['Invoice']['title'] : '';
			$result[$config['Invoice']['client_name']['placeholder']] = (!empty($data['Invoice']['client_name'])) ? $data['Invoice']['client_name'] : '';
			$result[$config['Invoice']['invoice_number']['placeholder']] = (!empty($data['Invoice']['invoice_number'])) ? $data['Invoice']['invoice_number'] : '';
			$result[$config['Invoice']['total_amount']['placeholder']] = (!empty($data['Invoice']['total_amount'])) ? $data['Invoice']['total_amount'] : '';
			$result[$config['Invoice']['status']['placeholder']] = (!empty($data['Invoice']['status'])) ? $data['Invoice']['status'] : '';
		}
		
		if($model == 'QuotationItem' && !empty($config['QuotationItem']))
		{
			$result[$config['QuotationItem']['username']['placeholder']] = (!empty($data['QuotationItem']['username'])) ? $data['QuotationItem']['username'] : '';
			$result[$config['QuotationItem']['item_title']['placeholder']] = (!empty($data['QuotationItem']['item_title'])) ? $data['QuotationItem']['item_title'] : '';
			$result[$config['QuotationItem']['quotation_title']['placeholder']] = (!empty($data['QuotationItem']['quotation_title'])) ? $data['QuotationItem']['quotation_title'] : '';
			$result[$config['QuotationItem']['rates_per_units']['placeholder']] = (!empty($data['QuotationItem']['rates_per_units'])) ? $data['QuotationItem']['rates_per_units'] : '';
			$result[$config['QuotationItem']['amount']['placeholder']] = (!empty($data['QuotationItem']['amount'])) ? $data['QuotationItem']['amount'] : '';
		}

		if($model == 'MaterialCompany' && !empty($config['MaterialCompany']))
		{
		    $result[$config['MaterialCompany']['username']['placeholder']] = (!empty($data['MaterialCompany']['username'])) ? $data['MaterialCompany']['username'] : '';
		    $result[$config['MaterialCompany']['title']['placeholder']] = (!empty($data['MaterialCompany']['title'])) ? $data['MaterialCompany']['title'] : '';
		    $result[$config['MaterialCompany']['description']['placeholder']] = (!empty($data['MaterialCompany']['description'])) ? $data['MaterialCompany']['description'] : '';
		}

		if($model == 'MaterialCategory' && !empty($config['MaterialCategory']))
		{
		    $result[$config['MaterialCategory']['username']['placeholder']] = (!empty($data['MaterialCategory']['username'])) ? $data['MaterialCategory']['username'] : '';
		    $result[$config['MaterialCategory']['title']['placeholder']] = (!empty($data['MaterialCategory']['title'])) ? $data['MaterialCategory']['title'] : '';
		    $result[$config['MaterialCategory']['description']['placeholder']] = (!empty($data['MaterialCategory']['description'])) ? $data['MaterialCategory']['description'] : '';
		}

		if($model == 'Material' && !empty($config['Material']))
		{
		    $result[$config['Material']['username']['placeholder']] = (!empty($data['Material']['username'])) ? $data['Material']['username'] : '';
		    $result[$config['Material']['title']['placeholder']] = (!empty($data['Material']['title'])) ? $data['Material']['title'] : '';
		    $result[$config['Material']['description']['placeholder']] = (!empty($data['Material']['description'])) ? $data['Material']['description'] : '';
		    $result[$config['Material']['material_company']['placeholder']] = (!empty($data['Material']['material_company'])) ? $data['Material']['material_company'] : '';
		    $result[$config['Material']['material_category']['placeholder']] = (!empty($data['Material']['material_category'])) ? $data['Material']['material_category'] : '';
		}

		if($model == 'Quotation' && !empty($config['Quotation']))
		{
		    $result[$config['Quotation']['username']['placeholder']] = (!empty($data['Quotation']['username'])) ? $data['Quotation']['username'] : '';
		    $result[$config['Quotation']['title']['placeholder']] = (!empty($data['Quotation']['title'])) ? $data['Quotation']['title'] : '';
		    $result[$config['Quotation']['description']['placeholder']] = (!empty($data['Quotation']['description'])) ? $data['Quotation']['description'] : '';
		    $result[$config['Quotation']['client_name']['placeholder']] = (!empty($data['Quotation']['client_name'])) ? $data['Quotation']['client_name'] : '';
		    $result[$config['Quotation']['quotation_number']['placeholder']] = (!empty($data['Quotation']['quotation_number'])) ? $data['Quotation']['quotation_number'] : '';
		    $result[$config['Quotation']['quotation_status']['placeholder']] = (!empty($data['Quotation']['quotation_status'])) ? $data['Quotation']['quotation_status'] : '';
		}

		if($model == 'BusinessConfigMaster' && !empty($config['BusinessConfigMaster']))
		{
		    $result[$config['BusinessConfigMaster']['username']['placeholder']] = (!empty($data['BusinessConfigMaster']['username'])) ? $data['BusinessConfigMaster']['username'] : '';
		    $result[$config['BusinessConfigMaster']['business_owner_name']['placeholder']] = (!empty($data['BusinessConfigMaster']['business_owner_name'])) ? $data['BusinessConfigMaster']['business_owner_name'] : '';
		    $result[$config['BusinessConfigMaster']['business_company_name']['placeholder']] = (!empty($data['BusinessConfigMaster']['business_company_name'])) ? $data['BusinessConfigMaster']['business_company_name'] : '';
		}

		if($model == 'Contact' && !empty($config['Contact']))
		{
		    $result[$config['Contact']['username']['placeholder']] = (!empty($data['Contact']['username'])) ? $data['Contact']['username'] : '';
		    $result[$config['Contact']['contact_name']['placeholder']] = (!empty($data['Contact']['contact_name'])) ? $data['Contact']['contact_name'] : '';
		    $result[$config['Contact']['contact_detail']['placeholder']] = (!empty($data['Contact']['contact_detail'])) ? $data['Contact']['contact_detail'] : '';
		    $result[$config['Contact']['email']['placeholder']] = (!empty($data['Contact']['email'])) ? $data['Contact']['email'] : '';
		    $result[$config['Contact']['phone']['placeholder']] = (!empty($data['Contact']['phone'])) ? $data['Contact']['phone'] : '';
		    $result[$config['Contact']['type']['placeholder']] = (!empty($data['Contact']['type'])) ? $data['Contact']['type'] : '';
		}

		if($model == 'Transaction' && !empty($config['Transaction']))
		{
		    $result[$config['Transaction']['username']['placeholder']] = (!empty($data['Transaction']['username'])) ? $data['Transaction']['username'] : '';
		    $result[$config['Transaction']['transaction_type']['placeholder']] = (!empty($data['Transaction']['transaction_type'])) ? $data['Transaction']['transaction_type'] : '';
		    $result[$config['Transaction']['transaction_number']['placeholder']] = (!empty($data['Transaction']['transaction_number'])) ? $data['Transaction']['transaction_number'] : '';
		    $result[$config['Transaction']['amount']['placeholder']] = (!empty($data['Transaction']['amount'])) ? $data['Transaction']['amount'] : '';
		    $result[$config['Transaction']['sender_party']['placeholder']] = (!empty($data['Transaction']['sender_party'])) ? $data['Transaction']['sender_party'] : '';
		    $result[$config['Transaction']['reciever_party']['placeholder']] = (!empty($data['Transaction']['reciever_party'])) ? $data['Transaction']['reciever_party'] : '';
		    $result[$config['Transaction']['description']['placeholder']] = (!empty($data['Transaction']['description'])) ? $data['Transaction']['description'] : '';
		}

		if($model == 'Project' && !empty($config['Project']))
		{
		    $result[$config['Project']['username']['placeholder']] = (!empty($data['Project']['username'])) ? $data['Project']['username'] : '';
		    $result[$config['Project']['title']['placeholder']] = (!empty($data['Project']['title'])) ? $data['Project']['title'] : '';
		    $result[$config['Project']['description']['placeholder']] = (!empty($data['Project']['description'])) ? $data['Project']['description'] : '';
		    $result[$config['Project']['client_name']['placeholder']] = (!empty($data['Project']['client_name'])) ? $data['Project']['client_name'] : '';
		    $result[$config['Project']['capacity']['placeholder']] = (!empty($data['Project']['capacity'])) ? $data['Project']['capacity'] : '';
		    $result[$config['Project']['project_type']['placeholder']] = (!empty($data['Project']['project_type'])) ? $data['Project']['project_type'] : '';
		    $result[$config['Project']['status']['placeholder']] = (!empty($data['Project']['status'])) ? $data['Project']['status'] : '';
		}

		if($model == 'Business' && !empty($config['Business']))
		{
		    $result[$config['Business']['username']['placeholder']] = (!empty($data['Business']['username'])) ? $data['Business']['username'] : '';
		    $result[$config['Business']['owner_name']['placeholder']] = (!empty($data['Business']['owner_name'])) ? $data['Business']['owner_name'] : '';
		    $result[$config['Business']['company_name']['placeholder']] = (!empty($data['Business']['company_name'])) ? $data['Business']['company_name'] : '';
		    $result[$config['Business']['about']['placeholder']] = (!empty($data['Business']['about'])) ? $data['Business']['about'] : '';
		    $result[$config['Business']['phone']['placeholder']] = (!empty($data['Business']['phone'])) ? $data['Business']['phone'] : '';
		}

		if($model == 'BankAccount' && !empty($config['BankAccount']))
		{
		    $result[$config['BankAccount']['username']['placeholder']] = (!empty($data['BankAccount']['username'])) ? $data['BankAccount']['username'] : '';
		    $result[$config['BankAccount']['business_name']['placeholder']] = (!empty($data['BankAccount']['business_name'])) ? $data['BankAccount']['business_name'] : '';
		    $result[$config['BankAccount']['contact_name']['placeholder']] = (!empty($data['BankAccount']['contact_name'])) ? $data['BankAccount']['contact_name'] : '';
		    $result[$config['BankAccount']['account_holder']['placeholder']] = (!empty($data['BankAccount']['account_holder'])) ? $data['BankAccount']['account_holder'] : '';
		    $result[$config['BankAccount']['account_number']['placeholder']] = (!empty($data['BankAccount']['account_number'])) ? $data['BankAccount']['account_number'] : '';
		    $result[$config['BankAccount']['bank_name']['placeholder']] = (!empty($data['BankAccount']['bank_name'])) ? $data['BankAccount']['bank_name'] : '';
		}

		if($model == 'Address' && !empty($config['Address']))
		{
		    $result[$config['Address']['username']['placeholder']] = (!empty($data['Address']['username'])) ? $data['Address']['username'] : '';
		    $result[$config['Address']['address_title']['placeholder']] = (!empty($data['Address']['address_title'])) ? $data['Address']['address_title'] : '';
		    $result[$config['Address']['address']['placeholder']] = (!empty($data['Address']['address'])) ? $data['Address']['address'] : '';
		    $result[$config['Address']['business_name']['placeholder']] = (!empty($data['Address']['business_name'])) ? $data['Address']['business_name'] : '';
		    $result[$config['Address']['contact_name']['placeholder']] = (!empty($data['Address']['contact_name'])) ? $data['Address']['contact_name'] : '';
		}

		return $result;
		
	}

	public function notification_delete($code='', $object_id='')
	{
		$notification_config = NotificationConfig::where('code', '=', $code)->first();
		if(!empty($notification_config))
		{
			return Notification::where('notification_config_id', '=', $notification_config->id)
							->where('object_id', '=', $object_id)
							->delete();
		}
	}

	public function get_ticket_comment($ticket_id='')
	{
		$ticket = Ticket::select('id', 'description')->firstWhere('id', $ticket_id);
		return !empty($ticket->description) ? $ticket->description : '';
	}

	public function display_you($user_id, $name, $noun_type=false)
	{
		if(Auth::id() == $user_id)
		{
			if($noun_type)
			{
				return 'Your';
			}
			return 'You';
		}
		return $name;
	}

	public function get_message($table_model, $notification_config_id, $sender_id, $receiver_id, $object_id,)
	{
		$notification_templates    = NotificationTemplate::where(['notification_config_id' => $notification_config_id, 'notification_type_id' => 1])->pluck('content', 'notification_config_id');
		
		$currentUser		= User::find($sender_id);

		$notification = collect([
		    'object_id' => $object_id
		])->toArray();

		$notification = (object) $notification;

		if($table_model == 'ACL')
		{
			$placeholderData = $this->acl_notification_settings($notification, $currentUser);
		}
		elseif($table_model == 'User')
		{
			$placeholderData = $this->user_notification_settings($notification, $currentUser);
		}
		elseif($table_model == 'Role')
		{
			$placeholderData = $this->role_notification_settings($notification, $currentUser);
		}
		elseif($table_model == 'Comment')
		{
			$placeholderData = $this->comment_notification_settings($notification, $currentUser);
		}
		elseif($table_model == 'Configuration')
		{
			$placeholderData = $this->configuration_notification_settings($notification, $currentUser);
		}
		elseif($table_model == 'Blog')
		{
			$placeholderData = $this->blog_notification_settings($notification, $currentUser);
		}
		elseif($table_model == 'BlogCategory')
		{
			$placeholderData = $this->blog_category_notification_settings($notification, $currentUser);
		}
		elseif($table_model == 'BlogTag')
		{
			$placeholderData = $this->blog_tag_notification_settings($notification, $currentUser);
		}
		elseif($table_model == 'Page')
		{
			$placeholderData = $this->page_notification_settings($notification, $currentUser);
		}
		elseif($table_model == 'Contact')
		{
			$placeholderData = $this->contact_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'Lead')
		{
			$placeholderData = $this->lead_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'Channel')
		{
			$placeholderData = $this->channel_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'Source')
		{
			$placeholderData = $this->source_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'ClientGroup')
		{
			$placeholderData = $this->clientgroup_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'Campaign')
		{
			$placeholderData = $this->campaign_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'Invoice')
		{
			$placeholderData = $this->invoice_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'QuotationItem')
		{
			$placeholderData = $this->quotation_item_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'MaterialCompany')
		{
			$placeholderData = $this->material_company_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'MaterialCategory')
		{
			$placeholderData = $this->material_category_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'Material')
		{
			$placeholderData = $this->material_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'Quotation')
		{
			$placeholderData = $this->quotation_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'BusinessConfigMaster')
		{
			$placeholderData = $this->business_config_master_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'Transaction')
		{
			$placeholderData = $this->transaction_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'Project')
		{
			$placeholderData = $this->project_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'Business')
		{
			$placeholderData = $this->business_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'BankAccount')
		{
			$placeholderData = $this->bank_account_notification_settings($notification, $currentUser);
		}
		elseif($tableModel == 'Address')
		{
			$placeholderData = $this->address_notification_settings($notification, $currentUser);
		}else{

			$placeholderData    =   array($table_model =>
											array(
														'sender_id'     => $sender_id,
														'receiver_id'   => $receiver_id,
														'ticket_id'     => $object_id,
											)
										);
		}

		$placeholder_arr    = $this->getPlaceholders('', $table_model, $placeholderData);

		
		$content            = str_replace(array_keys($placeholder_arr), array_values($placeholder_arr), $notification_templates[$notification_config_id]);
		return $content;
	}

	public function defaultPlaceholder()
	{
		$configArray = config('constants.Placeholder');
		$placeholderData = '';
		
		foreach($configArray as $key => $configValue)
		{
			$placeholderData .= '<b>'.$key.' Configuration </b> <br>';
			foreach($configValue as $value)
			{
				$placeholderData .= $value['placeholder'];
				$placeholderData .= ': '.$value['guideline'];
				$placeholderData .= '<br>';
			}
		}

		return $placeholderData;

	}
}
