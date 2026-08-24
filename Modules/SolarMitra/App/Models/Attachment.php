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
    public function InsertAttachments($request,$file_name,$project_id=null,$business_id=null)
    {
        $business_id = $business_id ?? app('currentBusinessId');
        $project_id = $project_id ?? request('project_id');
        
        if ($request->hasFile($file_name) && $business_id) {


            // Normalize files (single or multiple)
            $files = is_array($request->file($file_name)) ? $request->file($file_name) : [$request->file($file_name)];
            $business_user_id = Business::find($business_id)->user->id;

            $attachmentIds = [];

            foreach ($files as $attachment) {

                $originalName = $attachment->getClientOriginalName();
                $fileName     = time() . '_' . uniqid() . '_' . $originalName;
                $fileType     = $attachment->getMimeType();
                $fileSize     = $attachment->getSize();

                if (!empty($project_id)) {
                    $folderPath = 'public/solarmitra-attachments/business_' . $business_id . '/project_' . $project_id;
                }else{
                    $folderPath = 'public/solarmitra-attachments/business_' . $business_id;
                }

                if (!\Storage::exists($folderPath)) {
                    \Storage::makeDirectory($folderPath);
                }

                $attachment->storeAs($folderPath, $fileName);

                $AttachmentObj = new Attachment();
                $AttachmentObj->business_id = $business_id;
                $AttachmentObj->project_id  = $project_id ?? 0;
                $AttachmentObj->user_id     = $business_user_id;
                $AttachmentObj->file_name   = $fileName;
                $AttachmentObj->type        = $fileType;
                $AttachmentObj->date        = now();
                $AttachmentObj->size        = $fileSize;
                $AttachmentObj->tags        = $request->tags;
                $AttachmentObj->save();

                // Store only ID
                $attachmentIds[] = $AttachmentObj->id;
            }

            // Return single ID or array of IDs
            return is_array($request->file($file_name)) ? $attachmentIds : $attachmentIds[0];
        }
     

        return null;

    }

    public function DeleteAttachment($attachment_id,$project_id=null,$business_id=null)
    {
        $attachment = Attachment::Find($attachment_id);
        $business_id = $attachment->business_id ?? app('currentBusinessId');
        $project_id = $attachment->project_id ?? $project_id;
        $filepath = storage_path('app/public/solarmitra-attachments/business_' . $business_id . '/project_' . $project_id .'/').@$attachment->file_name;

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
