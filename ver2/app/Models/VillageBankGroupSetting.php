<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;


class VillageBankGroupSetting extends MyModel
{

    use SoftDeletes;

    protected $table = "village_bank_group_settings";

    protected $fillable =
        [
            'village_bank_group_id'
        ];

    protected $hidden =
        [
            '_token',
        ];
}
