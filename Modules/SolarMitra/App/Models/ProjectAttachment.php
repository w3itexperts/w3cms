<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SolarMitra\Database\factories\ProjectAttachmentFactory;
use Modules\SolarMitra\Helper\SolarMitraHelper;
use Carbon\Carbon;

class ProjectAttachment extends AppModel
{
    use HasFactory;

    protected $table = 'project_attachments';
    protected $appends = ['attachment_url'];
    
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['project_id','attachment_id','user_id','type'];
    
    protected static function newFactory(): ProjectAttachmentFactory
    {
        //return ProjectAttachmentFactory::new();
    }

    public function getAttachmentUrlAttribute()
    {
        return SolarMitraHelper::getAttachmentImage($this->attachment_id);
    }

    public function getCreatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getUpdatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }
}
