<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ChatMessageSec extends MyModel
{

    use SoftDeletes;

    protected $table = "chat_message_sec";

    protected $fillable =
        [
            'key_entry', 'key_mobile', 'key_source', 'key_source_mobile', 'chat_unique_id'
        ];

    protected $hidden =
        [
            '_token',
        ];
}
