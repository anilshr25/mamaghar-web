<?php

namespace App\Http\Controllers\Admin\User\Notification;

use App\Http\Controllers\Controller;
use App\Services\User\Notification\UserNotificationService;
use Illuminate\Http\Request;

class UserNotificationController extends Controller
{
    protected $userNotification;

    public function __construct(UserNotificationService $userNotification) {
        $this->userNotification = $userNotification;
    }

    public function markAsRead(Request $request, $userNotificationId){
        $request->merge(['is_viewed' => 1]);
        $userNotification = $this->userNotification->update($userNotificationId, $request->only(['is_viewed']));
        if ($userNotification){
            $userNotification = $this->userNotification->find($userNotificationId);
            return redirect()->to($userNotification->url);
        }
        return response(['status' => 'ERROR','errors'=>'Problem occurred.'], 200);
    }

    public function markAsViewed(Request $request, $userNotificationId){
        $request->merge(['is_viewed' => 1]);
        $userNotification = $this->userNotification->update($userNotificationId, $request->only(['is_viewed']));
        if ($userNotification){
            $userNotification = $this->userNotification->find($userNotificationId);
            return response(['status' => 'success','message'=>'Marked as read'], 200);
        }
        return response(['status' => 'ERROR','errors'=>'Something went wrong'], 200);
    }

    public function markAsNotViewed($userNotificationId){
        $data = [
            'is_viewed' => 0
        ];
        $userNotification = $this->userNotification->update($userNotificationId, $data);
        if ($userNotification){
            $userNotification = $this->userNotification->find($userNotificationId);
            return response(['status' => 'success','message'=>'Marked as read'], 200);
        }
        return response(['status' => 'ERROR','errors'=>'Something went wrong'], 200);
    }

    public function getAllByUser(Request $request, $id)
    {
        $notifications = $this->userNotification->getAllByUser(10, $request, $id);
        return $notifications;
    }

    public function showEmail($id)
    {
        $notification = $this->userNotification->find($id);
        $content = $notification->content;
        return view('emails.email',compact('content'));
    }

    public function getAdminNotifications(Request $request, $adminUserId){
        $user = auth()->user();
        $notifications = $this->userNotification->getAdminNotifications($request, $adminUserId, 15, $user);
        return $notifications;
    }

    public function getAdminNotificationsCount(Request $request, $adminUserId){
        $user = auth()->user();
        $userNotificationsCount = $this->userNotification->getAdminNotificationsCount($request, $adminUserId, $user);
        return $userNotificationsCount;
    }

    public function show($id)
    {
        if ($userNotification = $this->userNotification->find($id))
            return response(['status' => "OK", 'userNotification' => $userNotification], 200);
        return response(['status' => 'ERROR'], 200);
    }
}
