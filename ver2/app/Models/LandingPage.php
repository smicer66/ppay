<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LandingPage extends Model
{
    //
    use SoftDeletes;

    protected $table = 'landing_pages';

    protected $fillable =
        [
            'id',
            'created_by',
            'school_id'
        ];

    protected $hidden =
        [
            '_token',
        ];

    function user()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }
}
