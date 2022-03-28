<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\ApiRequest;

/**
 *
 * @authors generator
 * @date    2022-03-28 15:14:19
 */
class LoginRequest extends ApiRequest
{
    /**
     * 返回参数验证规则.
     *
     * @return array
     */
    protected function rule(): array
    {
        return [
            // 用户名
            'username' => ['rule' => 'required'],
            // 密码
            'password' => ['rule' => 'required|min:4'],
        ];
    }
}
