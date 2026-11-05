<?php

namespace Modules\AppManager\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class W3appAuthor extends Model
{
    use HasFactory;

    protected $table = 'w3app_authors';
    protected $fillable = [
        'name',
        'email',
        'website',
        'company',
        'avatar',
        'bio',
        'author_type',
        'verification_status',
        'status'
    ];
}
