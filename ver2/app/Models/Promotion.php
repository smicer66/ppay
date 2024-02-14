<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promotion extends Model
{
    use SoftDeletes;

    protected $table = "promotions";

    protected $date = "deleted_at";

    protected $fillable =
        [
          'id',
          'school_id',
          'student_id',
          'user_id',
          'class_arm_id',
		  'academic_year_id',
		  'school_term_id'
        ];

    protected $hidden =
        [
          '_token',
        ];

    function student()
    {
        return $this->hasOne(Students::class, 'id', 'student_id');
    }
	
	function classArm()
    {
        return $this->hasOne(ClassArms::class, 'id', 'class_arm_id');
    }
	


    /*function schoolDeptSubjects_Dept()
    {
        return $this->hasMany(SchoolDepartmentSubject::class, 'department_id', 'id');
    }*/


}
