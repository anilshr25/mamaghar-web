<?php

use Illuminate\Support\Facades\Route;

$router->get('/',[\App\Http\Controllers\Front\Index\IndexController::class,'index'])->name('front.index');
$router->get('room',[\App\Http\Controllers\Front\Index\IndexController::class,'room'])->name('front.room');
$router->get('room/{slug}',[\App\Http\Controllers\Front\Index\IndexController::class,'roomDetails'])->name('front.roomdetail');
$router->get('restaurant',[\App\Http\Controllers\Front\Index\IndexController::class,'restaurant'])->name('front.restaurant');
$router->get('news',[\App\Http\Controllers\Front\Index\IndexController::class,'blog'])->name('front.blog');
$router->get('contact',[\App\Http\Controllers\Front\Index\IndexController::class,'contact'])->name('front.contact');
$router->get('about',[\App\Http\Controllers\Front\Index\IndexController::class,'about'])->name('front.about');
$router->get('faq',[\App\Http\Controllers\Front\Index\IndexController::class,'faq'])->name('front.faq');


Route::group(['prefix' => 'user'], function ($router) {

    // Auth and Register
    $router->post('check/verification-enabled', [\App\Http\Controllers\Front\Auth\MFAController::class, 'checkVerificationEnabled']);
    $router->post('login', [\App\Http\Controllers\Front\Auth\LoginController::class, 'login']);
    $router->post('register',[\App\Http\Controllers\Front\Auth\RegisterController::class,'doRegister']);
    $router->post('email-verify', [\App\Http\Controllers\Front\Auth\RegisterController::class, 'verifyUser']);
    $router->post('request/verification-code', [App\Http\Controllers\Front\Auth\MFAController::class,'requestEmailVerificationCode']);
    $router->post('resend/email/verification', [App\Http\Controllers\Front\Auth\RegisterController::class,'resendRegisterVerificationEmail']);

    // MFA
    $router->post('verify/email-verification-code', [\App\Http\Controllers\Front\Auth\MFAController::class, 'verifyEmailVerificationCode']);
    $router->post('verify/mfa-verification-code', [\App\Http\Controllers\Front\Auth\MFAController::class, 'verifyMfaVerificationCode']);

    // $router->get('banner', [\App\Http\Controllers\Front\Banner\BannerController::class, 'index'])->name('front.banner');

    $router->get('slider', [\App\Http\Controllers\Front\Cms\Slider\SliderController::class, 'index'])->name('front.slider');

    $router->get('faq',[\App\Http\Controllers\Front\Cms\Faq\Category\FaqCategoryController::class,'getFaqCategory'])->name('front.getFaqCategory');

    $router->get('notice',[\App\Http\Controllers\Front\Cms\Notice\NoticeController::class,'index'])->name('front.notice');

    $router->get('popup',[\App\Http\Controllers\Front\Cms\PopUp\PopUpController::class,'index'])->name('front.popup');

});
