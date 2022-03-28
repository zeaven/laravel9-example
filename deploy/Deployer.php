<?php
/**
 *
 * @authors zeaven (zeaven@163.com)
 * @date    2019-08-06 14:07:23
 * @version $Id$
 */

use App\Commons\Deploy\Deployer as CommonDeployer;
use Composer\Installer\PackageEvent;
use Composer\Script\Event;

class Deployer extends CommonDeployer
{
    protected static function configure($env)
    {
        $config = [];
        switch ($env) {
            case 'test':
                $config = [
                    'APP_ENV' => 'test',
                    'APP_KEY' => 'base64:bKXezRurmCPxBxP4mBGNxVEoKAt/q6jyhZG56EaO5qg=',
                    'DB_HOST' => 'mysql-8',
                    'DB_USERNAME' => 'root',
                    'DB_PASSWORD' => '123456',
                    'DB_DATABASE' => 'bigworld',
                    'REDIS_HOST' => 'redis',
                    'APP_URL' => "http://api.test.btc.com",
                    'CDN_URL' => 'http://d29zvojh2jjz27.cloudfront.net/',
                    'CDN_IMAGE_URL' => 'http://d29zvojh2jjz27.cloudfront.net/',
                ];
                break;
            case 'dev1':
                $config = [
                    'APP_ENV' => 'dev1',
                    'APP_KEY' => 'base64:bTc6O6pW93Lz65GzYnQRRS92rVdE+wf30474q9hBdOA=',
                    'DB_HOST' => 'mysql-8',
                    'DB_USERNAME' => 'root',
                    'DB_PASSWORD' => '123456',
                    'DB_DATABASE' => 'bigworld',
                    'REDIS_HOST' => 'redis',
                    'APP_URL' => "http://api.dev1.btc.com",
                    'CDN_URL' => 'http://d29zvojh2jjz27.cloudfront.net/',
                    'CDN_IMAGE_URL' => 'http://d29zvojh2jjz27.cloudfront.net/',
                ];
                break;
            default:
                $config = [
                    'DB_HOST' => 'mysql-8',
                    'DB_USERNAME' => 'root',
                    'DB_PASSWORD' => '123456',
                    'DB_DATABASE' => 'bigworld',
                    'REDIS_HOST' => 'redis',
                    'APP_ENV' => 'local',
                    'APP_KEY' => 'base64:bTc6O6pW93Lz65GzYnQRRS92rVdE+wf30474q9hBdOA=',
                    'APP_URL' => "http://api.local.btc.com",
                    'CDN_URL' => 'http://d29zvojh2jjz27.cloudfront.net/',
                    'CDN_IMAGE_URL' => 'http://d29zvojh2jjz27.cloudfront.net/',
                ];
                break;
        }

        return $config;
    }
}
