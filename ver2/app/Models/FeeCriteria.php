<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class FeeCriteria extends MyModel
{
    use SoftDeletes;

    function criteria_items() {
        return $this->hasMany(FeeCriteriaItems::class, 'fee_criteria_id', 'id');
    }
	
	
	function acad_year()
    {
        return $this->hasOne(AcademicYear::class, 'id', 'academic_year_id');
    }
	
	
	function acad_term()
    {
        return $this->hasOne(SchoolTerm::class, 'id', 'school_term_id');
    }
}
