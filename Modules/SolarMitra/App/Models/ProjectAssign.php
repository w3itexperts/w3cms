<?php

namespace Modules\SolarMitra\App\Models;

use Modules\SolarMitra\App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SolarMitra\Database\factories\ProjectAssignFactory;
use Carbon\Carbon;

class ProjectAssign extends AppModel
{
    use HasFactory;

    protected $table = 'projects_assign';
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['project_id','staff_id'];
    
    protected static function newFactory(): ProjectAssignFactory
    {
        //return ProjectAssignFactory::new();
    }

    public function staff()
    {
        return $this->hasOne(Contact::class, 'id','staff_id');
    }

    public function getCreatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }

    public function getUpdatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('solarmitra.date_time_format'));
    }
}
