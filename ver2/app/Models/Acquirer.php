<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Acquirer extends MyModel
{
    use SoftDeletes;

    protected $table = 'acquirer';
    protected $date = 'deleted_at';



    public function bank()
    {
        return $this->hasOne(Banks::class, 'id', 'bank_id');
    }
}
