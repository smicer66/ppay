<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Students extends MyModel
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
	
	function applicant_parents()
    {
		/*select `applicant_parents`.*, `id`.`student_id` as `pivot_student_id`, `id`.`applicant_parents_id` as `pivot_applicant_parents_id` from `applicant_parents` inner join `id` on `applicant_parents`.`id` = `id`.`applicant_parents_id` where `id`.`student_id` in (20151222142850283046))
		select `applicant_parents`.*, `applicant_parents`.`id` as `pivot_id`, `applicant_parents`.`student_id` as `pivot_student_id` from `applicant_parents` inner join `applicant_parents` on `applicant_parents`.`id` = `applicant_parents`.`student_id` where `applicant_parents`.`id` in (20151222142850283046)
		*/
        return $this->hasMany(ApplicantParents::class, 'student_id', 'id');
    }
	
	function passport()
    {
        return $this->hasOne(DataBanks::class, 'id', 'data_bank_passport_id');
    }
	
	function applicant()
    {
        return $this->hasOne(Applicants::class, 'id', 'user_id');
    }
	
	function gradingScores()
	{
		return $this->hasMany(GradingScore::class, 'student_id', 'id');
	}




    public function populate_school_fees_records($student_id = null, $term, $school_id)
    {
        $student = $this->find($student_id);

        //dd($student);
        //dd($student->current_class__arm_id);
        $criteria_item = DB::table('fee_criteria_item_classes')
            ->join('class_arms', 'fee_criteria_item_classes.class_arm_id', '=', 'class_arms.id')
            ->join('classes', 'class_arms.class_id', '=', 'classes.id')
            ->join('fee_criteria_items', 'fee_criteria_item_classes.fee_criteria_item_id', '=', 'fee_criteria_items.id')
            ->join('fee_criterias', 'fee_criteria_items.fee_criteria_id', '=', 'fee_criterias.id')
            ->join('payment_items', 'fee_criteria_items.payment_item_id', '=', 'payment_items.id')
            ->where('fee_criterias.school_id', $school_id)
            ->where('classes.id', $student->current_class_id)
            ->where('fee_criterias.school_term_id', $term)
            ->where('fee_criterias.student_new_old', $student->student_new_old)
            ->where('fee_criterias.accommodation_type', $student->accommodation_type)
            ->where('fee_criteria_item_classes.class_arm_id', $student->current_class__arm_id)
            ->whereNull('fee_criteria_item_classes.deleted_at')
            ->select('fee_criteria_item_classes.*', 'class_arms.*', 'fee_criterias.*', 'class_arms.*', 'classes.*', 'payment_items.*', 'fee_criteria_items.*', 'fee_criteria_items.id', 'payment_items.name');
		//dd($criteria_item->get());
		


        if ($criteria_item->count() <= 0) {
            return false;
        }
        return [$student, $criteria_item];
    }

    public function current_class()
    {
        return $this->hasOne(Classes::class, 'id', 'current_class_id');
    }
	
	public function current_class_arm()
	{
        return $this->hasOne(ClassArms::class, 'id', 'current_class__arm_id');
    }
}
