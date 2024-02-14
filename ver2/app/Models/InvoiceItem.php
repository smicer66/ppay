<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;


class InvoiceItem extends MyModel
{

    use SoftDeletes;

    protected $table = "invoice_items";

    protected $fillable =
        [
            'id',
            'invoice_id',
			'item_id',
            'description',
			'unit',
            'quantity',
            'discount',
			'vat_amount',
            'school_id',
        ];

    protected $hidden =
        [
            '_token',
        ];
		
	function invoice() {
        return $this->hasOne(Invoice::class, 'id', 'invoice_id');
    }
	
	function item() {
        return $this->hasOne(Item::class, 'id', 'item_id');
    }
   
}
