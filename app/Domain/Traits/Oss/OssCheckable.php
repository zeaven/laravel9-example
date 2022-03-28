<?php

/**
 * Oss资源检查特性
 *
 * @date    2019-10-15 09:45:54
 * @version $Id$
 */

namespace App\Domain\Traits\Oss;

trait OssCheckable
{
    public static $checkFields = [];
    public static function bootOssCheckable()
    {
        static::$checkFields = static::getCheckFieldsColumn();
        if (static::$checkFields) {
            // 添加查询作用域
            static::addGlobalScope(new OssCheckableScope('check_state'));
        }
    }

    protected function initializeOssCheckable()
    {
        if (static::$checkFields) {
            $this->casts['check_result'] = 'array';
        }
    }

    public static function getCheckFieldsColumn()
    {
        return defined('static::CHECK_FIELDS') ? static::CHECK_FIELDS : [];
    }

    public function checkOssState($storage)
    {
        $state = $this->attributes['check_state'];
        $check_result = [];
        if ($state === 0) {
            // 检查oss资源
            $fields = static::$checkFields;
            foreach ($fields as $field) {
                $path = $this->attributes[$field];
                if (! $storage->has($path)) {
                    $check_result[] = "[{$this->name}] 资源文件不存在：{$path}";
                }
            }
        }
        if (count($check_result)) {
            $this->fill(['check_state' => -1, 'check_result' => $check_result])->save();
        } else {
            $this->fill(['check_state' => 1, 'check_result' => []])->save();
        }
    }

    public function resetCheckState(bool $save = false)
    {
        $this->fill(['check_state' => 0, 'check_result' => []]);
        if ($save) {
            $this->save();
        }
    }

    public function ossFailure()
    {
        return intval($this->attributes['check_state']) === -1;
    }
}
