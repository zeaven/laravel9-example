<?php

/**
 *
 * @authors generator
 * @date    2022-03-28 15:43:11
 */

namespace App\Domain\Module\UserCenter\Service;

use App\Domain\Core\DomainService;
use App\Domain\Module\UserCenter\Context\UserContext;
use App\Domain\Module\UserCenter\Traits\UserLoginTrait;
use App\Domain\Module\UserCenter\Traits\UserUpdateTrait;

class UserService extends DomainService
{
    const CONTEXT = UserContext::class;
    use UserLoginTrait;
    use UserUpdateTrait;
}
