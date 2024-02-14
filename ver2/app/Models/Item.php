<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;


class Item extends MyModel
{

    use SoftDeletes;

    protected $table = "items";

    protected $fillable =
        [
            'id',
            'item_name',
			'item_category_id',
            'type',
			'image_file',
            'item_code',
			'school_id',
        ];

    protected $hidden =
        [
            '_token',
        ];
		
	function itemCategory() {
        return $this->hasOne(ItemCategory::class, 'id', 'item_category_id');
    }

   
}
