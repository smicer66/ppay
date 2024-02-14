<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttendanceHistories extends Model
{
    use SoftDeletes;

    protected $table = "attendance_histories";

    protected $fillable =
        [
            'id',
            'staff_id',
            'class_id',
            'school_id',
            'no_present',
            'no_present',
            'no_absent',
            'attendance_date'
        ];
		
	public function classArm(){
        return $this->hasOne(ClassArms::class,'id','class_id');
    }

}
