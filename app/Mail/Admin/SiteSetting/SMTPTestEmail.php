<?php

namespace App\Mail\Admin\SiteSetting;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SMTPTestEmail extends Mailable
{
    use Queueable, SerializesModels;


    public function build()
    {
        $setting = getSiteSetting();
        return $this->view('emails.site-setting.test-email')
            ->subject("Test email")
            ->from($setting->mail_from_address, $setting->mail_sender_name);
    }

}
