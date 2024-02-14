<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;


class AssetCategory extends MyModel
{

    use SoftDeletes;

    protected $table = "asset_categories";

    protected $fillable =
        [
            'id',
            'category_name',
			'school_id'
        ];

    protected $hidden =
        [
            '_token',
        ];

}
