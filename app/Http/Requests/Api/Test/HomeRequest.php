<?php

namespace App\Http\Requests\Api\Test;

use App\Http\Requests\BaseRequest;

/**
 *
 * @authors generator
 * @date    2022-03-24 01:48:43
 */
class HomeRequest extends BaseRequest
{
    /**
     * 返回参数验证规则.
     *
     * @return array
     */
    protected function rule(): array
    {
        return [
            //
            'name' => ['rule' => 'required|mb_max:4'],
            //
            'param2' => ['rule' => 'integer', 'default' => 10, 'type' => 'int'],
            //
            'param3' => ['default' => [], 'type' => 'array']
        ];
    }
}
