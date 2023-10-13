<?php

namespace App\Models\User\Notification;

use App\Models\AdminUser\AdminUser;
use App\Models\User\User;
use App\Services\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserNotification extends Model
{
    use HasFactory, SoftDeletes, Loggable;

    protected $exportFilePath = 'uploads/exports';

    protected $fillable = [
        'content',
        'date_sent',
        'user_id',
        'title',
        'admin_user_id',
        'payload',
        'url',
        'type',
        'is_published',
        'is_viewed',
        'is_active',
        'sent_by',
        'email_sent_to'
    ];

    protected $appends = ['export_file_path', 'email_content_url', 'user_email_content_url'];

    public function getEmailContentUrlAttribute()
    {
        return route('show.email', $this->id);
    }

    public function getUserEmailContentUrlAttribute()
    {
        return route('user.email.show', encryptData($this->id));
    }

    function getExportFilePathAttribute()
    {
        return asset(''.$this->exportFilePath.'/'.$this->url);
    }

    public function user() {
      return $this->belongsTo(User::class, 'user_id');
    }

    public function sentBy() {
      return $this->belongsTo(AdminUser::class, 'sent_by');
    }

    public function admin() {
      return $this->belongsTo(AdminUser::class, 'admin_user_id');
    }
}

