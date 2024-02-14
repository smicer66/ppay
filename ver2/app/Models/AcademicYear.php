<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcademicYear extends Model
{
    //
    use SoftDeletes;

    protected $table = 'school_academic_year';
    protected $date = 'deleted_at';

    public function school_academic_year_term()
    {
        return $this->hasMany(SchoolAcademicYearTerm::class,'academic_year_id','id');
    }
}
