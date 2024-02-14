<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolDepartmentSubject extends Model
{
    use SoftDeletes;

    protected $table = "school_department_subjects";

    protected $date = "deleted_at";

    protected $fillable =
        [
            'id',
            'school_id',
            'department_id',
        ];

    protected $hidden =
        [
            '_token',
        ];

    function subjects()
    {
        return $this->hasMany(Subjects::class, 'id', 'subject_id');
    }

}
