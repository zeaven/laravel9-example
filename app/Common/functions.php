<?php

use App\Common\Libs\Annotations\AnnoLog;
use App\Common\Libs\Exceptions\Exception;

//成功返回json格式数据
if (!function_exists('ok')) {
    function ok($result = null, array $headers = [])
    {
        if (blank($result)) {
        } elseif ($result instanceof Symfony\Component\HttpFoundation\Response) {
            return $result;
        } elseif (is_a($result, Illuminate\Support\Collection::class)) {
            $result = compact('result');
        } elseif (is_array($result)) {
            array_key_exists(0, $result) && $result = compact('result');
        } elseif ($result instanceof App\Commons\Http\ResponseMappers\BaseResponseMapper) {
            if ($result->isArray()) {
                $result = [
                    'result' => $result->toArray()
                ];
            }
        } elseif (!is_object($result)) {
            $result = compact('result');
        }
        return response()->json($result)->withHeaders($headers);
    }
}


/**
 * 异常抛出
 * throw_e(500)
 * throw_e('message', 500)
 */
if (!function_exists('throw_e')) {
    function throw_e($err, int|array $code = 500, ?array $data = null)
    {
        if (is_array($code)) {
            [$code, $data] = [500, $code];
        }
        if (is_numeric($err)) {
            [$err, $code] = ['', $err];
        }
        if ($err instanceof Exception) {
            throw $err;
        } else {
            request()->errorData($data);
            if ($code > 550) {
                throw new Exception(strval($err), 500, null, $code);
            } else {
                throw new Exception(strval($err), $code, null, $code);
            }
        }
    }
}
// 条件异常
if (!function_exists('throw_on')) {
    function throw_on($bool, $err, int|array $code = 500, ?array $data = null)
    {
        if ($bool) {
            throw_e($err, $code, $data);
        }
        return $bool;
    }
}
// 空异常
if (!function_exists('throw_empty')) {
    function throw_empty($empty, $err, int|array $code = 500, ?array $data = null)
    {
        if (empty($empty)) {
            throw_e($err, $code, $data);
        }
        return $empty;
    }
}

if (! function_exists('common_path')) {
    function common_path(string $path = '')
    {
        return app_path('Common/' . $path);
    }
}

if (! function_exists('anno_log')) {
    function anno_log($key, $value = null)
    {
        AnnoLog::data($key, $value);
    }
}
