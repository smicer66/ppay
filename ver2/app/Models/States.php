<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;


class States extends MyModel
{

    use SoftDeletes;

    protected $table = "states";

    protected $fillable =
        [
            'id',
            'name',
            'code',
            'status',
            'env',
        ];

    protected $hidden =
        [
            '_token',
        ];

}
