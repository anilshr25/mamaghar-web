<?php

namespace App\Models\Log;

use App\Models\AdminUser\AdminUser;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $appends = ['formatted_log_date', 'action_text', 'compared_data', 'agent', 'admin_user', 'formatted_before_data', 'formatted_after_data'];

    public function getFormattedLogDateAttribute(){
        return formatDate($this->log_date);
    }

    public function getActionTextAttribute(){
        if($this->log_type == 'edit'){
            return 'Edit';
        }
        if($this->log_type == 'delete'){
            return 'Delete';
        }
        if($this->log_type == 'login'){
            return 'Login';
        }

        return null;
    }

    public function getAgentAttribute(){
        return $this->agent()->get();
    }

    public function getAdminUserAttribute(){
        return $this->admin_user()->get();
    }

    public function getFormattedBeforeDataAttribute(){
        return((array)json_decode($this->before_data));
    }

    public function getFormattedAfterDataAttribute(){
        return((array)json_decode($this->after_data));
    }

    public function getComparedDataAttribute(){
        if(($this->log_type == 'create')){
            return compareLogData($this->before_data, $this->before_data);
        }
        return compareLogData($this->before_data, $this->after_data);
    }

    function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    function admin_user()
    {
        return $this->belongsTo(AdminUser::class,'admin_user_id');
    }

}
