<?php

namespace Modules\SolarMitra\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class AppModel extends Model
{
    use HasFactory;
    
    public static function getUniqueTitle($title, $ignoreId = null, $field = 'title')
    {
        $originalTitle = $title;
        $counter = 2;

        // Added ignoreId to check while update time
        while (static::where($field, $title)->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))->exists()) 
        {
            $title = $originalTitle . ' - ' . $counter;
            $counter++;
        }

        return $title;
    }
    
}
