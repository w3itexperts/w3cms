<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SolarMitra\Database\factories\MaterialCategoryFactory;
use Carbon\Carbon;

class MaterialCategory extends AppModel
{
    use HasFactory;

    protected $table = 'material_categories';
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'parent_id',
        'title',
        'slug',
        'display_on_invoice',
        'calculate_in_invoice',
        'include_in_solar_kit',
        'order',
        'unit_id',
        'gst',
        'description',
    ];

    public function companies()
    {
        return $this->belongsToMany(
            MaterialCompany::class,
            'material_companies_material_categories',
            'material_category_id',
            'material_company_id'
        );
    }

    public function material_items()
    {
        return $this->hasMany(MaterialLibrary::class, 'material_category_id');
    }
    
    protected static function newFactory(): MaterialCategoryFactory
    {
        //return MaterialCategoryFactory::new();
    }

    public function getCreatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getUpdatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }


    public function generateCategoryTreeArray($parent_id=Null, $seprater='_', $fields=['id', 'title'], &$level=0, &$list=[]) 
    {
        $topLevelCategories = MaterialCategory::select($fields)->withCount('companies')->withCount('material_items')->where('parent_id', '=', $parent_id)->get()->toArray();

        if(!empty($topLevelCategories))
        {
            foreach ($topLevelCategories as $category) {

                $category['title'] = str_repeat($seprater, $level) . $category['title'];
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
        $categories = MaterialCategory::where('parent_id', '!=', Null)->get();
        return $categories->filter(function ($category) use ($categoryId) {
            return $category->parent_id == $categoryId;
        });
    }

    public function moveUp($id, $step) {

        $currentPosition = MaterialCategory::select('id', 'order')->findorFail($id);
        
        if($currentPosition->id > 1)
        {
            $limit = $step;

            $changePosition = MaterialCategory::select('id', 'order')
                                ->where('order', '<', $currentPosition->order)
                                ->orderBy('order', 'DESC')
                                ->limit($limit)
                                ->get()->toArray();

            
            $lastArray = end($changePosition);
            $currentPositionRes = MaterialCategory::where('id', '=', $currentPosition->id)
                                ->update(['order'=> $lastArray['order']]);

            $changePositionId = ($limit > 1) ? $lastArray['id'] : $lastArray['id'];

            $changePositionRes = MaterialCategory::where('id', '=', $changePositionId)
                                ->update(['order'=>$currentPosition->order]);
            return true;
        }
        else
        {
            return  false;
        }
    }

    public function moveDown($id, $step) {
        $currentPosition = MaterialCategory::select('id', 'order')->findOrFail($id);
        $maxOrder = MaterialCategory::max('order');
        
        if($currentPosition->order < $maxOrder)
        {
            $limit = $step;

            $changePosition = MaterialCategory::select('id', 'order')
                                ->where('order', '>', $currentPosition->order)
                                ->orderBy('order', 'ASC')
                                ->limit($limit)
                                ->get()->toArray();

            $lastArray = end($changePosition);
            $currentPositionRes = MaterialCategory::where('id', '=', $currentPosition->id)
                                ->update(['order'=> $lastArray['order']]);

            $changePositionId = ($limit > 1) ? $lastArray['id'] : $lastArray['id'];

            $changePositionRes = MaterialCategory::where('id', '=', $changePositionId)
                                ->update(['order'=>$currentPosition->order]);
            
            return true;
        }
        else
        {
            return  false;
        }
    }

}   
