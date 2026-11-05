<?php
namespace Modules\AppManager\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ThemePreset extends Model {
    use HasFactory;


    protected $table = 'theme_presets';
    protected $fillable = [
        'w3app_id',
        'title',
        'preview_image',
        'demo_link',
        'preset_data_xml',
    ];
}
