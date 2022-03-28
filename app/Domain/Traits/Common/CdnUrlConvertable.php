<?php

/**
 * 类名必须符合规则：{表名}{操作}Trait，如标签管理=TagMgrTrait，课件查询=coursewareQueryTrait
 * 禁止如下命名：TagTrait，TagUpdateCreateTrait
 * 方法参数包涵数组的，必须标明数据包括的属性
 * create time: 2018-09-21 09:35:10
 * create by:
 *
 * example:
 * protected $cdn_url_include_fields = [
 *     'image_url' => 'image',
 *     'images' => 'image:auth_key',
 *     'mp4_url' => 'zip:encrypt',
 *     'file_url'
 * ];
 * image_url 将使用CDN_IMAGE_URL转换地址域名
 * images 可以是数据，将使用CDN_IMAGE_URL转换数据所有地址，并且添加auth_key授权
 * mp4_url 将使用CDN_ZIP_URL转换地址域名，并加密
 * file_url 将使用CDN_URL转换地址域名
 */

namespace App\Domain\Traits\Common;

use Illuminate\Support\Str;

/**
 * url 自动转换 cdn 域名
 * 对表中以url结尾的字段自动截取域名，只保存path部分，读取时自动补全定义好的cdn域名
 */
trait CdnUrlConvertable
{
    /**
     * 排除不处理的字段
     * @var array
     */
    private function getCdnUrlExcludeFields()
    {
        return (property_exists($this, 'cdn_url_exclude_fields')) ? $this->cdn_url_exclude_fields : [];
    }
    /**
     * 额外处理的字段,exclude优先级比include和pattern高
     * 如： ['content:video', 'file_url', 'images:image']，则
     * content将被转换为 video_cdn_url
     * file_url将被转换为 cdn_url
     * images如果是数组，将以数组形式，遍历转换所有数值为 image_cdn_url
     * @var array
     */
    private static $_cdn_url_include_fields = null;
    private function getCdnUrlIncludeFields()
    {
        if (is_null(static::$_cdn_url_include_fields)) {
            static::$_cdn_url_include_fields = [];
            $exclude_fields = $this->getCdnUrlExcludeFields();
            $include_fields = (property_exists($this, 'cdn_url_include_fields')) ? $this->cdn_url_include_fields : [];
            foreach ($include_fields as $key => $include_field) {
                if (is_string($key)) {
                    $include_field = "{$key}:{$include_field}";
                }
                if (preg_match("/([^:]+)(:[^:]+)?(:[^:]+)?/", $include_field, $matches)) {
                    if (!in_array($matches[1], $exclude_fields)) {
                        static::$_cdn_url_include_fields[$matches[1]] = [true, $matches[2] ?? '', $matches[3] ?? ''];
                    }
                }
            }
        }
        return static::$_cdn_url_include_fields;
    }

    private static $_cdn_url_mutated_fields = null;
    /**
     * Get the mutated attributes for a given instance.
     *
     * @return array
     */
    public function attributesToArray()
    {
        $attributes = parent::attributesToArray();
        if (is_null(static::$_cdn_url_mutated_fields)) {
            static::$_cdn_url_mutated_fields = array_keys($this->getCdnUrlIncludeFields());
        }
        foreach (static::$_cdn_url_mutated_fields as $field) {
            if (array_key_exists($field, $attributes)) {
                $attributes[$field] = $this->getAttributeValue($field);
            }
        }

        return $attributes;
    }

    public function getAttributeValue($key)
    {
        $url = parent::getAttributeValue($key);

        [$match, $type, $encrypt] = $this->matchCdnUrlField($key);
        if ($match) {
            $type = trim($type, ':');
            $encrypt = trim($encrypt, ':');
            $cdn_host = config("services.cdn.{$type}_url", config("services.cdn.url"));
            $cdn_host = Str::finish($cdn_host, '/');
            if (is_array($url)) {
                foreach ($url as $idx => $value) {
                    $url[$idx] = $this->convertUrl($value, $cdn_host, $type, $encrypt);
                }
            } else {
                $url = $this->convertUrl($url, $cdn_host, $type, $encrypt);
            }
        }

        return $url;
    }

    private function convertUrl($url, $cdn_host, $type, $encrypt)
    {
        $url = stripcslashes($url);
        if (blank($url)) {
            return $url;
        } elseif (Str::startsWith($url, $cdn_host)) {
        } elseif (Str::startsWith($url, 'http')) {
            // 转换 url 地址域名为 cdn 域名
            $url = preg_replace('/^http.*\.(com|cn)\//', $cdn_host, $url);
        } else {
            $url = $cdn_host . trim($url, '/');
        }
        // cdn url auth
        if ($authkey = config("services.cdn.{$encrypt}")) {
            $url = static::cdnAuthUrl($url, $authkey);
        }
        if ($encrypt === 'encrypt' && config("services.cdn.{$type}_encrypt")) {
            $url = cdn_video_encrypt($url);
        }
        return $url;
    }

    public function setAttribute($key, $url)
    {
        [$match] = $this->matchCdnUrlField($key);
        if ($match) {
            // 去掉域名和cdn auth_key
            if (is_array($url)) {
                foreach ($url as $idx => $value) {
                    $value = stripcslashes($value);
                    $value = urldecode($value);
                    if (Str::startsWith($value, 'http')) {
                        // 转换 url 地址域名为 cdn 域名
                        $url[$idx] = Str::before(preg_replace('/^http.*\.(com|cn)/', '', $value), '?');
                    }
                }
            } else {
                $url = stripcslashes($url);
                $url = urldecode($url);
                if (Str::startsWith($url, 'http')) {
                    // 转换 url 地址域名为 cdn 域名
                    $url = Str::before(preg_replace('/^http.*\.(com|cn)/', '', $url), '?');
                }
            }
        }
        return parent::setAttribute($key, $url);
    }

    /**
     * 检查字段是否配置转换条件
     * @param  string $field 字段名称
     * @return bool          是否转换
     */
    private function matchCdnUrlField(string $field): array
    {
        $include_fields = $this->getCdnUrlIncludeFields();

        return $include_fields[$field] ?? [false, null, null];
    }

    public static function cdnAuthUrl(string $url, string $key)
    {
        $url = implode('/', array_map(function ($item) {
            return strpos($item, 'http') !== false ? $item : urlencode($item);
        }, explode('/', $url)));
        $uri = parse_url($url, PHP_URL_PATH);
        $timestamp = time() + 3600;
        $rand = 0; //preg_replace('/\-/', '', Str::uuid()->toString());
        $uid = 0;
        $md5hash = md5("{$uri}-{$timestamp}-{$rand}-{$uid}-{$key}");
        $auth_key = "{$timestamp}-{$rand}-{$uid}-{$md5hash}";
        return $url . (strpos($url, '?') !== false ? '&' : '?') . "auth_key={$auth_key}";
    }
}
