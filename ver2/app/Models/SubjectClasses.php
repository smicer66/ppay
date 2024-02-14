<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubjectClasses extends Model
{
    //
    use SoftDeletes;
    protected $table = 'subject_classes';

    protected $date = 'deleted_at';

    protected $fillable =
        [
            'id',
            'school_id',
            'subject_id',
            'class_arm_id',
            'staff_id',
            'school_term_id',
            'academic_year_id'
        ];

    protected $hidden =
        [
            '_token',
        ];

    public function subject()
    {
        return $this->hasOne(Subjects::class, 'id', 'subject_id');
    }
	
	public function schoolStaff()
	{
		return $this->hasOne(SchoolStaff::class, 'id', 'staff_id');
	}
}
