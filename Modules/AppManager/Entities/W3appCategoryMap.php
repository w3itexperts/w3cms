<?php

namespace Modules\AppManager\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class W3appCategoryMap extends Model
{
    use HasFactory;

    protected $table = 'w3app_category_map';
    const UPDATED_AT = null;
    protected $fillable = [
        'w3app_id',
        'category_id',
        'created_at'
    ];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    public function w3app()
    {
        return $this->belongsTo(W3app::class, 'w3app_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(W3appCategory::class, 'category_id', 'id');
    }
}
