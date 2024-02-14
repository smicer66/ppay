<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;


class ClassArms extends MyModel
{

    use SoftDeletes;

    protected $table = "class_arms";

    protected $fillable =
        [
            'id',
            'class_arm',
        ];

    protected $hidden =
        [
            '_token',
        ];

    function class_() {
        return $this->hasOne(Classes::class, 'id', 'class_id');
    }

    function staff(){
        return $this->hasOne(SchoolStaff::class, 'id', 'staff_id');
    }
	
	function form_teacher(){
        return $this->hasOne(User::class, 'id', 'form_teacher_user_id');
    }

    function students()
    {
        return $this->hasMany(Students::class, 'current_class__arm_id', 'id');
    }
}
