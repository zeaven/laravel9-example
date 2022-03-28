<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiRequest;
use App\Logics\Api\ApiLogic;

/**
 * 
 * @authors generator
 * @date    2022-03-22 16:11:52
 */
class ApiController extends Controller
{
    protected $logic;

    public function __construct(ApiLogic $logic)
    {
        $this->logic = $logic;
    }

    /**
     * user
     * 
     * @param  ApiRequest $request [description]
     * @return Response
     */
    public function user(ApiRequest $request)
    {
        
        $result = $this->logic->user();

        return ok($result);
    }

    /** #generate function# 删除后将无法自动生成控制器方法 */

}
