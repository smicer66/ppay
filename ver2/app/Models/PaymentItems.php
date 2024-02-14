<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentItems extends MyModel
{
    use SoftDeletes;
    protected $fillable = ['id', 'name', 'desc', 'is_tuition', 'school_id'];

}
