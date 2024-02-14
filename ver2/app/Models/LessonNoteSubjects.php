<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LessonNoteSubjects extends Model
{
    //
    use SoftDeletes;

    protected $table = 'lesson_note_subject';

    protected $fillable =
        [
            'id',
            'school_id',
            'subject_id',
            'staff_id',
            'lesson_title',
            'lesson_note'
        ];

    protected $hidden =
        [
            '_token',
        ];

    public function subject(){
        return $this->hasOne(Subjects::class,'id','subject_id');
    }

    public function classes()
    {
        return $this->hasOne(Classes::class,'id', 'class_id');
    }
	
	public function academic_year(){
        return $this->hasOne(AcademicYear::class,'id','academic_year_id');
    }

    public function academic_term()
    {
        return $this->hasOne(SchoolTerm::class,'id', 'academic_term_id');
    }
	
	public function staff()
    {
        return $this->hasOne(SchoolStaff::class,'id', 'staff_id');
    }
}
