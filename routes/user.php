<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'user' ,'prefix' => 'user'], function ($router) {

    // Current User
    $router->get('doVerify', [\App\Http\Controllers\Front\Auth\LoginController::class, 'doVerify']);

    // Auth and Register
    $router->get('logout', [\App\Http\Controllers\Front\Auth\LoginController::class, 'logout']);

    // MFA and Verify Email
    $router->post('do-reset/password', [\App\Http\Controllers\Front\Auth\LoginController::class, 'resetPassword']);
    $router->get('get/mfa-authenticator',[\App\Http\Controllers\Front\Auth\MFAController::class,'getMfaAuthenticatorCode']);
    $router->post('verify/mfa-verification-code', [\App\Http\Controllers\Front\Auth\MFAController::class, 'verifyMfaVerificationCode']);
    $router->post('activate/mfa-authenticator',[\App\Http\Controllers\Front\Auth\MFAController::class,'activateMfaAuthenticator']);
    $router->post('deactivate/mfa-authenticator', [\App\Http\Controllers\Front\Auth\MFAController::class, 'deactivateMfaAuthenticator']);
    $router->post('activate/email-authenticator', [\App\Http\Controllers\Front\Auth\MFAController::class, 'activateEmailAuthenticator']);
    $router->post('deactivate/email-authenticator', [\App\Http\Controllers\Front\Auth\MFAController::class, 'deactivateEmailAuthenticator']);
});
