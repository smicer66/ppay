<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;


class BankCard extends MyModel
{

    use SoftDeletes;

    protected $table = "bank_cards";

    protected $fillable =
        [
            'id',
            'bank_id',
			'card_type',
            'card_no',
			'expiry_date',
            'max_payout',
			'added_by_user_id',
			'school_id'
        ];

    protected $hidden =
        [
            '_token',
        ];

    function bank() {
        return $this->hasOne(Banks::class, 'id', 'bank_id');
    }
}
