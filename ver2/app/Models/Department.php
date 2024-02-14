<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes;

    protected $table = "departments";

    protected $date = "deleted_at";

    protected $fillable =
        [
          'id',
          'school_id',
          'name',
          'user_id',
          'subjects',
        ];

    protected $hidden =
        [
          '_token',
        ];

    function dept_head()
    {
        return $this->hasOne(SchoolStaff::class, 'id', 'dept_head_id');
    }
	
	function subjects()
	{
		return $this->hasMany(Subjects::class, 'department_id', 'id');
	}


    /*function schoolDeptSubjects_Dept()
    {
        return $this->hasMany(SchoolDepartmentSubject::class, 'department_id', 'id');
    }*/


}
