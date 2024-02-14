<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradingScore extends Model
{
    //
    protected $table = 'grading_scores';

    protected $fillable = [
            'batch_id',
            'subject_id',
            'class_arm_id',
            'school_id',
            'student_id',
            'staff_id',
            'school_term_id',
            'academic_year_id',
            'exam_type',
            'score',
    ];

    public function student()
    {
        return $this->hasOne(Students::class,'id', 'student_id');
    }

    public function subject()
    {
        return $this->hasOne(Subjects::class,'id', 'subject_id');
    }
	
	public function gradingBatch()
    {
        return $this->hasOne(GradingBatch::class,'id', 'batch_id');
    }
	
	public function exam_type()
    {
        return $this->hasOne(GradingScheme::class,'id', 'exam_type');
    }

}
