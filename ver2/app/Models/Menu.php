<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    //
    use SoftDeletes;

    protected $table = 'web_menus';

    protected $fillable =
        [
            'id',
            'school_id',
            'menu_name',
            'created_by_user_id',
            'status',
            'auth'
        ];

    protected $hidden =
        [
            '_token',
        ];

    function menuItems()
    {
        return $this->hasMany(MenuItem::class, 'menu_id', 'id');
    }
}
