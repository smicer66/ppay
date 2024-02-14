<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;


class BillData extends MyModel
{

    use SoftDeletes;

    protected $table = "billdata";

    protected $fillable =
        [
            'data'
        ];

    protected $hidden =
        [
            '_token',
        ];
}
