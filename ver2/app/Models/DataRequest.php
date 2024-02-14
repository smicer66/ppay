<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;


class DataRequest extends MyModel
{

    use SoftDeletes;

    protected $table = "data_requests";


    protected $hidden =
        [
            '_token',
        ];
		
   
}
