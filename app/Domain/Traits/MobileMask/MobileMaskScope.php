<?php

/**
 *
 *
 * @date    2019-09-24 12:38:12
 * @version $Id$
 */

namespace App\Domain\Traits\MobileMask;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class MobileMaskScope implements Scope
{
    protected $extensions = ['phoneMask'];
    public $_enable = false;

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
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


    protected function addPhoneMask(Builder $builder)
    {
        $builder->macro('phoneMask', function (Builder $builder, $enable = true) {
            $this->_enable = $enable;
            return $builder;
        });
    }
}
