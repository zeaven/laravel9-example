<?php

/**
 * 总数计算特性
 *
 * @date    2019-09-23 10:41:45
 * @version $Id$
 */

namespace App\Domain\Traits\AttributeCalculator;

/**
 * 将model中多个字段统计为total_count字段返回
 */
trait TotalCountTrait
{
    // const COUNT_FIELD = [];
    public static function getCountField()
    {
        static $fields;
        if (!$fields) {
            $fields = defined('static::COUNT_FIELD') ? static::COUNT_FIELD : [];
        }
        return $fields;
    }

    protected function initializeTotalCountTrait()
    {
        if (defined('static::COUNT_FIELD')) {
            $this->append('total_count');
        }
    }

    public function getTotalCountAttribute()
    {
        $count = 0;
        foreach (static::getCountField() as $field) {
            if (!isset($this->attributes[$field])) {
                $count = 0;
                break;
            } else {
                $count += $this->attributes[$field] ?: 0;
            }
        }
        return $count;
    }
}
