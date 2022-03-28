<?php

/**
 * 类名必须符合规则：{表名}{操作}Trait，如标签管理=TagMgrTrait，课件查询=coursewareQueryTrait
 * 禁止如下命名：TagTrait，TagUpdateCreateTrait
 * 方法参数包涵数组的，必须标明数据包括的属性
 * create time: 2019-12-13 11:46:55
 * create by:
 */

namespace App\Domain\Traits\Common;

/**
 * 针对性别字段做转换
 * const GENDERS = ['未知', '男', '女'] // 定义转换内容
 */
trait TypeTextTrait
{
    protected function initializeTypeTextTrait()
    {
        $this->append('type_text');
    }

    private function getTypes()
    {
        return defined('static::TYPES') ? static::TYPES : [];
    }

    private function getTypesMin()
    {
        return defined('static::TYPES_MIN') ? static::TYPES_MIN : 0;
    }

    public function getTypeTextAttribute()
    {
        if (isset($this->attributes['type'])) {
            $min = $this->getTypesMin();
            $type = intval($this->attributes['type']) - $min;
            $types = $this->getTypes();
            return $types[$type] ?? '';
        } else {
            return '';
        }
    }

    public function setTypeAttribute($type)
    {
        if (!is_numeric($type)) {
            $types = $this->getTypes();
            $min = $this->getTypesMin();
            $idx = array_search($type, $types);
            $this->attributes['type'] = $idx === false ? $min : ($idx + $min);
        } else {
            $this->attributes['type'] = $type;
        }
        return $this;
    }
}
