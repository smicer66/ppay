<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestForAbsence extends Model
{
    //
    use SoftDeletes;

    protected $table = "attendance_absence_request";

    protected $date = "deleted_at";

    protected $fillable =
        [
            'id',
            'school_id',
            'class_id',
            'student_id',
            'absence_date',
            'reason_absence',
        ];

    protected $hidden =
        [
            '_token',
        ];


    public static function getAbsentee($date_today, $id=NULL, $isStudent)
	{
		//dd($date_today);
        $ret = \DB::table('attendance_absence_request')
            ->leftJoin('students', 'students.id', '=', 'attendance_absence_request.student_id')
            ->leftJoin('users', 'students.user_id', '=', 'users.id')
            ->leftJoin('user_profiles', 'user_profiles.id', '=', 'users.user_profile_id')
            ->select('attendance_absence_request.*','last_name', 'first_name', 'other_name', 'attendance_absence_request.reason_absence', 'attendance_absence_request.student_id');
		
		if($isStudent==true)
			$ret = $ret->whereNotNull('student_id');
		else if($isStudent==false)
			$ret = $ret->whereNotNull('school_staff_id'); 
		
		
        $ret = $ret->where('absence_date', '=', $date_today);
		
		if(!is_null($id))
		{
			$ret = $ret->where('class_arm_id', '=', $id);
			//dd($ret->get());
		}
		$ret = $ret->get();
		return $ret;
    }

}
