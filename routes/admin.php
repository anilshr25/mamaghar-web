<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('admin/check/verification-enabled', [\App\Http\Controllers\Admin\Auth\MFAController::class, 'checkVerificationEnabled']);
Route::post('admin/request/verification-code', [\App\Http\Controllers\Admin\Auth\MFAController::class, 'requestEmailVerificationCode']);
Route::post('admin/login', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'login']);
Route::post('admin/verify/email-verification-code', [\App\Http\Controllers\Admin\Auth\MFAController::class, 'verifyEmailVerificationCode']);
Route::post('admin/verify/mfa-verification-code', [\App\Http\Controllers\Admin\Auth\MFAController::class, 'verifyMfaVerificationCode']);

Route::get('admin/site-setting', [\App\Http\Controllers\Admin\SiteSetting\SiteSettingController::class, 'index']);

Route::group(['middleware' => 'admin', 'prefix' => 'admin'], function ($router) {

    $router->get('do-verify', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'doVerify']);
    $router->get('logout', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'logout']);

    $router->get('get/all/stats', [\App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'getAllStats']);

    // Email template
    $router->post('email-template/clone', [\App\Http\Controllers\Admin\EmailTemplate\EmailTemplateController::class, 'cloneEmailTemplate']);
    $router->apiResource('email-template', \App\Http\Controllers\Admin\EmailTemplate\EmailTemplateController::class);

    // Admin User Route
    $router->apiResource('admin-user', \App\Http\Controllers\Admin\AdminUser\AdminUserController::class);
    $router->post('admin-user/{id}', [\App\Http\Controllers\Admin\AdminUser\AdminUserController::class, 'update']);
    $router->get('admin-user/{id}/roles', [\App\Http\Controllers\Admin\AdminUser\AdminUserController::class, "userRoles"]);
    $router->post('admin-user/{id}/assign-role', [\App\Http\Controllers\Admin\AdminUser\AdminUserController::class, "assignRole"]);
    $router->post('admin-user/{id}/remove-role', [\App\Http\Controllers\Admin\AdminUser\AdminUserController::class, "removeRole"]);

    $router->get('admin-user/get/mfa-authenticator',[\App\Http\Controllers\Admin\Auth\MFAController::class,'getMfaAuthenticatorCode']);
    $router->post('admin-user/deactivate/mfa-authenticator', [\App\Http\Controllers\Admin\Auth\MFAController::class, 'deactivateMfaAuthenticator']);
    $router->post('admin-user/activate/mfa-authenticator',[\App\Http\Controllers\Admin\Auth\MFAController::class,'activateMfaAuthenticator']);
    $router->post('admin-user/activate/email-authenticator', [\App\Http\Controllers\Admin\Auth\MFAController::class, 'activateEmailAuthenticator']);
    $router->post('admin-user/deactivate/email-authenticator', [\App\Http\Controllers\Admin\Auth\MFAController::class, 'deactivateEmailAuthenticator']);
    $router->post('admin-user/reset/mfa-authenticator/{id}',[\App\Http\Controllers\Admin\Auth\MFAController::class,'resetMfaAuthenticator']);
    $router->post('admin-user/reset/email-authenticator/{id}', [\App\Http\Controllers\Admin\Auth\MFAController::class, 'resetEmailAuthenticator']);
    $router->post('admin-user/admin/do-reset/password', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'resetPassword']);

    // User Route
    $router->apiResource('user', \App\Http\Controllers\Admin\User\UserController::class)->except('update');
    $router->post('user/{id}',[\App\Http\Controllers\Admin\User\UserController::class,'update']);
    $router->post('user/{id}/generate',[\App\Http\Controllers\Admin\User\UserController::class,'generatePassword']);
    $router->get('user/search/vendor',[\App\Http\Controllers\Admin\User\UserController::class,'searchUser'])->name('customer.vendor');

    // User Address Route
    $router->apiResource('user-address', \App\Http\Controllers\Admin\User\Address\AddressController::class);

    // User Role And Permission
    $router->apiResource('role', \App\Http\Controllers\Admin\Auth\Role\RoleController::class);
    $router->get('role/{id}/permissions', [\App\Http\Controllers\Admin\Auth\Role\RoleController::class, "rolePermissions"]);
    $router->post('role/{id}/assign-permission', [\App\Http\Controllers\Admin\Auth\Role\RoleController::class, "assignPermission"]);
    $router->post('role/{id}/remove-permission', [\App\Http\Controllers\Admin\Auth\Role\RoleController::class, "removePermission"]);
    $router->get('role/{id}/default-permission', [\App\Http\Controllers\Admin\Auth\Role\RoleController::class, "assignDefaultPermissions"]);

    $router->apiResource('permission', \App\Http\Controllers\Admin\Auth\Permission\PermissionController::class);
    $router->post('permission/create', [\App\Http\Controllers\Admin\Auth\Permission\PermissionController::class, 'store']);
    $router->get('permission/all/permissions', [\App\Http\Controllers\Admin\Auth\Permission\PermissionController::class, 'getAll']);
    $router->get('permission/by/group', [\App\Http\Controllers\Admin\Auth\Permission\PermissionController::class, 'permissionByGroup']);
    //End User Role And Permission

    // User Custom Role And Permission
    $router->get('role/custom-permission/submenu/permission-list', [\App\Http\Controllers\Admin\Auth\CustomRoleAndPermission\UserCustomRoleAndPermissionController::class, 'getSubmenuPermissions']);
    $router->post('role/custom-permission/submenu/save-permission', [\App\Http\Controllers\Admin\Auth\CustomRoleAndPermission\UserCustomRoleAndPermissionController::class, 'savePermissions']);
    $router->get('role/custom-permission/submenu/user-permission-list', [\App\Http\Controllers\Admin\Auth\CustomRoleAndPermission\UserCustomRoleAndPermissionController::class, 'getUserPermissionList']);
    $router->get('role/custom-permission/submenu/role/{id}/assigned-permission', [\App\Http\Controllers\Admin\Auth\CustomRoleAndPermission\UserCustomRoleAndPermissionController::class, 'assignedPermissionToRole']);
    $router->get('role/custom-permission/submenu/reboot-permission', [\App\Http\Controllers\Admin\Auth\CustomRoleAndPermission\UserCustomRoleAndPermissionController::class, 'activateCommand']);

    //Faq Controller
    $router->apiResource('faq', \App\Http\Controllers\Admin\Cms\Faq\FaqController::class);
    $router->post('faq/sort', [\App\Http\Controllers\Admin\Cms\Faq\FaqController::class, 'sort']);

    //Faq Category Controller
    $router->apiResource('faq-category', \App\Http\Controllers\Admin\Cms\Faq\Category\FaqCategoryController::class);
    $router->post('faq-category/sort', [\App\Http\Controllers\Admin\Cms\Faq\Category\FaqCategoryController::class, 'sort']);
    $router->get('faq-category/get/all', [\App\Http\Controllers\Admin\Cms\Faq\Category\FaqCategoryController::class, 'all']);

    //Blog Category Controller
    $router->apiResource('blog-category', \App\Http\Controllers\Admin\Cms\Blog\Category\BlogCategoryController::class);
    $router->get('blog-category/get/active', [\App\Http\Controllers\Admin\Cms\Blog\Category\BlogCategoryController::class, 'getAllActive']);

    //Blog Controller
    $router->post('blog/{id}', [\App\Http\Controllers\Admin\Cms\Blog\BlogController::class, 'update']);
    $router->apiResource('blog', \App\Http\Controllers\Admin\Cms\Blog\BlogController::class);

    //Popup Controller
    $router->apiResource('popup', \App\Http\Controllers\Admin\Cms\Popup\PopupController::class);
    $router->post('popup/{id}', [\App\Http\Controllers\Admin\Cms\Popup\PopupController::class, 'update']);

    //Slider Controller
    $router->apiResource('slider', \App\Http\Controllers\Admin\Cms\Slider\SliderController::class);
    $router->post('slider/{id}', [\App\Http\Controllers\Admin\Cms\Slider\SliderController::class, 'update']);

    //Notice Controller
    $router->apiResource('notice', \App\Http\Controllers\Admin\Cms\Notice\NoticeController::class);
    $router->post('notice/sort', [\App\Http\Controllers\Admin\Cms\Notice\NoticeController::class, 'sort']);

    //Media Controller
    $router->get('media', [\App\Http\Controllers\Admin\Cms\Media\MediaController::class, 'index']);
    $router->post('media', [\App\Http\Controllers\Admin\Cms\Media\MediaController::class, 'store']);
    $router->delete('media/{id}', [\App\Http\Controllers\Admin\Cms\Media\MediaController::class, 'destroy']);
    $router->post('media/sort', [\App\Http\Controllers\Admin\Cms\Media\MediaController::class, 'sort']);

    //News and update
    $router->apiResource('news-and-updates', \App\Http\Controllers\Admin\Cms\NewsAndUpdates\NewsAndUpdatesController::class);
    $router->post('news-and-updates/{id}', [\App\Http\Controllers\Admin\Cms\NewsAndUpdates\NewsAndUpdatesController::class, 'update']);

    // Restaurant Category Route
    $router->apiResource('restaurant-category', \App\Http\Controllers\Admin\Restaurant\Category\RestaurantCategoryController::class);
    $router->get('restaurant-category/get/all', [\App\Http\Controllers\Admin\Restaurant\Category\RestaurantCategoryController::class, 'getAllCategory']);

    // Restaurant Route
    $router->apiResource('restaurant', \App\Http\Controllers\Admin\Restaurant\RestaurantController::class);
    $router->post('restaurant/{id}', [\App\Http\Controllers\Admin\Restaurant\RestaurantController::class, 'update']);

    // Room Category Route
    $router->apiResource('room-category', \App\Http\Controllers\Admin\Room\Category\RoomCategoryController::class);
    $router->get('room-category/get/all', [\App\Http\Controllers\Admin\Room\Category\RoomCategoryController::class, 'getAllCategory']);

    // Room Route
    $router->apiResource('room', \App\Http\Controllers\Admin\Room\RoomController::class);
    $router->post('room/{id}', [\App\Http\Controllers\Admin\Room\RoomController::class, 'update']);

    // Room Gallery Route
    $router->apiResource('room.gallery', \App\Http\Controllers\Admin\Room\Gallery\RoomGalleryController::class);
    $router->post('room/{roomId}/gallery/{id}', [\App\Http\Controllers\Admin\Room\Gallery\RoomGalleryController::class, 'update']);
    $router->post('room/{roomId}/gallery/change-feature-image', [\App\Http\Controllers\Admin\Room\Gallery\RoomGalleryController::class, 'changeFeatureImage']);

    // Booking Category Route
    $router->apiResource('booking-category', \App\Http\Controllers\Admin\Booking\Category\BookingCategoryController::class);
    $router->get('booking-category/get/all', [\App\Http\Controllers\Admin\Booking\Category\BookingCategoryController::class, 'getAllCategory']);

    // Site Setting
    $router->get('site-setting/get/colors', [\App\Http\Controllers\Admin\SiteSetting\SiteSettingController::class, 'getSettingColors']);
    $router->post('site-setting', [\App\Http\Controllers\Admin\SiteSetting\SiteSettingController::class, 'createOrUpdate']);
    $router->post('site-setting/test/aws', [\App\Http\Controllers\Admin\SiteSetting\SiteSettingController::class, 'testAwsUpload']);
    $router->post('site-setting/test/email', [\App\Http\Controllers\Admin\SiteSetting\SiteSettingController::class, 'sendTestEmail']);

    // Adventure Category Route
    $router->apiResource('adventure-category', \App\Http\Controllers\Admin\Adventure\Category\AdventureCategoryController::class);
    $router->get('adventure-category/get/all', [\App\Http\Controllers\Admin\Adventure\Category\AdventureCategoryController::class, 'getAllCategory']);

    // Adventure Route
    $router->apiResource('adventure', \App\Http\Controllers\Admin\Adventure\AdventureController::class);

    // Service Route
    $router->apiResource('service', \App\Http\Controllers\Admin\Service\ServiceController::class);

    // Adventure Gallery Route
    $router->apiResource('adventure.gallery', \App\Http\Controllers\Admin\Adventure\Gallery\AdventureGalleryController::class);
    $router->post('adventure/{adventureId}/gallery/{id}', [\App\Http\Controllers\Admin\Adventure\Gallery\AdventureGalleryController::class, 'update']);

    //Event Controller
    $router->apiResource('event', \App\Http\Controllers\Admin\Cms\Event\EventController::class);
    $router->post('event/{id}', [\App\Http\Controllers\Admin\Cms\Event\EventController::class, 'update']);

    //Event gallery Controller
    $router->apiResource('event.gallery', \App\Http\Controllers\Admin\Cms\Event\Gallery\EventGalleryController::class);
    $router->post('event/{eventId}/gallery/{id}', [\App\Http\Controllers\Admin\Cms\Event\Gallery\EventGalleryController::class, 'update']);

    //Payment gateway setting Controller
    $router->get('payment-gateway-setting', [\App\Http\Controllers\Admin\PaymentGatewaySetting\PaymentGatewaySettingController::class, 'index']);
    $router->post('payment-gateway-setting', [\App\Http\Controllers\Admin\PaymentGatewaySetting\PaymentGatewaySettingController::class, 'store']);
    $router->post('payment-gateway-setting/{id}', [\App\Http\Controllers\Admin\PaymentGatewaySetting\PaymentGatewaySettingController::class, 'update']);
});
