<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;


class ItemPurchased extends MyModel
{

    use SoftDeletes;

    protected $table = "item_purchased";

    

    protected $hidden =
        [
            '_token',
        ];
		

   
}
