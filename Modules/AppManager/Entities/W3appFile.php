<?php

namespace Modules\AppManager\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class W3appFile extends Model
{
    use HasFactory;

    protected $table = 'w3app_files';
    protected $fillable = [
        'w3app_id',
        'title',
        'detail',
        'file',
        'type'
    ];

    public function w3app()
    {
        return $this->belongsTo(W3app::class, 'w3app_id', 'id');
    }
}
