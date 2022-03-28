<?php

namespace App\Logics\Api\Test;

/**
 * @AnnoLog(type=1, tpl="测试日志：{{time}}")
 * @authors generator
 * @date    2022-03-22 16:11:52
 */
class TestLogic
{
    public function home($data)
    {
        // throw_on(true, 0xf00012, $data);
        anno_log(['time' => now()->format('Y-m-d H:i:s')]);
        return request()->user();
    }
}
