<?php

/**
 * UUIDModel.php
 *
 * Author: Guo
 * Email jonasyeah@163.com
 *
 * Date:   2019-08-16 15:00
 */

namespace App\Domain\Core;

use App\Domain\Core\Model as BaseModel;
use App\Domain\Traits\Common\ModelUUID;

/**
 * App\Domain\Core\UUIDModel
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Domain\Core\UUIDModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Domain\Core\UUIDModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Domain\Core\UUIDModel query()
 * @mixin \Eloquent
 */
class UUIDModel extends BaseModel
{
    use ModelUUID;

    // 采用uuid作为主键id，方便数据迁移
    protected $keyType = 'string';
    public $incrementing = false;
}
