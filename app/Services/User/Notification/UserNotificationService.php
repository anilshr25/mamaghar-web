<?php

namespace App\Services\User\Notification;

use App\Http\Resources\User\Notification\UserNotificationResource;
use App\Models\User\Notification\UserNotification;

class UserNotificationService
{
    protected $userNotification;

    public function __construct(
        UserNotification $userNotification
    )
    {
        $this->userNotification = $userNotification;
    }

    public function create(array $data)
    {
        try {
            return $this->userNotification->create($data);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function paginate(array $filter = [])
    {
        $filter['limit'] = 25;
        if (auth()->user()->user_type == 'state')
            return $this->userNotification->whereStateId(auth()->user()->state->id)->orderBy('id','DESC')->paginate($filter['limit']);

        return $this->userNotification->whereNull('state_id')->orderBy('id','DESC')->paginate($filter['limit']);
    }

    public function all()
    {
        return $this->userNotification->all();
    }

    public function getAllByUser($limit, $request, $id)
    {
        $userNotifications = $this->userNotification->where('user_id', $id)->where(function ($query) use ($request) {
            if ($request->filled('title')) {
                $query->where('title', 'like', '%' . $request->title . '%');
            }
            if ($request->filled('date_sent')) {
                $query->whereDate('date_sent', $request->date_sent);
            }
        })->orderBy('id','DESC')->paginate($limit);

        return UserNotificationResource::collection($userNotifications);
    }

    public function getAdminNotifications($request, $adminUserId, $limit, $user = null){
        $userNotifications = $this->userNotification->where('type', '!=', 'email')
            ->where(function ($query) use ($request) {
                if (isset($request->is_not_viewed)) {
                    $query->where('is_viewed', 0);
                }
                if (isset($request->title)) {
                    $query->where('title', 'like', '%' . $request->title . '%');
                }
                if(isset($request->start_date) && isset($request->end_date)){
                    $query->whereBetween('date_sent', [$request->start_date.' 00:00:00', $request->end_date.' 23:59:59']);
                }
            })->where('admin_user_id', $adminUserId)->where('is_published', 1)->orWhere('type', 'note');

            if ($user && $user->access_type=='score')
                $userNotifications = $userNotifications->whereScoreId($user->score_id);

            $userNotifications = $userNotifications->orderBy('id','DESC')->paginate($limit);

        return UserNotificationResource::collection($userNotifications);
    }

    public function getAdminNotificationsCount($request, $adminUserId, $user = null) {
        $userNotificationsCount = $this->userNotification->where('type', '!=', 'email')->where(function ($query) use ($request) {
                if (isset($request->is_not_viewed)) {
                    $query->where('is_viewed', 0);
                }
            })->where('admin_user_id', $adminUserId)->where('is_published', 1)->orWhere('type', 'note');;

            if ($user && $user->access_type=='score')
               $userNotificationsCount = $userNotificationsCount->whereScoreId($user->score_id);

            $userNotificationsCount = $userNotificationsCount->orderBy('id','DESC')->count();

        return $userNotificationsCount;
    }

    public function find($userNotificationId)
    {
        try {
            $userNotification = $this->userNotification->find($userNotificationId);
            return new UserNotificationResource($userNotification);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function update($userNotificationId, array $data)
    {
        try {
            $userNotification = $this->userNotification->find($userNotificationId);

            $userNotification = $userNotification->update($data);

            return $userNotification;
        } catch (\Exception $e) {
            //$this->logger->error($e->getMessage());
            return false;
        }
    }

    public function delete($userNotificationId)
    {
        try {
            $userNotification = $this->userNotification->find($userNotificationId);

            return $userNotification->delete();

        } catch (\Exception $e) {
            return false;
        }
    }

    public function publishNotification($id)
    {
        $data['is_published'] = true;
        return $this->notification->whereId($id)->update($data);
    }

    public function publishNotifications($ids)
    {
        $data['is_published'] = true;
        return $this->userNotification->whereIn('id', $ids)->update($data);
    }

    public function viewNotification($id)
    {
        $data['is_viewed'] = true;
        return $this->userNotification->where('id', $id)->update($data);
    }

    public function getByUser($limit, $request, $user)
    {
        $userNotifications = $this->userNotification->where('user_id', $user->id)->where('type', 'email')->where(function ($query) use ($request) {
            if ($request->filled('title')) {
                $query->where('title', 'like', '%' . $request->title . '%');
            }
            if ($request->filled('date_sent')) {
                $query->whereDate('date_sent', $request->date_sent);
            }
        })->orderBy('created_at','DESC')->paginate($limit);

        return UserNotificationResource::collection($userNotifications);
    }

    public function getByUserId($id, $userId)
    {

        $userNotification =  $this->userNotification->whereId($id)->whereUserId($userId)->first();
        if($userNotification) {
            return $userNotification;
        }
        return null;
    }
}
