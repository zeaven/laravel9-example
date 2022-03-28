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
trait GenderTextTrait
{
    protected function initializeGenderTextTrait()
    {
        $this->append('gender_text');
    }

    private function getGenders()
    {
        return defined('static::GENDERS') ? static::GENDERS : ['未知','男','女'];
    }

    public function getGenderTextAttribute()
    {
        $gender = $this->attributes['gender'] ?? 0;
        $genders = $this->getGenders();
        if (filled($gender)) {
            return $genders[$gender] ?? $genders[0];
        } else {
            return head($genders);
        }
    }

    public function setGenderAttribute($gender)
    {
        if (!is_numeric($gender)) {
            $genders = $this->getGenders();
            $idx = array_search($gender, $genders);
            $this->attributes['gender'] = $idx === false ? -1 : ($idx - 1);
        } else {
            $this->attributes['gender'] = $gender;
        }
        return $this;
    }
}
