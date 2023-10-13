<?php

namespace App\Jobs\Admin;

use App\Mail\Admin\AdminUserAccountCreatedMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class AdminUserAccountCreatedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $admin_user;
    public function __construct($user)
    {
        $this->admin_user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $emailTemplate = getEmailTemplate('admin','account_created');
        $acceptedData = [
            "name" => !empty($this->admin_user) ? $this->admin_user->name : null,
        ];

        /*Tags that needs to be rendered*/
        $acceptedTag = [];
        /*Tags that needs to be rendered*/

        /*Append Tag Data to HTML*/
        $acceptedInputs = explode(',', $emailTemplate->accepted_inputs);
        /*Append Tag Data to HTML*/

        $content = renderEmailHTML($emailTemplate->description, $acceptedTag);
        $content = renderEmailData($content,$acceptedInputs, $acceptedData);

        Mail::to($this->admin_user->email)->send(new AdminUserAccountCreatedMail($content, $emailTemplate));
    }
}
