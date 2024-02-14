<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolTimetable extends Model
{
    use SoftDeletes;

    protected $table = 'school_timetable';

    protected $date = 'deleted_at';
	
	function period() {
        return $this->hasOne(SchoolTimetablePeriod::class, 'id', 'period_id');
    }
	
	function subject() {
        return $this->hasOne(Subjects::class, 'id', 'subject_id');
    }
	
	function classes() {
        return $this->hasOne(Classes::class, 'id', 'class_id');
    }
	
	function class_arm() {
        return $this->hasOne(ClassArms::class, 'id', 'class_arm_id');
    }
}
