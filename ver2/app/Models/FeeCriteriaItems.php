<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class   FeeCriteriaItems extends MyModel
{
    use SoftDeletes;

    function classes()
    {
        return $this->belongsTo(FeeCriteriaItemClasses::class, 'fee_criteria_item_id', 'id');
    }

    function payment_item()
    {
        return $this->hasOne(PaymentItems::class, 'id', 'payment_item_id');
    }
}
