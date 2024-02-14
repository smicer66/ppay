<?php

namespace App\Models;

class SchoolBanks extends MyModel
{

    function bank() {
        return $this->hasOne(Banks::class, 'id', 'bank_id');
    }
}
