<?php

namespace App\Models;

class FeeTrackers extends MyModel
{
    function class_() {
        return $this->hasOne(Classes::class, 'id', 'class_id');
    }
    function class_arm() {
        return $this->hasOne(ClassArms::class, 'id', 'class_arm_id');
    }
    function payment_history() {
        return $this->hasOne(PaymentHistories::class, 'id', 'payment_history_id');
    }
}
