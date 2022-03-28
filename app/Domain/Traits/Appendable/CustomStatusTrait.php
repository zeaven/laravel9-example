<?php

/**
 * 订单状态
 *
 * @date    2019-10-30 09:24:58
 * @version $Id$
 */

namespace App\Domain\Traits\Appendable;

/**
 * 针对model中某一个状态字段做转换
 */
trait CustomStatusTrait
{
    private function getStatusDefinition()
    {
        static $defines;
        if (!$defines) {
            $defines = defined('static::STATUS') ? static::STATUS : [];
        }
        return $defines;
    }

    private function getStatusMin()
    {
        static $min;
        if (!$min) {
            $min = defined('static::STATUS_MIN') ? static::STATUS_MIN : 0;
        }
        return intval($min);
    }
    protected function initializeCustomStatusTrait()
    {
        $this->append('status_text');
    }

    /**
     * 0待支付、1待发货、2待签收、3已完成、4退款、-1交易关闭
     * @return [type] [description]
     */
    public function getStatusTextAttribute()
    {
        if (isset($this->attributes['status'])) {
            $min = $this->getStatusMin();
            $status = intval($this->attributes['status']) - $min;
            $defines = $this->getStatusDefinition();
            return $defines[$status] ?? '';
        } else {
            return '';
        }
    }

    public function setStatusAttribute($status)
    {
        if (!is_numeric($status)) {
            $defines = $this->getStatusDefinition();
            $min = $this->getStatusMin();
            $idx = array_search($status, $defines);
            $this->attributes['status'] = $idx === false ? $min : ($idx + $min);
        } else {
            $this->attributes['status'] = $status;
        }
        return $this;
    }
}
