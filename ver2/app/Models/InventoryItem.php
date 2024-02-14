<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;


class InventoryItem extends MyModel
{

    use SoftDeletes;

    protected $table = "inventory_items";

    protected $fillable =
        [
            'id',
            'item_id',
			'quantity',
            'unit_price',
			'vat',
            'discount',
            'sundry_charges',
            'school_id',
        ];

    protected $hidden =
        [
            '_token',
        ];
	
	function item() {
        return $this->hasOne(Item::class, 'id', 'item_id');
    }
   
}
