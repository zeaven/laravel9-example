<?php

namespace App\Domain\Core;

use App\Domain\Core\Model as BaseModel;
use App\Domain\Traits\Common\ModelUUID;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * laravel 框架基础模型
 *
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Commons\Models\Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Commons\Models\Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Commons\Models\Model query()
 */
class JwtModel extends BaseModel implements
    AuthorizableContract,
    AuthenticatableContract,
    JWTSubject
{
    use Authenticatable;
    use Authorizable;
    use ModelUUID;

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'uid';
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->{$this->getAuthIdentifierName()};
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            'type' => strtolower(class_basename(static::class))
        ];
    }
}
