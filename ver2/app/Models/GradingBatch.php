<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradingBatch extends Model
{
    protected $table = 'grading_batch';
	
	public function gradingScores()
    {
        return $this->hasMany(GradingScore::class,'batch_id', 'id');
    }
	
	public function subject()
    {
        return $this->hasOne(Subjects::class,'batch_id', 'id');
    }
}
