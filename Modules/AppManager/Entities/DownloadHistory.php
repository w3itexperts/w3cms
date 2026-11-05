<?php
namespace Modules\AppManager\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DownloadHistory extends Model {
    use HasFactory;


    protected $table = 'download_histories';
    protected $fillable = [
            'user_id',
            'user_ip',
            'city',
            'country',
            'country_code',
            'longitude',
            'latitude',
            'browser',
            'os'
    ];
}
