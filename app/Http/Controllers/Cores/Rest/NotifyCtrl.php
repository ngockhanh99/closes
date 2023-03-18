<?php

namespace App\Http\Controllers\Cores\Rest;

use App\Events\NewNotification;
use App\Http\Requests\NotificationRequest;
use App\Models\Cores\Cores_Media;
use App\Models\Cores\Cores_ou;
use App\Models\Cores\Cores_user;
use App\Models\Cores\Cores_user_meta;
use App\Notifications\CreatePost;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\RestController;

class NotifyCtrl extends RestController
{

    public function __construct()
    {

    }

    // Thêm thông báo
    public function insert(NotificationRequest $request)
    {
        $content      = $request->input('content');
        $listFile     = $request->input('files');
        $listOu       = $request->input('ou_ids');
        //lấy danh sách người dùng thuộc các đơn vị trong $listOu
        $listAllUsers  = Cores_user::makeInstance()->whereIn('ou_id', $listOu)->pluck('id')->all();
        $listUser      = array_unique((array)$listAllUsers);
        $listUserFinal = array_diff($listUser, (array)\Auth::user()->id); //loại bỏ người tạo khỏi danh sách người nhận thông báo
        foreach ($listUserFinal as $user_id) {
            event(new NewNotification($user_id, Auth::user()->user_name . ' đã gửi 1 thông báo: ' .  $content));
        }
        Notification::send(Cores_user::find($listUserFinal), new CreatePost($content, $listFile, $listOu, uniqid()));
    }

    //Lấy thông báo chưa đọc
    public function getAllUnread()
    {
        $allnotify = Cores_user::find(Auth::user()->id)->unreadNotifications()->get();
        foreach (@$allnotify as $notify) {
            $notify->files = Cores_Media::find($notify->data['file']);
            foreach ($notify->files as &$files) {
                $files->user_name = Cores_user::find($files->user_id)->user_name;
            }
            $notify->created_by_username = Cores_user::find($notify->created_by)->user_name;
        }
        return $allnotify;
    }

    //Lấy tất cả thông báo
    public function getAll()
    {
        $allnotify = Cores_user::find(Auth::user()->id)->notifications()->paginate();
        foreach (@$allnotify as $notify) {
            $notify->files = Cores_Media::find($notify->data['file']);
            foreach ($notify->files as &$files) {
                $files->user_name = Cores_user::find($files->user_id)->user_name;
            }
            $notify->created_by_username = Cores_user::find($notify->created_by)->user_name;
        }

        foreach (Cores_user::find(Auth::user()->id)->unreadNotifications as $notification) {
            $notification->markAsRead();
        }
        return $allnotify;
    }

    //Đánh dấu thông báo đã đọc
    public function markNotifyAsRead($notify_id)
    {
        Cores_user::find(Auth::user()->id)->unreadNotifications()->whereIn('id', (array)$notify_id)->get()->markAsRead();
    }

    // Lấy danh sách thông báo đã gửi
    public function getAllNotifySent()
    {
        $allnotify = \App\Models\NotificationModel::where('created_by', Auth::user()->id)->distinct('notify_id')->get(['notify_id', 'data', 'created_at', 'created_by']);
        foreach (@$allnotify as $notify) {
            if (json_decode($notify->data)->file) {
                $notify->files = Cores_Media::find(json_decode($notify->data)->file);
                foreach ($notify->files as &$files) {
                    $files->user_name = Cores_user::find($files->user_id)->user_name;
                }
            } else {
                $notify->files = [];
            }
            $notify->created_by_username = Cores_user::find($notify->created_by)->user_name;
            $notify->content             = json_decode($notify->data)->content;
        }
        return $allnotify;
    }

}
