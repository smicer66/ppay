<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GradingScheme extends Model
{
    //
    use SoftDeletes;
    protected $table = 'grading_scheme';
    protected $date = 'deleted_at';
}
