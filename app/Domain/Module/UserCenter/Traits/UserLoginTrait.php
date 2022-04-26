<?php

/**
 * 登录特性
 * @authors master (master@v8y.com)
 * @date    2021-09-02 14:36:03
 * @version $Id$
 */

namespace App\Domain\Module\UserCenter\Traits;

use App\Common\Libs\Auth\CacheEloquentUserProvider;
use App\Domain\Core\Model;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\TransientToken;
use Laravel\Sanctum\HasApiTokens;

trait UserLoginTrait
{
    private static $_ROLE_CACHE_KEY = 'USER:ROLE:';
    private static int $_CACHE_SECOND = 3600;
    /**
     * 登录
     * @param  array  $credentials 登录信息，包含一个用户标识字段和一个password字段
     * @return [type]              [description]
     */
    public function userLogin(array $credentials, string $tokenName)
    {
        $success = auth()->attempt($credentials);
        if (!$success) {
            throw_e(0xf00042);
        }
        $user = auth()->user();
        // $this->updateLoginInfo($user);
        // 清除已存在的缓存，当缓存的登录信息有延时，通过重新登录可刷新
        $this->clearLoginInfo($user);

        if (in_array(HasApiTokens::class, class_uses($user))) {
            $accessToken = $user->createToken($tokenName);
            $success = $accessToken->plainTextToken;
        }

        return ['token' => $success];
    }

    /**
     * 登录用户信息
     * @return [type] [description]
     */
    public function userInfo()
    {
        $user = $this->user;
        $auth = $this->getUserAuthInfo($user);

        return compact('user', 'auth');
    }

    /**
     * 退出登陆
     * @param string $token
     * @return mixed
     */
    public function userLogout(?string $token = null)
    {
        if (in_array(HasApiTokens::class, class_uses($this->user))) {
            // 此处不清除用户登录缓存，有可能同一账号在多个终端登录
            if (empty($token)) {
                $accessToken = $this->ctx->user->currentAccessToken();
                if ($accessToken instanceof TransientToken) {
                    $token = request()->bearerToken();
                    if ($token) {
                        $accessToken = PersonalAccessToken::findToken($token);
                    }
                    request()->session()->flush();
                }
            } else {
                $accessToken = PersonalAccessToken::findToken($token);
            }
            if ($accessToken) {
                $accessToken->delete();
            }
        } else {
            auth()->logout();
        }
    }

    /**
     * 清除用户登录信息，后台修改用户信息后，需要调用此方法
     * @param  Model  $user 登录用户对象
     * @return [type]       [description]
     */
    public function clearLoginInfo(Model $user)
    {
        CacheEloquentUserProvider::refresh($user->uid);
        cache()->tags('account')->forget(static::$_ROLE_CACHE_KEY . $user->uid);
    }

    /**
     * 获取对应账号的权限
     * @param Model $user
     * @return array
     */
    private function getUserAuthInfo(Model $user)
    {
        // 暂无权限控制
        return ['roles' => [], 'permissions' => []];
        // return cache()->tags('account')
        //     ->remember(
        //         static::$_ROLE_CACHE_KEY . $user->uid,
        //         static::$_CACHE_SECOND,
        //         function () use ($user) {
        //             $roles = $user->getRoleNames();
        //             $permissions = $user->getAllPermissions()->pluck('name');

        //             return compact('roles', 'permissions');
        //         }
        //     );
    }

    /**
     * 更新登录信息
     * @return [type] [description]
     */
    private function updateLoginInfo(Model $user)
    {
        $options = [
            'last_logined_at' => now(),
            'last_logined_ip' => ip2long(request()->ip()),
        ];
        return $user->account->increment('logined_count', 1, $options);
    }
}
