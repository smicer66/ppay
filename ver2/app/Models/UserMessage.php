<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserMessage extends Model
{
    //
    use SoftDeletes;

    protected $table = "user_messages";

    protected $date = "deleted_at";
	
	function sender()
    {
        return $this->hasOne(User::class, 'id', 'source_user_id');
    }


    function previousmsg()
    {
        return $this->hasOne(Message::class, 'id', 'parent_msg_id');
    }

}
