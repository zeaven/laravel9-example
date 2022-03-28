<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiRequest;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Logics\Api\Auth\AuthLogic;

/**
 *
 * @authors generator
 * @date    2022-03-28 14:13:46
 */
class AuthController extends Controller
{
    protected $logic;

    public function __construct(AuthLogic $logic)
    {
        $this->logic = $logic;
    }

    /**
     * 登录
     *
     * @param  LoginRequest $request [description]
     * @return Response
     */
    public function login(LoginRequest $request)
    {
        // 请求传入的参数值，要获取key/value参数数组请使用 $param = $request->params();
        [$username, $password] = $request->values();
        $result = $this->logic->login($username, $password);

        return ok($result);
    }

    /**
     * 登录
     *
     * @param  ApiRequest $request [description]
     * @return Response
     */
    public function logout(ApiRequest $request)
    {

        $result = $this->logic->logout();

        return ok($result);
    }

    /** #generate function# 删除后将无法自动生成控制器方法 */
}
