<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;


class PerformanceIndex extends MyModel
{

    use SoftDeletes;

    protected $table = "performance_indexes";

    protected $fillable =
        [
            'id',
            'performance_index',
			'status',
            'grading_options',
			'school_id'
        ];

    protected $hidden =
        [
            '_token',
        ];


   
}
