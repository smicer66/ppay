<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;


class VillageBankGroup extends MyModel
{

    use SoftDeletes;

    protected $table = "village_bank_groups";

    protected $fillable =
        [
            'group_name'
        ];

    protected $hidden =
        [
            '_token',
        ];
}
