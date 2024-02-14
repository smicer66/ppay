<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    //
    use SoftDeletes;

    protected $table = 'web_pages';

    protected $fillable =
        [
            'id',
            'school_id',
            'page_name',
            'created_by_user_id',
            'status',
            'trait_url',
            'contents',
            'contents_no_html'
        ];

    protected $hidden =
        [
            '_token',
        ];
}
