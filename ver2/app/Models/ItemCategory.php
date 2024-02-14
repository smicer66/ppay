<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;


class ItemCategory extends MyModel
{

    use SoftDeletes;

    protected $table = "item_categories";

    protected $fillable =
        [
            'id',
            'item_category_name',
			'school_id',
        ];

    protected $hidden =
        [
            '_token',
        ];
   
}
