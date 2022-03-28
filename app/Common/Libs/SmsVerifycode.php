<?php

namespace App\Common\Libs;

use App;
use Cache;
use Throwable;

/**
 * 发送验证码 与 验证码验证
 * 发送：
 * (new SmsVerifycode('18000000001'))->send()
 *
 * 验证：
 * (new SmsVerifycode('18000000001'))->verify('1234')
 * 或
 * (new SmsVerifycode('18000000001'， ’1234‘))->verify()
 */
final class SmsVerifycode
{
    const CODE_MIN = 300;     //验证码有效时间 （秒）
    const SEND_MIN = 60;     //请求发送间隔 （秒）
    private string $phone;
    private string $code;
    private string $codeKey;
    private string $sendKey;
    private $sms;

    /**
     * [__construct description]
     * @param string $phone [description]
     * @param string $code [description]
     * @author qiumzh
     * @since  2019-05-10
     */
    public function __construct(string $phone, $code = '')
    {
        $this->phone = $phone;
        $this->code = $code;
        $this->codeKey = 'SmsVerifycode:code:' . $phone;
        $this->sendKey = 'SmsVerifycode:send:' . $phone;
        $this->sms = 'SmsVerifycode:sms';
    }

    public function isTest()
    {
        if (!App::environment('production')) {
            return true;
        }
        if (preg_match('/100\d{6,}/', $this->phone)) {
            return true;
        }
        return strlen($this->phone) !== 10;
    }

    /**
     * 验证码发送
     * @return bool
     * @throws \Exception
     */
    public function send()
    {
        if (Cache::get($this->sendKey)) {
            throw_e(0xf00222);
        }
        try {
            $code = str_pad(random_int(0001, 9999), 4, 0, STR_PAD_LEFT);
            // $content = "Your SMS verification code is:${code}";
            if (!$this->isTest()) {
                // TODO: 调用第三方短信接口

                $result = true;
            } else {
                $result = $code;
            }

            Cache::put($this->codeKey, $code, self::CODE_MIN);
            Cache::put($this->sendKey, $code, self::SEND_MIN);
            return $result;
        } catch (Throwable $e) {
            throw_e(0xf00232);
        }
    }

    /**
     * 验证码校验
     * @return bool
     */
    protected function check()
    {
        if (Cache::get($this->codeKey) !== $this->code) {
            return false;
        }
        Cache::forget($this->codeKey);
        Cache::forget($this->sendKey);
        return true;
    }

    /**
     * 验证短信验证码
     * @param string $sms_code 短信验证码
     * @param string $auth_code 用户登录验证码，特殊用户使用
     * @return mixed
     */
    public function verify(string $smsCode = '', string $authCode = '')
    {
        if (empty($authCode)) {
            $smsCode && $this->code = $smsCode;
            if ($this->isTest()) {
                return $this->check() || $smsCode === '654321';
            }
            return $this->check();
        } else {
            return $smsCode === $authCode;
        }
    }
}
