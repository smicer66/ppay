<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserMessageReceipient extends Model
{
    //
    use SoftDeletes;

    protected $table = "user_messages_receipients";

    protected $date = "deleted_at";
	
	function user_message()
    {
            return $this->hasOne(UserMessage::class, 'id', 'user_messages_id');
    }


    function receipient_user()
    {
        return $this->hasOne(User::class, 'id', 'recipient_user_id');
    }

}
