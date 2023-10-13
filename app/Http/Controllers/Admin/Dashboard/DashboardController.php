<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\AdminUser\AdminUserService;
use App\Services\User\UserService;

class DashboardController extends Controller
{
    protected $adminUser;
    protected $user;
    protected $brand;
    protected $category;
    protected $store;
    protected $product;

    public function __construct(AdminUserService $adminUser, UserService $user) {
        $this->adminUser = $adminUser;
        $this->user = $user;
    }


    public function getAllStats()
    {
        return [
            'admin_user_count'=>$this->adminUser->findByColumns(['is_active'=>'1'], true, false)->count(),
            'user_count'=>$this->user->findByColumns(['is_active'=>'1'], true, false)->count(),
        ];
    }
}
