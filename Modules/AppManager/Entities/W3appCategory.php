<?php

namespace Modules\AppManager\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class W3appCategory extends Model
{
    use HasFactory;

    protected $table = 'w3app_categories';
    protected $fillable = [
        'parent_id',
        'code',
        'title',
        'slug',
        'description',
        'icon',
        'sort_order',
        'status'
    ];

    public function parent()
    {
        return $this->belongsTo(W3appCategory::class, 'parent_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(W3appCategory::class, 'parent_id', 'id');
    }

    public function w3apps()
    {
        return $this->belongsToMany(W3app::class, 'w3app_category_map', 'category_id', 'w3app_id')->withPivot('created_at');
    }
}
