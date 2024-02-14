<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;


class Invoice extends MyModel
{

    use SoftDeletes;

    protected $table = "supplier_invoices";

    protected $fillable =
        [
            'id',
            'purchase_order_id',
			'supplier_id',
            'document_no',
			'invoice_no',
            'due_date',
			'school_id',
            'message',
        ];

    protected $hidden =
        [
            '_token',
        ];
		
	function purchaseOrder() {
        return $this->hasOne(PurchaseOrder::class, 'id', 'purchase_order_id');
    }

    function supplier() {
        return $this->hasOne(Supplier::class, 'id', 'supplier_id');
    }

    function invoiceItems() {
        return $this->hasMany(InvoiceItem::class, 'invoice_id', 'id');
    }
   
}
