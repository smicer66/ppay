<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;


class StaffSalaryComponent extends MyModel
{

    use SoftDeletes;

    protected $table = "staff_salary_components";

    protected $fillable =
        [
            'id',
            'component_name',
            'salary_component_id',
            'value',
            'staff_id',
            'school_id'
        ];

    protected $hidden =
        [
            '_token',
        ];

    function salary_component()
    {
        return $this->hasOne(SalaryComponent::class, 'id', 'salary_component_id');
    }

}
