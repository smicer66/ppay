<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;


class SmsLog extends MyModel
{

    use SoftDeletes;

    protected $table = "sms_logs";

    protected $fillable =
        [
            'id',
            'receipient_no',
            'response',
            'message',
            'school_id'
        ];

    protected $hidden =
        [
            '_token',
        ];

	
	
	function school(){
        return $this->hasOne(Schools::class, 'id', 'school_id');
    }
}
