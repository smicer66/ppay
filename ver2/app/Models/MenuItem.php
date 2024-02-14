<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuItem extends Model
{
    //
    use SoftDeletes;

    protected $table = 'web_menu_items';

    protected $fillable =
        [
            'id',
            'school_id',
            'menu_id',
            'created_by_user_id',
            'menu_item_name',
            'parent_item_id',
            'feature',
            'featureId',
            'url',
            'item_auth'
        ];

    protected $hidden =
        [
            '_token',
        ];

    function parentMenuItem()
    {
        return $this->hasOne(MenuItem::class, 'id', 'parent_item_id');
    }
	
	function childMenuItem()
    {
        return $this->hasMany(MenuItem::class, 'parent_item_id', 'id');
    }
}
