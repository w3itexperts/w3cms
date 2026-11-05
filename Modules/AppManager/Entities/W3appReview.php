<?php

namespace Modules\AppManager\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class W3appReview extends Model
{
    use HasFactory;

    protected $table = 'w3app_reviews';
    protected $fillable = [
        'w3app_id',
        'version_id',
        'reviewer_id',
        'review_status',
        'review_type',
        'review_notes',
        'reviewed_at'
    ];

    protected $casts = [
        'reviewed_at' => 'datetime'
    ];

    public function w3app()
    {
        return $this->belongsTo(W3app::class, 'w3app_id', 'id');
    }

    public function version()
    {
        return $this->belongsTo(W3appVersion::class, 'version_id', 'id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id', 'id');
    }
}
