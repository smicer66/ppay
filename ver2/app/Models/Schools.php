<?php

namespace App\Models;

class Schools extends MyModel
{

    function state() {

        return $this->hasOne(States::class, 'id', 'state_id');
    }


    function school_admin()
    {
        return $this->hasOne(User::class, 'id','school_admin_user_id');
    }

    function school_subscription()
    {
        //return $this->hasOne(SchoolSubscriptions::class,'school_id','id');
		return $this->hasMany(Subscriptions::class,'school_id','id');
    }
}
