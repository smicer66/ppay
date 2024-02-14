<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;


class AppError extends MyModel
{

    use SoftDeletes;

    protected $table = "app_errors";

    protected $fillable =
        [
            'id',
            'error_trace',
            'url',
            'error_dump',
            'user_username'
        ];

    protected $hidden =
        [
            '_token',
        ];


}
