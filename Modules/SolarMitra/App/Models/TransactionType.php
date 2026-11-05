<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SolarMitra\Database\factories\TransactionTypeFactory;
use Carbon\Carbon;

class TransactionType extends AppModel
{
    use HasFactory;

    protected $table = 'transaction_types';
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['title', 'slug', 'parent_id', 'is_active'];
    
    protected static function newFactory(): TransactionTypeFactory
    {
        //return TransactionTypeFactory::new();
    }

    public function getCreatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getUpdatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function childs() 
    {
        return $this->hasMany(TransactionType::class, 'parent_id', 'id');
    }
    
    public function getSlugAttribute()
    {
        return \Str::slug($this->title);
    }

    public function generateTreeArray($parent_id=Null, $seprater='_', $fields=['id', 'title'], &$level=0, &$list=[]) 
    {
        $topLevelCategories = TransactionType::select($fields)->where('parent_id', '=', $parent_id)->get()->toArray();

        if(!empty($topLevelCategories))
        {
            foreach ($topLevelCategories as $category) {

                $category['title'] = str_repeat($seprater, $level) . $category['title'];

                $list[$category['id']] = $category;
                
                $childrenCategories = $this->getChildren($category['id']);
                if (count($childrenCategories)) {
                    $level++;
                    $this->generateTreeArray($category['id'], $seprater, $fields, $level, $list);
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
    public function getChildren($categoryId) 
    {
        $categories = TransactionType::where('parent_id', '!=', Null)->get();
        return $categories->filter(function ($category) use ($categoryId) {
            return $category->parent_id == $categoryId;
        });
    }

}
