<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendUserPasswordResetJob;
use App\Models\PasswordReset\PasswordReset;
use App\Services\AdminUser\AdminUserService;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '';

    protected $user;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AdminUserService $user)
    {
        $this->user = $user;
    }

    public function login(Request $request)
    {
        if ($this->attemptLogin($request)) {
            $user = auth()->guard('admin')->user();
            $user->token = Str::random('75');
            return response(['user' => $user]);
        } else {
            return response([
                'errors' => ['The provided credentials are incorrect.'],
                'status'=>'NOT_FOUND'
            ], 401);
        }

    }

    public function logout()
    {
        if (auth()->guard('admin')->user()) {
            auth()->guard('admin')->logout();

            return response([
                'status' => 'OK',
                'success' => ['Logout successfully.'],
            ], 200);
        }
        return response([
            'status' => 'OK',
            'success' => ['Logout successfully.'],
        ], 200);
    }

    public function doVerify()
    {
        $user = auth()->guard('admin')->user();
        if (!empty($user)) {
            $user->token = Str::random('75');
            return response(['user' => $user]);
        }
        return response("Unauthorized", 401);
    }

    public function resetPassword(Request $request)
    {
        $user = $this->user->findByColumn('email', $request->get('email'));
        if (empty($user)) {
            return response([
                'msg' => 'If there an account registered with this email, you will shortly receive an email with password reset link.'], 200);
        } else {
            $passwordReset = PasswordReset::whereEmail($user->email)->first();
            if (empty($passwordReset)) {
                $token = getToken('email');
                $resetData['email'] = $user->email;
                $resetData['token'] = $token;
                $passwordReset = PasswordReset::create($resetData);
                $link = $this->passwordResetUrl($passwordReset->token, $passwordReset->email);
                SendUserPasswordResetJob::dispatch($passwordReset, $link)->delay(now()->addSeconds(5));

                return response([
                    'msg' => 'If there an account registered with this email, you will shortly receive an email with password reset link.'], 200);

            } else {
                if (Carbon::now()->diffInMinutes($passwordReset->updated_at) < 3) {
                    return response([
                        'msg' => 'You can retry in next three minutes.'], 200);
                } else {
                    $token = getToken('email');
                    $passwordReset->email = $user->email;
                    $passwordReset->token = $token;
                    $passwordReset->save();
                    $link = $this->passwordResetUrl($passwordReset->token, $passwordReset->email);
                    SendUserPasswordResetJob::dispatch($passwordReset, $link)->delay(now()->addSeconds(5));
                    return response([
                        'msg' => 'If there an account registered with this email, you will shortly receive an email with password reset link.'], 200);
                }
            }
        }
    }

    protected function passwordResetUrl($token, $email)
    {
        $url = env('ADMIN_URL');
        $params = [
            'email' => $email,
            'token' => $token,
        ];
        return  $url . '?' . http_build_query($params);
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }
}

