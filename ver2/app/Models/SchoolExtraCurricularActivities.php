<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolExtraCurricularActivities extends Model
{
    use SoftDeletes;

    protected $table = 'school_extracurricular_activities';
}
