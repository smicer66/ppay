<?php


namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;


class TempHolder extends MyModel
{

    use SoftDeletes;

    protected $table = "temp_holders";

    protected $fillable =
        [
            'details',
        ];

    protected $hidden =
        [
            '_token',
        ];

}