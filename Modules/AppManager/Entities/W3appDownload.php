<?php

namespace Modules\AppManager\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class W3appDownload extends Model
{
    use HasFactory;

    protected $table = 'w3app_downloads';
    public $timestamps = false;
    protected $fillable = [
        'w3app_id',
        'version_id',
        'domain',
        'technology_platform',
        'download_type',
        'downloaded_at',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'downloaded_at' => 'datetime'
    ];

    public function w3app()
    {
        return $this->belongsTo(W3app::class, 'w3app_id', 'id');
    }

    public function version()
    {
        return $this->belongsTo(W3appVersion::class, 'version_id', 'id');
    }
}
