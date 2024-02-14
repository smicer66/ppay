<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentExtraCurricular extends Model
{
    //
    use SoftDeletes;

    protected $table = 'student_extracurricular_activities';
    protected $date = 'deleted_at';
}
