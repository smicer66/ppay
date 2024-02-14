<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;


class LoginData extends MyModel
{

    use SoftDeletes;

    protected $table = "logindata";

    protected $fillable =
        [
            'data',
            'orderId'
        ];

    protected $hidden =
        [
            '_token',
        ];
}
