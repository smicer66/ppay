<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ChatMessage extends MyModel
{

    use SoftDeletes;

    protected $table = "chat_messages";

    protected $fillable =
        [
            'message_string_body', 'message_contents', 'message_parent_id', 'message_parent_substring', 'message_uid'
        ];

    protected $hidden =
        [
            '_token',
        ];
}
