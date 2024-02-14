<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subjects extends Model
{
    use SoftDeletes;

    protected $table = 'subjects';

    protected $date = "deleted_at";

    protected $fillable =
        [
            'id',
            'school_id',
            'department_id',
            'name',
            'type',
            'user_id',
        ];

    protected $hidden =
        [
            '_token',
        ];

    public function departments(){

        return $this->hasOne(Department::class, 'id','department_id');
    }
	
	
	public function gradingBatches(){

        return $this->hasMany(GradingBatch::class, 'subject_id','id');
    }
	
	
	public function subjectClasses(){

        return $this->hasMany(SubjectClasses::class, 'subject_id','id');
    }
}
