<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;


class GradingComment extends MyModel
{

    use SoftDeletes;

    protected $table = "grading_comments";

    protected $fillable =
        [
            'comments',
            'student_id',
            'batch_id',
			'academic_year_id',
            'school_term_id',
            'comment_by_user_id',
        ];

    protected $hidden =
        [
            '_token',
        ];

    function commented_by(){
        return $this->hasOne(User::class, 'id', 'comment_by_user_id');
    }

    function student()
    {
        return $this->hasOne(Students::class, 'id', 'student_id');
    }
}
