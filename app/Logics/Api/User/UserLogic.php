<?php

namespace App\Logics\Api\User;

use App\Domain\Module\UserCenter\Model\User;
use App\Domain\Module\UserCenter\Service\UserService;

/**
 *
 * @authors generator
 * @date    2022-03-28 15:32:37
 */
class UserLogic
{
    public function info()
    {
        return app(UserService::class)->userInfo();
    }

    public function infoUpdate(string $nickname, string $email)
    {
        return app(UserService::class)->updateInfo(compact('nickname', 'email'));
    }

    public function search(string $value = '')
    {
        return User::search($value)->get();
    }
}
