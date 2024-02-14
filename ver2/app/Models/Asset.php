<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;


class Asset extends MyModel
{

    use SoftDeletes;

    protected $table = "assets";

    protected $fillable =
        [
            'id',
            'asset_category_id',
			'location_id',
            'serial_number',
			'bought_from',
            'date_bought',
			'purchase_price',
            'replacement_value',
            'status',
            'selling_price',
			'school_id'
        ];

    protected $hidden =
        [
            '_token',
        ];

    function assetCategory() {
        return $this->hasOne(AssetCategory::class, 'id', 'asset_category_id');
    }

    function location() {
        return $this->hasOne(AssetLocation::class, 'id', 'location_id');
    }
}
