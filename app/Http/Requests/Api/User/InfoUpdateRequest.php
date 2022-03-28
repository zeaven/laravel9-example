<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\ApiRequest;

/**
 * 
 * @authors generator
 * @date    2022-03-28 15:32:37
 */
class InfoUpdateRequest extends ApiRequest
{
    /**
     * 返回参数验证规则.
     *
     * @return array
     */
    protected function rule(): array
    {
        return [
            // 呢称
            'nickname',
            // 邮箱
            'email'
        ];

    }
}
