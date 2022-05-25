<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\ApiRequest;

/**
 * 
 * @authors generator
 * @date    2022-05-26 03:07:49
 */
class SearchRequest extends ApiRequest
{
    /**
     * 返回参数验证规则.
     *
     * @return array
     */
    protected function rule(): array
    {
        return [
            // 检索字符串
            'value'
        ];

    }
}
