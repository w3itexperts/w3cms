<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SolarMitra\Helper\SolarMitraHelper;
use Carbon\Carbon;

class ClientFeedback extends AppModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'client_feedbacks';
    protected $fillable = ['project_id','rating','review','video_review'];
    protected $appends = ['video_review_url'];
    
    public function getVideoReviewUrlAttribute()
    {
        $businessId = $this->project?->business_id;

        return $this->video_review ? SolarMitraHelper::getAttachmentImage($this->video_review) : null;
    }

    public function project()
    { 
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function getCreatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getUpdatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }
}
