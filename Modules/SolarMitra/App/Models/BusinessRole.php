<?php

namespace Modules\SolarMitra\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SolarMitra\Database\factories\BusinessRoleFactory;
use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class BusinessRole extends SpatieRole
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope('business_roles', function (Builder $builder) {
            if (auth('business')->check()) {
                $builder->where('role_type','Business');
            }
        });
        static::addGlobalScope('active', function (Builder $builder) {
            $builder->where('status',1);    
        });
    }
    
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'guard_name',
        'business_id',
        'parent_id',
        'role_type',
        'description',
        'level',
        'status'
    ];

    
    protected static function newFactory(): BusinessRoleFactory
    {
        //return BusinessRoleFactory::new();
    }

    public function getCreatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getUpdatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function generateCategoryTreeArray($parent_id=Null, $seprater='_', $fields=['id', 'name'], &$level=0, &$list=[]) 
    {
        $topLevelCategories = BusinessRole::where(function ($query) {
                                    $query->whereNull('business_id')->orWhere('business_id',0);

                                    if (auth('business')->check()) {
                                        $query->orWhere('business_id', app('currentBusinessId'));
                                    }
                                })->select($fields)->where('parent_id', '=', $parent_id)->get()->toArray();

        if(!empty($topLevelCategories))
        {
            foreach ($topLevelCategories as $category) {

                $category['name'] = str_repeat($seprater, $level) . $category['name'];
                
                $list[$category['id']] = $category;
                
                $childrenCategories = $this->getCategoryChildren($category['id']);
                if (count($childrenCategories)) {
                    $level++;
                    $this->generateCategoryTreeArray($category['id'], $seprater, $fields, $level, $list);
                    $level--;
                }
            }

        }
        return $list;
    }

     /**
     * Gets a given category's id children
     *
     * @param $categoryId
     * @return Collection
     */
    public function getCategoryChildren($categoryId) 
    {
        $categories = BusinessRole::withoutGlobalScope('active')->where('parent_id', '!=', Null)->get();
        return $categories->filter(function ($category) use ($categoryId) {
            return $category->parent_id == $categoryId;
        });
    }

    public function scopeWithDefaultAndBusiness($query, $businessId=null)
    {
        $businessId = $businessId ?? app('currentBusinessId');

        return $query->where(function ($q) use ($businessId) {
            $q->whereNull('business_id')
              ->orWhere('business_id', $businessId);
        });
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

}
