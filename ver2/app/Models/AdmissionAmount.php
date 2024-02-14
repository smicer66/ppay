<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdmissionAmount extends Model
{
    //
    use SoftDeletes;

    protected $table = 'admission_amount';
    protected $date = 'deleted_at';

    public function school_term()
    {
        return $this->hasOne(SchoolTerm::class,'id', 'academic_term_id');
    }
	
	public function school_year()
    {
        return $this->hasOne(AcademicYear::class,'id', 'academic_year_id');
    }
	
	public function class_()
    {
        return $this->hasOne(Classes::class,'id', 'class_id');
    }
}
