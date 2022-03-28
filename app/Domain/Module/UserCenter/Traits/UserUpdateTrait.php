<?php

namespace App\Domain\Module\UserCenter\Traits;

use App\Domain\Core\Model;
use App\Domain\Module\UserCenter\Entity\UserEntity;
use Arr;

trait UserUpdateTrait
{
    /**
     * 修改用户信息
     * @param  array       $data 用户信息
     * @param  string|null $uid  用户uid，空为当前登录用户
     * @return [type]            [description]
     */
    public function updateInfo(array $data, ?string $uid = null)
    {
        $user = $uid ? UserEntity::findOrFail($uid) : $this->ctx->user;

        $info = Arr::only($data, ['nickname', 'email']);

        return tap($user)->update($info);
    }
}
