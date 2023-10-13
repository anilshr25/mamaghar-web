<?php

namespace App\Jobs;

use App\Mail\SendUserPasswordResetMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendUserPasswordResetJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $passwordReset;
    protected $link;
    protected $admin_user;

    public function __construct($passwordReset,$link)
    {
        $this->passwordReset = $passwordReset;
        $this->link = $link;
        $this->admin_user = $passwordReset->admin_user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $emailTemplate = getEmailTemplate('admin','password_reset_email');
        $acceptedData = [
            "name" => !empty($this->admin_user) ? $this->admin_user->name : null,
            "href" => !empty($this->link) ? $this->link : null,
            "link_text" => 'Reset your password',
        ];

        /*Tags that needs to be rendered*/
        $acceptedTag = ['link'];
        /*Tags that needs to be rendered*/

        /*Append Tag Data to HTML*/
        $acceptedInputs = explode(',', $emailTemplate->accepted_inputs);
        array_push($acceptedInputs,'href');
        array_push($acceptedInputs,'link_text');
        /*Append Tag Data to HTML*/

        $content = renderEmailHTML($emailTemplate->description, $acceptedTag);
        $content = renderEmailData($content,$acceptedInputs, $acceptedData);

        Mail::to($this->passwordReset->email)->send(new SendUserPasswordResetMail($content, $emailTemplate));
    }


}
