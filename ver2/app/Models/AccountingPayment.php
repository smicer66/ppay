<?php

namespace App\Models;

class AccountingPayment extends MyModel
{

    function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    function paid_by()
    {
        return $this->hasOne(User::class, 'id', 'actor_id');
    }


    function payment_category()
    {
        return $this->hasOne(PaymentCategories::class, 'id', 'payment_category_id');
    }

    function invoice()
    {
        return $this->hasOne(Invoice::class, 'id', 'payment_category_instance_id');
    }

}