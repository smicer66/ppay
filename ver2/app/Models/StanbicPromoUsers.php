<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;


class StanbicPromoUsers extends MyModel
{

    use SoftDeletes;

    protected $table = "stanbic_promo_users";

    protected $fillable =
        [
            'id',
            'logged_by_user_id',
            'customer_mobile',
            'customer_name',
            'receipt_no',
            'status'
        ];

    protected $hidden =
        [
            '_token',
        ];
}
