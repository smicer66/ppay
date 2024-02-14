<?php

namespace App\Models;

class SchoolStaff extends MyModel
{
    function user_profile()
    {
        return $this->hasOne(UserProfiles::class, 'id', 'user_profile_id');
    }
	
	
	function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    function passport()
    {
        return $this->hasOne(DataBanks::class, 'id', 'passport_data_bank_id');
    }

    function signature()
    {
        return $this->hasOne(DataBanks::class, 'id', 'signature_data_bank_id');
    }

    function employment_histories()
    {
        return $this->hasMany(StaffEmploymentHistory::class, 'school_staff_id', 'id');
    }

    function academic_histories()
    {
        return $this->hasMany(StaffAcademicHistory::class, 'school_staff_id', 'id');
    }

    function staff_salary_components()
    {
        return $this->hasMany(StaffSalaryComponent::class, 'staff_id', 'id');
    }


}
