<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



/*** api_test_routes start ***/

if (! function_exists('api_test_routes')) {
    function api_test_routes()
    {
        // test
        Route::get('test/home', "Test\TestController@home");
    }/*** api_test_routes end ***/
}


/*** api_index_routes start ***/
if (! function_exists('api_index_routes')) {
    function api_index_routes()
    {
        // user
        Route::get('user', "ApiController@user");
    }/*** api_index_routes end ***/
}


/*** api_auth_routes start ***/
if (! function_exists('api_auth_routes')) {
    function api_auth_routes()
    {
        // 登录
        Route::post('auth/login', "Auth\AuthController@login");
        // 登录
        Route::get('auth/logout', "Auth\AuthController@logout")->middleware('auth:sanctum');
    }/*** api_auth_routes end ***/
}


/*** api_user_routes start ***/
if (! function_exists('api_user_routes')) {
    function api_user_routes()
    {
        // 用户信息 /api/user/info
        Route::get('user/info', "User\UserController@info");
        // 修改用户信息 /api/user/info-update
        Route::post('user/info-update', "User\UserController@infoUpdate");
    }/*** api_user_routes end ***/
}

/******* generate config ********/

api_index_routes();

Route::middleware('auth:sanctum')->group(function () {
    api_test_routes();
    api_user_routes();
});

api_auth_routes();

/******* generate router ********/
