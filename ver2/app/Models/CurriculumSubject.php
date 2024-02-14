<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CurriculumSubject extends Model
{
    use SoftDeletes;

    protected $table = 'curriculum_subject';
    protected $date = 'deleted_at';


    public function subject(){
        return $this->hasOne(Subjects::class,'id','subject_id');
    }
}
