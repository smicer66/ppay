<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;


class SupplierCategory extends MyModel
{

    use SoftDeletes;

    protected $table = "supplier_categories";

    protected $fillable =
        [
            'id',
            'supplier_category_name',
			'school_id',
        ];

    protected $hidden =
        [
            '_token',
        ];

   
}
