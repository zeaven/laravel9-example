<?php

namespace App\Http\Requests;

use App\Common\Http\Requests\BaseRequest as Request;
use Arr;

abstract class BaseRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // 管理后台用户判断
        // $token = auth()->getToken();
        // if ($token) {
        //     $payload = auth()->manager()->getJwtProvider()->decode($token->get());
        //     if ($payload['type'] === 'member') {
        //         // 用户只能访问 api接口
        //         return request()->is('api/*');
        //     } else {
        //         return request()->is('admin/*');
        //     }
        // }

        return true;
    }

    /**
     * 全局验证规则，如果定义了 $_rules 相同规则 ，将会覆盖全局规则
     *
     * @return [type] [description]
     */
    protected function globalRules()
    {
        return [
            'mobile'   => 'required|mobile',
            'password' => 'required|min:4',
            'name'     => 'string|max:40',
            'gender'   => 'integer',
            'size'     => 'integer',
            'keywords' => 'string',
            'id'       => 'integer',
            'page'     => 'integer',
            'phone'    => 'mobile',
            'code'     => 'string',
            'type'     => 'integer',
            'token'    => 'string',
        ];
    }

    /**
     * 获取验证错误的自定义属性
     * 在错误消息里 :email 将会替换为 email address
     *
     * @return array
     */
    public function attributes()
    {
        return [
            // 'phone'        => 'mobile',
            // 'mobile'       => 'mobile',
            // 'email'        => 'email',
            // 'guarantee'    => 'guarantee',
            // 'amount'       => '金额',
            // 'order_no'     => '订单号',
            // 'price'        => '价格',
            // 'quantity'     => '数量',
        ];
    }

    /**
     * 获取已定义验证规则的错误消息
     *
     * @return array
     */
    public function messages()
    {
        return [
        ];
    }
}
