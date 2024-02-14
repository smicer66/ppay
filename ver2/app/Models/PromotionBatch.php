<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PromotionBatch extends Model
{
    use SoftDeletes;

    protected $table = "promotion_batch";

    protected $date = "deleted_at";

    protected $fillable =
        [
          'id',
          'class_arm_id_advice',
          'school_id',
          'academic_year_id',
          'current_class_arm_id',
		  'academic_term_id',
		  'status'
        ];

    protected $hidden =
        [
          '_token',
        ];

    function promotions()
    {
        return $this->hasMany(Promotion::class, 'promotion_batch_id', 'id');
    }
	
	function class_arm()
    {
        return $this->hasOne(ClassArms::class, 'id', 'current_class_arm_id');
    }
	
	function class_advice()
    {
        return $this->hasOne(Classes::class, 'id', 'class_id_advice');
    }
	


    /*function schoolDeptSubjects_Dept()
    {
        return $this->hasMany(SchoolDepartmentSubject::class, 'department_id', 'id');
    }*/


}
