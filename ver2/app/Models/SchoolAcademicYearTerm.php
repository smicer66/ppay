<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolAcademicYearTerm extends Model
{
    use SoftDeletes;

    protected $table = 'school_academic_year_term';
    protected $date = 'deleted_at';

    public function school_terms()
    {
        return $this->hasMany(SchoolTerm::class,'id','school_term_id');
    }

    public function school_year(){
        return $this->hasOne(AcademicYear::class,'id','academic_year_id');
    }
	
	public function school_term()
    {
        return $this->hasOne(SchoolTerm::class,'id','school_term_id');
    }
	
}
