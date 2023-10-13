<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserRegistration\UserRegistrationRequest;
use App\Jobs\Front\Auth\SendUserVerificationJob;
use App\Jobs\Front\WelcomeUserJob;
use App\Services\User\UserService;
use App\Services\User\Verification\UserVerificationService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    protected $user;
    protected $userVerification;

    function __construct(UserService $user, UserVerificationService $userVerification)
    {
        $this->user = $user;
        $this->userVerification = $userVerification;
    }

    function checkEmail(Request $request)
    {
        $user = $this->user->findByColumn('email',$request->email);
        if($user)
            return response(['status' => "ERROR"], 500);

        return response(['status' => "OK"], 200);

    }

    function doRegister(UserRegistrationRequest $request)
    {
        $data = $request->all();
        $user = $this->user->register($data);
        if ($user) {
            $settings['user_id']= $user->id;
            $userVerification['user_id'] = $user->id;
            $userVerification['token'] = getToken('email');
            $userVerification['verification_code'] = getToken('code');
            $userVerification['is_used'] = 0;
            if ($userVerification = $this->userVerification->create($userVerification)) {
                $verificationURL = $this->verificationURL($userVerification->token, $userVerification->verification_code);
                SendUserVerificationJob::dispatch($user,$userVerification, $verificationURL);
                return response(['status' => "OK"], 200);
            }
        }
        else
        {
            return response(['status'=>'ERROR'], 500);
        }

    }

    protected function verifyUser(Request $request)
    {
        $fields = array_keys($request->except('is_email_authentication_enabled'));
        $verification = $this->userVerification->findByColumns($fields, $request->all());

        if (empty($verification) || $verification->updated_at->addMinutes(20) < Carbon::now()) {
            return response([
                'status' => 'ERROR',
                'message' => 'Oops looks like your verification code is not valid.',
            ], 500);
        } else {
            $user = $verification->user;
            if($request->is_email_authentication_enabled)
                $user->is_email_authentication_enabled = 1;
            $user->is_active = 1;
            $user->is_login_verified = 1;
            $user->save();
            $verification->delete();
            $name = $user->name;
            $email = $user->email;
            WelcomeUserJob::dispatch($name, $email);
            return response([
                'status' => 'OK'
            ], 200);

        }

    }

    public function resendRegisterVerificationEmail(Request $request)
    {
        $user = $this->user->findByColumn('email', $request->get('email'));
        if(empty($user)) {
            return response([
                'status' => 'ERROR',
                'message' => 'This Email is not Registered Yet'], 500);
        }

        if (!empty($user) && $user->is_login_verified != 1) {
            $userVerification = $this->userVerification->findByColumn('user_id', $user->id);
            if (empty($userVerification)) {
                $userVerification['user_id'] = $user->id;
                $userVerification['token'] = getToken('email');
                $userVerification['verification_code'] = getToken('code');
                $userVerification['is_used'] = 0;
                if ($userVerification = $this->userVerification->create($userVerification)) {

                    $verificationURL = $this->verificationURL($userVerification->token, $userVerification->verification_code);
                    SendUserVerificationJob::dispatch($user,$userVerification, $verificationURL);
                    return response([
                        'status' => 'OK',
                        'message' => 'Verification mail sent. Please Check Your Email.'], 200);
                }
            } else {
                if (Carbon::now()->diffInMinutes($userVerification->updated_at) < 3) {
                    return response([
                        'status' => 'OK',
                        'message' => 'We have sent you an Email. please wait for few minutes.'], 200);
                } else {
                    $userVerification->token = getToken('email');
                    $userVerification['user_id'] = $user->id;
                    $userVerification->verification_code = getToken('code');
                    $userVerification->is_used = 0;
                    $userVerification->save();
                    $verificationURL = $this->verificationURL($userVerification->token, $userVerification->verification_code);
                    SendUserVerificationJob::dispatch($user,$userVerification, $verificationURL);
                    return response([
                        'status' => 'OK',
                        'message' => 'Verification Mail Sent. Please Check your Email.'], 200);
                }
            }
        } else {
            return response([
                'status' => 'ERROR',
                'message' => 'Your Email is already Verified.Please Login'], 500);
        }
    }

    protected function verificationURL($token, $code)
    {
        $url = env('USER_URL');
        $params = [
            'code' => $code,
            'token' => $token,
        ];
        return  $url . '?' . http_build_query($params);
    }

}
