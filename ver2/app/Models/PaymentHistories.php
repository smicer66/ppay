<?php

namespace App\Models;

class PaymentHistories extends MyModel
{
    function tracker() {
        return $this->hasOne(FeeTrackers::class, 'payment_history_id', 'id');
    }

    function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
	
	function applicant() {
        return $this->hasOne(Applicants::class, 'id', 'applicant_id');
    }

    function paid_by() {
        return $this->hasOne(User::class, 'id', 'actor_id');
    }


    function payment_category() {
        return $this->hasOne(PaymentCategories::class, 'id', 'payment_category_id');
    }



}