<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;


class SalaryAdvice extends MyModel
{

    use SoftDeletes;

    protected $table = "salary_advices";

    protected $fillable =
        [
            'id',
            'month',
			'title',
            'prepared_by',
            'school_id'
        ];

    protected $hidden =
        [
            '_token',
        ];

    function staff_salaries() {
        return $this->hasMany(StaffSalary::class, 'salary_advice_id', 'id');
    }

    function created_by() {
        return $this->hasOne(User::class, 'id', 'prepared_by');
    }

}
