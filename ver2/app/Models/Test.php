<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
     use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'test';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['datatest'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
	
}
