<?php

/**
 * 领域服务基础
 *
 * @date    2020-06-23 10:42:57
 * @version $Id$
 */

namespace App\Domain\Core;

use App\Domain\Core\Model;
use Str;

abstract class DomainService
{
    protected $config = [];
    protected $ctx;
    protected static $booteds = [];

    public function __construct()
    {
        $key = defined('static::CONFIG') ? static::CONFIG : '';
        if ($key) {
            $this->config = config('common.domain.' . $key);
        }
        $ctx = defined('static::CONTEXT') ? static::CONTEXT : '';
        if ($ctx) {
            $this->ctx = new $ctx();
        }
        if (method_exists($this, 'initialize')) {
            $this->initialize();
        }
        if (!isset(static::$booteds[static::class])) {
            static::$booteds[static::class] = true;
            static::booted();
        }
    }

    protected static function booted()
    {
    }

    public function setUser(Model $user)
    {
        if ($this->ctx) {
            $this->ctx->setUser($user);
        }
        return $this;
    }

    public function __get($entity)
    {
        if ($entity === 'user' && $this->ctx) {
            return $this->ctx->user;
        }
        $entityName = Str::studly($entity);
        $entityClass =  str_replace('Service\\' . class_basename(static::class), 'Entity\\', static::class) . $entityName;

        throw_on(!class_exists($entityClass), 'Entity not exists!');

        return resolve($entityClass);
    }
}
