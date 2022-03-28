<?php

/**
 *
 * @authors generator
 * @date    2022-03-24 16:03:42
 */

namespace App\Domain\Module\UserCenter\Model;

use App\Domain\Core\AuthModel;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Domain\Module\UserCenter\Model\Account
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property int $user_id
 * @property string $username
 * @property string $mobile
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @method static \Illuminate\Database\Eloquent\Builder|Account newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Account newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Account query()
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereUsername($value)
 * @mixin \Eloquent
 */
class Account extends AuthModel
{
    use HasApiTokens;

    public function user()
    {
        return $this->belongsTo(User::class, 'uid', 'uid');
    }
}
