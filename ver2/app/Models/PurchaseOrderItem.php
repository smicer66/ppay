<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;


class PurchaseOrderItem extends MyModel
{

    use SoftDeletes;

    protected $table = "purchase_order_items";

    protected $fillable =
        [
            'id',
            'purchase_order_id',
			'item_id',
            'description',
			'unit',
            'quantity',
			'vat_percent',
            'discount',
			'vat_amount',
            'school_id',
        ];

    protected $hidden =
        [
            '_token',
        ];
		
	function purchaseOrder() {
        return $this->hasOne(PurcaseOrder::class, 'id', 'purchase_order_id');
    }
	
	function item() {
        return $this->hasOne(Item::class, 'id', 'item_id');
    }
   
}
