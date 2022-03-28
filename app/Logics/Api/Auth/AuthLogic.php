<?php

namespace App\Logics\Api\Auth;

use App\Domain\Module\UserCenter\Service\UserService;
use Auth;

/**
 *
 * @authors generator
 * @date    2022-03-28 14:13:46
 */
class AuthLogic
{
    public function login(string $username, string $password)
    {
        return app(UserService::class)->userLogin(compact('username', 'password'), 'api-login');
    }

    public function logout()
    {
        return app(UserService::class)->userLogout();
    }
}
