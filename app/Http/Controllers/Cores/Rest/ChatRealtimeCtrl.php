<?php
namespace App\Http\Controllers\Cores\Rest;

use App\Http\Controllers\RestController;
use App\Models\ChatRealtime\ChatRealtimeModel;
use App\Models\ChatRealtime\ChatRealtimeMessageModel;
use Illuminate\Http\Request;

class ChatRealtimeCtrl extends RestController
{
    public function getDataByUser($id){
        $chats = ChatRealtimeModel::where('sender_id', $id)
                ->orWhere('receiver_id',$id)
                ->orderBy('created_at', 'desc')
                ->get();

        foreach($chats as $chat){
            if($chat->sender_id != $id) $chat->other_chat = MCAUserCtrl::getUserById($chat->sender_id)->getData();
            else $chat->other_chat = MCAUserCtrl::getUserById($chat->receiver_id)->getData();
        }

        return response()->json($chats);
    }

    public function getChatByUserId(Request $request){
        $chat = ChatRealtimeModel::with('messages.user')
            ->where([
                ['sender_id', $request->user_id],
                ['receiver_id', $request->other_id]
            ])->orWhere([
                ['sender_id', $request->other_id],
                ['receiver_id', $request->user_id]
            ])->first();
        
        return response()->json($chat);
    }

    public function getMessageByChatId($chat_id){
        $messages = ChatRealtimeMessageModel::with('user')
                    ->where('chat_realtime_id', $chat_id)
                    ->orderBy('created_at')
                    ->get();
        
        return response()->json($messages);
    }

    public function updateStatus(Request $request){
        $chat = ChatRealtimeModel::find($request->chat_id)
                ->update(['status' => ChatRealtimeModel::STATUS_READ]);
        
        return response()->json($chat);
    }
}