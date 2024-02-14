<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;


class Report extends MyModel
{

    use SoftDeletes;

    protected $table = "reports";

    protected $fillable =
        [
            'name',
		'is_downloaded',
		'report_date'
        ];

    protected $hidden =
        [
            '_token',
        ];
}
