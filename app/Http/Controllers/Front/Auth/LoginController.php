<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendUserPasswordResetJob;
use App\Models\PasswordReset\PasswordReset;
use App\Services\User\UserService;
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
    public function __construct(UserService $user)
    {
        $this->user = $user;
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        if ($this->attemptLogin($request)) {
            $user = auth()->guard('user')->user();
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
        if (auth()->guard('user')->user()) {
            auth()->guard('user')->logout();

            return response([
                'success' => ['Logout successfully.'],
            ], 204);
        }
    }

    public function doVerify()
    {
        $user = auth()->guard('user')->user();
        if (!empty($user)) {
            $user->token = Str::random('75');
            return response(['data' => $user]);
        }
        return response("UnAuthorized",401);

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
        $url = env('USER_URL');
        $params = [
            'email' => $email,
            'token' => $token,
        ];
        return  $url . '?' . http_build_query($params);
    }

    public function username()
    {
        $field = (filter_var(request()->email, FILTER_VALIDATE_EMAIL) || !request()->email) ? 'email' : 'mobile_no';
        request()->merge([$field => request()->email]);
        return $field;
    }

    protected function guard()
    {
        return Auth::guard('user');
    }
}
