<?php

namespace App\Console\Commands\SiteSetting;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class SetStmpCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:set-stmp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (config('app.env') != 'local') {
            $setting = getSiteSetting();
            Config::set('mail.mailers.smtp.driver', $setting->mail_driver);
            Config::set('mail.mailers.smtp.host', $setting->mail_host);
            Config::set('mail.mailers.smtp.port', $setting->mail_port);
            Config::set('mail.mailers.smtp.encryption', $setting->mail_encryption);
            Config::set('mail.mailers.smtp.username', $setting->mail_user_name);
            Config::set('mail.mailers.smtp.password', $setting->mail_password);
        }

    }
}
