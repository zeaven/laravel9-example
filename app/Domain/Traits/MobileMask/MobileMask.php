<?php

/**
 * 手机号遮掩
 *
 * @date    2020-06-19 16:21:39
 * @version $Id$
 */

namespace App\Domain\Traits\MobileMask;

use App\Domain\Traits\MobileMask\MobileMaskScope;

trait MobileMask
{
    public static $_scope;

    public static function bootMobileMask()
    {
        static::$_scope = new MobileMaskScope();
        // 添加查询作用域
        static::addGlobalScope(static::$_scope);
    }

    public function getMobileAttribute($value)
    {
        if (static::$_scope->_enable === true) {
            return preg_replace('/(\d{3})(\d{4})(\d{1,})$/', '$1****$3', $value);
        } else {
            return $value;
        }
    }
}
