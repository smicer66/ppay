<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Parents extends MyModel
{
    use SoftDeletes;
	
	

    function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    function users()
    {
        return $this->hasMany(User::class, 'id', 'user_id');
    }
	
	function wards()
    {
        return $this->hasMany(Students::class, 'id', 'parent_id');
    }
	
	
	
	function passport()
    {
        return $this->hasOne(DataBanks::class, 'id', 'data_bank_passport_id');
    }
	
}
