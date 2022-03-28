<?php

/**
 * 实体/仓储
 *
 * @date    2019-03-06 13:53:21
 * @version $Id$
 */

namespace App\Domain\Core;

abstract class DomainEntity
{
    protected static $instance;
    protected static $entityInstance = [];
    public function __call($method, $paramters)
    {
        if (!isset(static::$entityInstance[static::class]) && defined('static::ENTITY')) {
            static::$entityInstance[static::class] = app(static::ENTITY);
        }
        $instance = static::$entityInstance[static::class] ?? null;
        if ($instance) {
            return $instance->$method(...$paramters);
        }
        throw_e('server domain error');
    }

    public static function __callStatic(string $method, array $paramters)
    {
        if (!static::$instance) {
            static::$instance = new static();
        }
        return static::$instance->{$method}(...$paramters);
    }
}
