<?php

namespace App\Common\Providers;

use App\Common\Libs\Auth\CacheEloquentUserProvider;
use Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Stringable;
use Str;
use Symfony\Component\Finder\Finder;

class CommonServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $finder = app(Finder::class);
        $finder->files()->name('*.php')->in(__DIR__ . '/../Config/');
        foreach ($finder as $file) {
            $this->mergeConfigFrom($file->getPathname(), str_replace('.php', '', $file->getFilename()));
        }

        // 自定义用户提供者，默认每次通过token查询用户是否存在，自定义提供者可在查询中增加缓存，减少数据库查询，但是用户状态更新不及时
        // 需要手动调用CustomEloquentUserProvider::refresh($key)清除登录缓存
        Auth::provider(
            'cache_eloquent',
            function ($app, array $config) {
                // 返回 Illuminate\Contracts\Auth\UserProvider 实例...
                $model = $config['model'];
                $fields = $config['fields'];
                $authModel = $config['auth_model'];

                return $app->make(CacheEloquentUserProvider::class, compact('model', 'authModel', 'fields'));
            }
        );

        /**
         * 字符串增强
         * Str::replaceMatch('{foo} {bar}', ['foo' => 1, 'bar' => ]) ==> '1 2'
         * @var [type]
         */
        Str::macro(
            'replaceMatch',
            function (string $subject, array $replacements) {
                return preg_replace_callback(
                    "/{([^{}]+)}/",
                    function ($matches) use ($replacements) {
                        $matche = $matches[1];
                        foreach ($replacements as $key => $value) {
                            if ($key === $matche) {
                                return $value;
                            }
                        }
                        return $matches[0];
                    },
                    $subject
                );
            }
        );
        Stringable::macro(
            'replaceMatch',
            function (array $replacements) {
                return preg_replace_callback(
                    "/{([^{}]+)}/",
                    function ($matches) use ($replacements) {
                        $matche = $matches[1];
                        foreach ($replacements as $key => $value) {
                            if ($key === $matche) {
                                return $value;
                            }
                        }
                        return $matches[0];
                    },
                    $this->value()
                );
            }
        );
    }
}
