<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;


class Classes extends MyModel
{

    use SoftDeletes;

    protected $table = "classes";

    protected $fillable =
        [
            'name',
            'class_type',
            'class_level',
        ];

    protected $hidden =
        [
            '_token',
        ];

    function class_arm() {
        return $this->hasMany(ClassArms::class, 'class_id', 'id');
    }
}
