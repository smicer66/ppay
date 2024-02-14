<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;


class Transaction extends MyModel
{

    use SoftDeletes;

    protected $table = "transactions";

    
    protected $hidden =
        [
            '_token',
        ];

   
}
