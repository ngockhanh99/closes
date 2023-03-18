<?php

namespace App\Models\ChatRealtime;

use Illuminate\Database\Eloquent\Model;

class ChatRealtimeModel extends Model
{
    protected $table = 'chat_realtime';
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'type',
        'title',
        'status',
    ];

    const STATUS_UNREAD = 0;
    const STATUS_READ = 1;

    public function messages(){
        return $this->hasMany(ChatRealtimeMessageModel::class,'chat_realtime_id');
    }

    public function sender(){
        return $this->belongsTo('App\Models\Cores\Cores_user','sender_id');
    }

    public function receiver(){
        return $this->belongsTo('App\Models\Cores\Cores_user','receiver_id');
    }
}
