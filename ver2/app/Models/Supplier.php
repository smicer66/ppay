<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;


class Supplier extends MyModel
{

    use SoftDeletes;

    protected $table = "suppliers";

    protected $fillable =
        [
            'id',
            'supplier_name',
			'supplier_category_id',
            'vat_no',
			'postal_address',
            'contact_address',
			'due_payment_date_type',
            'notes',
			'school_id',
			'bank_id',
			'account_no',
        ];

    protected $hidden =
        [
            '_token',
        ];
		
	function bank() {
        return $this->hasOne(Banks::class, 'id', 'bank_id');
    }

    function supplier_category() {
        return $this->hasOne(SupplierCategory::class, 'id', 'supplier_category_id');
    }

   
}
