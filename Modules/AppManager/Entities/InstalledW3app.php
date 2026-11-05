<?php

namespace Modules\AppManager\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InstalledW3app extends Model
{
    use HasFactory;

    protected $table = 'installed_w3apps';
    protected $fillable = [
        'w3app_id',
        'domain',
        'version',
        'status',
        'installed_at',
        'last_checked_at',
        'deleted'
    ];

    public function w3app()
    {
        return $this->belongsTo(W3app::class, 'w3app_id', 'id');
    }
}
