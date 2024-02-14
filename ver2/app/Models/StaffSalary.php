<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;


class StaffSalary extends MyModel
{

    use SoftDeletes;

    protected $table = "staff_salaries";

    protected $fillable =
        [
            'id',
            'salary_advice_id',
			'staff_id',
            'amount_to_pay',
			'vat',
            'pension',
			'deductions',
            'breakdown',
            'details',
            'school_id',
			'status'
        ];

    protected $hidden =
        [
            '_token',
        ];

    function salaryAdvice() {
        return $this->hasOne(SalaryAdvice::class, 'id', 'salary_advice_id');
    }

    function staff() {
        return $this->hasOne(SchoolStaff::class, 'id', 'staff_id');
    }
}
