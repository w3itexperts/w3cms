<?php

namespace Modules\AppManager\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModuleHierarchyNode extends Model
{
    use HasFactory;

    protected $table = 'module_hierarchy_nodes';
    protected $fillable = [
        'parent_id',
        'code',
        'title',
        'description',
        'icon',
        'sort_order',
        'status'
    ];

    public function parent()
    {
        return $this->belongsTo(ModuleHierarchyNode::class, 'parent_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(ModuleHierarchyNode::class, 'parent_id', 'id');
    }
}
