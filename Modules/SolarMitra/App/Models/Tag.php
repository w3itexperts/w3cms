<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SolarMitra\Database\factories\TagFactory;
use Carbon\Carbon;

class Tag extends AppModel
{
    use HasFactory;

    protected $table = 'tags';


    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'title',
        'slug',
        'description',
        'color',
        'created_by',
    ];
    
    protected static function newFactory(): TagFactory
    {
        //return TagFactory::new();
    }

    public function getCreatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getUpdatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }
}
