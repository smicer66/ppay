<?php

namespace App\Models;


class Applicants extends MyModel
{
    public function parents()
    {
        return $this->belongsTo(ApplicantParents::class, 'id', 'applicant_id');
    }

    public function passport()
    {
        return $this->hasOne(DataBanks::class, 'id', 'passport_data_bank_id');
    }

    public function classes()
    {
        return $this->hasOne(Classes::class, 'id', 'class_id');
    }

    public function lga()
    {
        return $this->hasOne(Lga::class, 'id', 'lga_id');
    }
	
	public function academic_year()
    {
        return $this->hasOne(AcademicYear::class, 'id', 'academic_year_id');
    }

    public function academic_term()
    {
        return $this->hasOne(SchoolTerm::class, 'id', 'academic_term_id');
    }
	


}
