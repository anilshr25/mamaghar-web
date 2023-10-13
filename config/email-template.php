<?php
return [
    "roles" => [
        "admin"=>[
            "account_created" => [
                'title' => 'Account Created',
                'identifier' => 'Account has been Created',
                'subject' => 'Account has been Created',
                'accepted_inputs' => ['name'],
                'description' => "<h3 class='title'>Account has been Created</h3>
                                    <p>Hey {{name}},</p>
                                    <p>
                                       Your account has been created for your Next Smart Shopping Account. We're here to help! <br/>
                                    </p>"
            ],
            "password_changed" => [
                'title' => 'Password Changed',
                'identifier' => 'Password Changed',
                'subject' => 'Password Changed',
                'accepted_inputs' => ['name', 'email', 'password'],
                'description' => "
                <h3 class='title'>Password Changed</h3>
                                    <p>Hey {{name}},</p>
                                    <p>
                                        Your password for {{email}} has been changed. <br/>
                                    </p>

                                    <p>
                                        Your New Password is <b>{{password}}</b>
                                    </p>"
            ],
            "password_reset_email" => [
                'title' => 'Password Reset',
                'identifier' => 'Admin - Password Reset',
                'subject' => 'Password Reset',
                'accepted_inputs' => ['name'],
                'description' => "<h3 class='title'>Reset your password</h3>
                                    <p>Hey {{name}},</p>
                                    <p>
                                        We received a request to reset your password for your Next Smart Shopping Account. We're here to help! <br/>
                                        </p>
                                    <p>Simply click on the button to set a new password:
                                    </p>
                                    <p>
                                         {!-link-!}
                                    </p>
                                    <p>If this wasn't you, someone may have mistyped their email address. You can simply ignore this email and no other action is needed
                                        at this moment.</p>"
            ],
            "import_price" => [
                'title' => 'Admin - Product update',
                'identifier' => 'Admin - Product update',
                'subject' => 'Product were updated today',
                'accepted_inputs' => null,
                'description' => "
                                <p>Hi,</p>
                                <p>
                                The product has been update to some change via Excel upload. Please check the updated product details through the <a href='http://admin.nextsmartshopping.com'>NextSmart</a> admin portal. <br/>
                                </p>"
            ],
        ],
        "user" => [
            "welcome_email" => [
                'title' => 'Welcome To Next Smart Shopping',
                'identifier' => 'Welcome To Next Smart Shopping',
                'subject' => 'Welcome To Next Smart Shopping',
                'accepted_inputs' => ['name'],
                'description' => "<p>Hello,&nbsp;{{name}}&nbsp;</p>
                                   <p>It's great that you are now a part of the our family !.
                                   Please make yourself at home and enjoy shopping with us.</p>
                "
            ],
            "verification_email" => [
                'title' => 'Verification Email',
                'identifier' => 'Verification Email',
                'subject' => 'Verification Email',
                'accepted_inputs' => ['name', 'verification_code'],
                'description' => "
                <p>Hello&nbsp;{{name}},&nbsp;</p>
                 <p>This email has been recently entered to verify a new account on NExt Smart Shopping. Please confirm your email, so we know it's really you. </p>
                 <p>Please use the following verification code below or activation link to activate your account. </p>
                 <h4>{{verification_code}}</h4>
                 <p>If you’re having trouble clicking the 'Confirm Email' button, copy and paste the URL below into your web browser:</p>
                 {!-link-!}
                <p>If this wasn't you, someone may have mistyped their email address. Keep this code to yourself and no other action is needed at this moment.</p>"
            ],
            "password_reset" => [
                'title' => 'Password Reset',
                'identifier' => 'Password Reset',
                'subject' => 'Password Reset',
                'accepted_inputs' => ['name', 'email' ,'password'],
                'description' => "
                <p>Hello&nbsp;{{name}},&nbsp;</p>
                 <p>Someone has requested a password reset for the following account:</p>
                 <p>Site: <a>nextsmartshopping.com</a></p>
                 <h5>Email: {{email}}</h5>
                 <h5>Password :{{password}}</h5>"
            ],
            "mfa_disable" => [
                'title' => 'MFA Disabled',
                'identifier' => 'MFA Disabled',
                'subject' => 'MFA Disabled',
                'accepted_inputs' => ['name'],
                'description' => "
                <p>Hello&nbsp;{{name}},&nbsp;</p>
                 <p>Your MFA Authenticator has been disabled. You can now Login.</p>"
            ],
            "email_verification_disable" => [
                'title' => 'Email Verification Disabled',
                'identifier' => 'Email Verification Disabled',
                'subject' => 'Email Verification Disabled',
                'accepted_inputs' => ['name'],
                'description' => "
                <p>Hello&nbsp;{{name}},&nbsp;</p>
                 <p>Your Email Verification has been disabled. You can now Login.</p>"
            ],
        ]
    ],

    'tags' => [
        'link' => '<a class="" href="{{href}}" target="_blank">{{link_text}}</a>',
    ],

];
