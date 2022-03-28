<?php

/**
 * Oss检查域
 *
 * @date    2019-10-15 09:48:04
 * @version $Id$
 */

namespace App\Domain\Traits\Oss;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class OssCheckableScope implements Scope
{
    private $stateColumn;

    public function __construct($stateColumn)
    {
        $this->stateColumn = $stateColumn;
    }

    protected $extensions = ['whereOssSuccess', 'whereOssFailure', 'whereOssAny', 'whereOssNeedCheck'];

    /**
     * 把约束加到 Eloquent 查询构造中。
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        return $builder;
    }

    /**
     * Extend the query builder with the needed functions.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    public function extend(Builder $builder)
    {
        foreach ($this->extensions as $extension) {
            $this->{"add{$extension}"}($builder);
        }
    }

    protected function addWhereOssSuccess(Builder $builder)
    {
        $builder->macro(
            'whereOssSuccess',
            function (Builder $builder) {
                $builder->where($this->stateColumn, 1);
                return $builder;
            }
        );
    }

    protected function addWhereOssFailure(Builder $builder)
    {
        $builder->macro(
            'whereOssFailure',
            function (Builder $builder) {
                $builder->where($this->stateColumn, -1);
                return $builder;
            }
        );
    }

    protected function addWhereOssAny(Builder $builder)
    {
        $builder->macro(
            'whereOssAny',
            function (Builder $builder) {
                $builder->withoutGlobalScope($this);
                return $builder;
            }
        );
    }

    protected function addWhereOssNeedCheck(Builder $builder)
    {
        $builder->macro(
            'whereOssNeedCheck',
            function (Builder $builder) {
                $builder->where($this->stateColumn, 0);
                return $builder;
            }
        );
    }
}
