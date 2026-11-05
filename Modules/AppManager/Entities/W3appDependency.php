<?php

namespace Modules\AppManager\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class W3appDependency extends Model
{
    use HasFactory;

    protected $table = 'w3app_dependencies';
    protected $fillable = [
        'w3app_id',
        'dependency_w3app_id',
        'dependency_type',
        'minimum_version',
        'maximum_version',
        'is_required',
        'notes'
    ];

    protected $casts = [
        'is_required' => 'boolean'
    ];

    public function w3app()
    {
        return $this->belongsTo(W3app::class, 'w3app_id', 'id');
    }

    public function dependencyW3app()
    {
        return $this->belongsTo(W3app::class, 'dependency_w3app_id', 'id');
    }
}
