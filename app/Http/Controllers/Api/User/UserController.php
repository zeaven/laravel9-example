<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiRequest;
use App\Http\Requests\Api\User\InfoUpdateRequest;
use App\Logics\Api\User\UserLogic;

/**
 *
 * @authors generator
 * @date    2022-03-28 15:32:37
 */
class UserController extends Controller
{
    protected $logic;

    public function __construct(UserLogic $logic)
    {
        $this->logic = $logic;
    }

    /**
     * 用户信息 /api/user/info
     *
     * @param  ApiRequest $request [description]
     * @return Response
     */
    public function info(ApiRequest $request)
    {

        $result = $this->logic->info();

        return ok($result);
    }

    /**
     * 修改用户信息 /api/user/info-update
     *
     * @param  InfoUpdateRequest $request [description]
     * @return Response
     */
    public function infoUpdate(InfoUpdateRequest $request)
    {
        // 请求传入的参数值，要获取key/value参数数组请使用 $param = $request->params();
        [$nickname, $email] = $request->values();
        $result = $this->logic->infoUpdate($nickname, $email);

        return ok($result);
    }

    /** #generate function# 删除后将无法自动生成控制器方法 */
}
