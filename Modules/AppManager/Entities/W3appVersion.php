<?php

namespace Modules\AppManager\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class W3appVersion extends Model
{
    use HasFactory;

    protected $table = 'w3app_versions';
    protected $fillable = [
        'w3app_id',
        'version',
        'release_type',
        'development_status',
        'release_status',
        'minimum_w3cms_version',
        'minimum_php_version',
        'release_notes',
        'package_file',
        'package_size',
        'checksum',
        'released_at'
    ];

    protected $casts = [
        'released_at' => 'datetime'
    ];

    public function w3app()
    {
        return $this->belongsTo(W3app::class, 'w3app_id', 'id');
    }

    public function reviews()
    {
        return $this->hasMany(W3appReview::class, 'version_id', 'id');
    }

    public function downloads()
    {
        return $this->hasMany(W3appDownload::class, 'version_id', 'id');
    }
}
