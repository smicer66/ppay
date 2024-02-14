<?php


namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;


class Lga extends MyModel
{

    use SoftDeletes;

    protected $table = "lgas";

    protected $fillable =
        [
            'lga_name',
            'lga_code',
            'state_id',
            'env',
        ];

    protected $hidden =
        [
            '_token',
        ];

public function state() {
        return $this->hasOne(States::class, 'id', 'state_id');
    }
}