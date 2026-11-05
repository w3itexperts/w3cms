<?php

namespace Modules\AppManager\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
use App\Models\User;

class W3app extends Model
{
	use HasFactory;

	protected $table = 'w3apps';
	protected $fillable = [
		'code',
		'title',
		'slug',
		'author_id',
		'author_email',
		'preview_image',
		'screenshots',
		'package_zip',
		'keywords',
		'feature_tags',
		'technology_platform',
		'demo_link',
		'documentation_link',
		'description',
		'type',
		'downloads',
		'launching_date', 
		'status'
	];

	public function w3app_files()
	{
		return $this->hasMany(W3appFile::class, 'w3app_id', 'id');
	}

	public function installed_w3apps()
	{
		return $this->hasMany(InstalledW3app::class, 'w3app_id', 'id');
	}

    public function author() {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    public function setLaunchingDateAttribute( $value ) {
        $this->attributes['launching_date'] = (new Carbon($value))->format('Y-m-d H:i:s');
    }

    public function getLaunchingDateAttribute( $value ) {
        return $this->attributes['launching_date'] = (new Carbon($value))->format(config('Site.custom_date_format').' '.config('Site.custom_time_format'));
    }
}
