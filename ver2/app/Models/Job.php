<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;


class Job extends MyModel
{

    use SoftDeletes;

    protected $table = "jobs";

    protected $fillable =
        [
            'id',
            'title',
			'expiry_date',
            'location',
			'job_type',
            'status',
			'school_id',
            'description',
        ];

    protected $hidden =
        [
            '_token',
        ];


   
}
