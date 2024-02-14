<?php

namespace App\Models;

class Subscriptions extends MyModel
{
	function package()
    {
        //return $this->hasOne(SchoolSubscriptions::class,'school_id','id');
		return $this->hasOne(Packages::class,'id','package_id');
    }
}
