<?php

/**
 * Model UUID 特性
 * @date    2021-01-22 08:59:33
 * @version $Id$
 */

namespace App\Domain\Traits\Common;

use App\Domain\Core\Model;
use Str;

trait ModelUUID
{
    protected static function bootModelUUID()
    {
        static::creating(function (Model &$model) {
            if (empty($model->uid)) {
                $model->uid = Str::orderedUuid()->toString();
            }
        });
    }
}
