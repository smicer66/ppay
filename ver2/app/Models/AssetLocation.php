<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;


class AssetLocation extends MyModel
{

    use SoftDeletes;

    protected $table = "asset_locations";

    protected $fillable =
        [
            'id',
            'location_name',
			'school_id'
        ];

    protected $hidden =
        [
            '_token',
        ];

}
