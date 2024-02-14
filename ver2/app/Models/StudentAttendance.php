<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentAttendance extends Model
{
    //
    use SoftDeletes;

    protected $table = "attendance_student";

    protected $date = "deleted_at";

    function student()
    {
        return $this->hasOne(Students::class, 'id', 'student_id');
    }

    function student_profile()
    {
        return $this->hasOne(Students::class, 'id', 'student_id');
    }

    function student_class()
    {
        return $this->hasOne(ClassArms::class, 'id', 'class_id');
    }

    public static function getRollcallBySchoolClassandDate($school, $class, $date_formatted)
    {

        return \DB::table('attendance_student')
            ->leftJoin('students', 'students.id', '=', 'attendance_student.student_id')
            ->leftJoin('users', 'students.user_id', '=', 'users.id')
            ->leftJoin('user_profiles', 'user_profiles.id', '=', 'users.user_profile_id')
            ->leftJoin('classes', 'students.current_class_id', '=', 'classes.id')
            ->leftJoin('class_arms', 'students.current_class__arm_id', '=', 'class_arms.id')
            ->select('last_name', 'first_name', 'other_name', 'arm_name', 'classes.class_type', 'classes.class_level', 'classes.name', 'attendance_student.is_absent', 'attendance_student.absent_on_permission')
            ->where('attendance_student.school_id', '=', $school)
            ->where('attendance_student.attendance_date', '=', $date_formatted)
            ->where('attendance_student.class_id', '=', $class)
            ->get();
    }
	
	
	public static function getRollcallBySchoolClassandDateByStudent($school, $student)
    {
        return \DB::table('attendance_student')
            ->leftJoin('students', 'students.id', '=', 'attendance_student.student_id')
			->where('students.id', '=', $student->id)
            ->leftJoin('users', 'students.user_id', '=', 'users.id')
            ->leftJoin('user_profiles', 'user_profiles.id', '=', 'users.user_profile_id')
            ->leftJoin('classes', 'students.current_class_id', '=', 'classes.id')
            ->leftJoin('class_arms', 'students.current_class__arm_id', '=', 'class_arms.id')
            ->select('last_name', 'first_name', 'other_name', 'arm_name', 'classes.class_type', 'classes.class_level', 'classes.name', 'attendance_student.is_absent', 'attendance_student.attendance_date', 'attendance_student.absent_on_permission')
            ->where('attendance_student.school_id', '=', $school)
            ->get();
    }


}
