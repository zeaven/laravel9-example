<?php

namespace App\Http\Controllers\Api\Test;

use App\Common\Libs\Annotations\AnnoLog;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApiRequest;
use App\Http\Requests\Api\Test\HomeRequest;
use App\Logics\Api\Test\TestLogic;

/**
 *
 * @authors generator
 * @date    2022-03-22 16:11:52
 */
class TestController extends Controller
{
    protected $logic;

    public function __construct(TestLogic $logic)
    {
        $this->logic = $logic;
    }

    /**
     *
     * @param  ApiRequest $request [description]
     * @return Response
     */
    #[AnnoLog(type:1, tpl:"测试日志：{time}")]
    public function home(HomeRequest $request)
    {
        $data = $request->params(true);
        $result = $this->logic->home($data);

        return ok($result);
    }

    /** #generate function# 删除后将无法自动生成控制器方法 */
}
