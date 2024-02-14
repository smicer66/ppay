<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;


class SalaryComponent extends MyModel
{

    use SoftDeletes;

    protected $table = "salary_components";

    protected $fillable =
        [
            'id',
            'component_name',
            'school_id'
        ];

    protected $hidden =
        [
            '_token',
        ];


}
