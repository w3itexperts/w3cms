<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SolarMitra\Database\factories\LeadTagFactory;

class LeadTag extends AppModel
{
    use HasFactory;

    protected $table = 'lead_tags';


    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'lead_id',
        'tag_id',
    ];
    
    protected static function newFactory(): LeadTagFactory
    {
        //return LeadTagFactory::new();
    }
}
