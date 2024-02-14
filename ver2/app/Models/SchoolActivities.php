<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolActivities extends Model
{
    //
    use SoftDeletes;
    protected $table = 'school_activities';
    protected $date = 'deleted_at';

}
