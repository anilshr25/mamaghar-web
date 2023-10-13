<?php

namespace Database\Seeders;

use App\Models\AdminUser\AdminUser;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            [
                'first_name'=>'Super',
                'last_name'=>'Admin',
                'last_name'=>'Admin',
                'email' => 'admin@homestay.com',
                'image' => '',
                'password' => bcrypt('Forgot911!'),
                'address_line_1' => 'Tusal',
                'mobile_no' => '9849627149',
                'user_type' => 'admin',
                'is_mfa_enabled' => 0,
                'is_email_authentication_enabled' => 0,
                'mfa_secret_code' => null,
                'mfa_authentication_image' => null,
                'is_active' => 1
            ]
        ];

        foreach ($datas as $data){
            AdminUser::insert($data);
        }
    }
}
