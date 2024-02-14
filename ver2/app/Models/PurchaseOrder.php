<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;


class PurchaseOrder extends MyModel
{

    use SoftDeletes;

    protected $table = "purchase_orders";

    protected $fillable =
        [
            'id',
            'document_no',
			'order_no',
            'physical_address',
			'postal_address',
            'vat_reference',
			'delivery_date',
            'discount',
			'school_id',
            'supplier_id',
        ];

    protected $hidden =
        [
            '_token',
        ];
		
	function supplier() {
        return $this->hasOne(Supplier::class, 'id', 'supplier_id');
    }
	
	function purchaseOrderItems() {
        return $this->hasMany(PurchaseOrderItem::class, 'purchase_order_id', 'id');
    }
   
}
