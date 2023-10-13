<?php

namespace App\Http\Resources\User\Notification;

use Illuminate\Http\Resources\Json\JsonResource;

class UserNotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $resource = [
            'id' => $this->id,
            'content' => $this->content,
            'email_content_url' => $this->email_content_url,
            'date_sent' => $this->date_sent,
            'formatted_date_sent' => !empty($this->date_sent) ? formatDate($this->date_sent) : null,
            'formatted_time' => !empty($this->date_sent) ? formatDate($this->date_sent, 'h:i A') : null,
            'user_id' => $this->user_id,
            'user' => $this->user->full_name ?? null,
            'symbol_label' => $this->user->symbol_label ?? null,
            'candidate_id' => $this->candidate_id,
            'candidate_exam_key' => $this->candidate->exam_key ?? null,
            'title' => $this->title,
            'admin_user_id' => $this->admin_user_id,
            'score_id' => $this->score_id,
            'payload' => $this->payload,
            'url' => $this->url,
            'type' => $this->type,
            'is_published' => $this->is_published,
            'is_viewed' => $this->is_viewed,
            'is_active' => $this->is_active,
            'status' => getBadgeByStatus($this->is_active),
            'sent_by' => $this->sent_by,
            'sentBy' => $this->sentBy->full_name ?? null,
            'admin_full_name' => $this->admin->full_name ?? null,

        ];
        if($request->route()->getName()=='user.notification'){
            unset($resource['email_content_url']);
            $resource['email_content_url'] = $this->user_email_content_url;
        }

        return $resource;
    }
}
