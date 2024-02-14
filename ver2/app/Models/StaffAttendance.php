<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaffAttendance extends Model
{
    //
    use SoftDeletes;

    protected $table = "attendance_staff";

    protected $date = "deleted_at";
	
	function staff()
    {
        return $this->hasOne(SchoolStaff::class, 'id', 'staff_id');
    }

    function staff_profile()
    {
        return $this->hasOne(SchoolStaff::class, 'id', 'student_id');
    }

}
