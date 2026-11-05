<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SolarMitra\Database\factories\AttachmentFactory;
use Carbon\Carbon;

class Attachment extends AppModel
{
    use HasFactory;

    protected $table = 'attachments';
    protected $appends = ['attachment_url'];
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['id','business_id','project_id','file_name','type','date','size','tags','user_id'];
    
    protected static function newFactory(): AttachmentFactory
    {
        //return AttachmentFactory::new();
    }

    public function getDateAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getCreatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getUpdatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }


    /*
    * Currently saves single or Multiple images and return attachment id single
    * or in array depend on image
    */
    public function InsertAttachments($request, $file_name, $project_id = null, $business_id = null)
    {
        $allowedMimes = ['jpg','jpeg','png','gif','webp','svg','pdf','doc','docx','xlsx','xls','csv','txt'];

        // Resolve IDs
        $business_id = $business_id ?? app('currentBusinessId');
        $project_id  = $project_id ?? $request->input('project_id');

        // No business ID or file uploaded
        if (!$business_id || !$request->hasFile($file_name)) {
            return null;
        }

        // Normalize files into an array
        $files = $request->file($file_name);

        if (!is_array($files)) {
            $files = [$files];
        }

        // Validate files
        foreach ($files as $file) {
            if (!$file->isValid()) {
                abort(400, 'One or more uploaded files are invalid.');
            }

            $extension = strtolower($file->getClientOriginalExtension());

            if (!in_array($extension, $allowedMimes, true)) {
                abort(400, 'File type not allowed: ' . $extension);
            }
        }

        // Get business owner/user
        $business = Business::find($business_id);

        if (!$business) {
            abort(404, 'Business not found.');
        }

        if (!$business->user) {
            abort(400, 'Business owner not found.');
        }

        $business_user_id = $business->user->id;

        // Build storage folder
        if (!empty($project_id)) {
            $folderPath = 'public/solarmitra-attachments/business_' .
                $business_id .
                '/project_' .
                $project_id;
        } else {
            $folderPath = 'public/solarmitra-attachments/business_' . $business_id;
        }

        // Create directory if it doesn't exist
        if (!\Storage::exists($folderPath)) {
            \Storage::makeDirectory($folderPath);
        }

        $attachmentIds = [];

        foreach ($files as $file) {

            $originalName = $file->getClientOriginalName();

            // Prevent unsafe characters in original filename
            $safeOriginalName = preg_replace(
                '/[^A-Za-z0-9\-\._]/',
                '_',
                $originalName
            );

            $fileName = time() . '_' . uniqid() . '_' . $safeOriginalName;

            $fileType = $file->getMimeType();
            $fileSize = $file->getSize();

            // Store file
            $file->storeAs($folderPath, $fileName);

            // Save attachment record
            $attachment = new Attachment();

            $attachment->business_id = $business_id;
            $attachment->project_id  = $project_id ?? 0;
            $attachment->user_id     = $business_user_id;
            $attachment->file_name   = $fileName;
            $attachment->type        = $fileType;
            $attachment->date        = now();
            $attachment->size        = $fileSize;
            $attachment->tags        = $request->input('tags');

            $attachment->save();

            $attachmentIds[] = $attachment->id;
        }

        // Return single ID for single upload, array for multiple uploads
        return count($attachmentIds) === 1 && !is_array($request->file($file_name))
            ? $attachmentIds[0]
            : $attachmentIds;
    }


    public function DeleteAttachment($attachment_id,$project_id=null,$business_id=null)
    {
        $attachment = Attachment::Find($attachment_id);
        $business_id = $attachment->business_id ?? app('currentBusinessId');
        $project_id = $attachment->project_id ?? $project_id;
        $fileName = basename(@$attachment->file_name); // strips path components
        $filepath = storage_path('app/public/solarmitra-attachments/business_' . $business_id . '/project_' . $project_id .'/').@$fileName;

        if(\File::exists($filepath))
        {
            \File::delete($filepath);
        }
        return $res = $attachment ? $attachment->delete() : null;
    }

    public function getAttachmentUrlAttribute()
    {
        $businessId = $this->business_id ?? 0;
        $projectId  = $this->project_id ?? 0;

        if (!empty($projectId)) {
            $path = 'solarmitra-attachments/business_' . $businessId . '/project_' . $projectId . '/' . $this->file_name;
        } else {
            $path = 'solarmitra-attachments/business_' . $businessId . '/' . $this->file_name;
        }

        return asset('storage/' . $path);
    }
}
