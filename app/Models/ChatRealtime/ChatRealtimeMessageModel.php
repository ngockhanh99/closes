<?php

namespace App\Models\ChatRealtime;

use Illuminate\Database\Eloquent\Model;

class ChatRealtimeMessageModel extends Model
{
    protected $table = 'chat_realtime_message';
    protected $fillable = [
        'chat_realtime_id',
        'user_id',
        'table_target_id',
        'content',
    ];

    public function user(){
        return $this->belongsTo('App\Models\Cores\Cores_user', 'user_id');
    }
}
