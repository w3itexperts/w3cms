<?php

namespace Modules\SolarMitra\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\SolarMitra\App\Models\AppFeedback;
use Modules\SolarMitra\App\Models\Attachment;
use Illuminate\Support\Facades\Validator;

class AppFeedbacksController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'feedback_type' => 'required|in:Suggestion,Issue,Feature Request,Improvement,Other',
            'subject'       => 'required|string|max:255',
            'description'   => 'required|string',
            'attachment'    => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
            'priority'      => 'required|in:Low,Medium,High',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => __('solarmitra::solarmitra.validation_failed'),
                'errors'  => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();
        $data['business_id']      = app('currentBusinessId');
        $data['user_id']          = $request->user()->id ?? null;
        $data['status']           = 'New';
        $data['module_name']      = $request->header('X-Module-Name');
        $data['page_url']         = $request->header('X-Page-Url');
        $data['browser']          = $request->header('User-Agent');
        $data['operating_system'] = $request->header('X-Operating-System');
        $data['app_version']      = $request->header('X-App-Version');
        $data['ip_address']       = $request->ip();

        if ($request->hasFile('attachment')) {
            $AttachmentObj = new Attachment();
            $attachmentId = $AttachmentObj->InsertAttachments($request, 'attachment');
            $data['attachment'] = $attachmentId;
        }

        $feedback = AppFeedback::create($data);

        return response()->json([
            'status'  => true,
            'message'  => __('solarmitra::solarmitra.feedback_submitted_successfully'),
            'feedback' => $feedback,
        ], 201);
    }
}