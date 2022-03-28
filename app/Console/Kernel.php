<?php

namespace App\Console;

use Artisan;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        // 如果使用redis缓存用户登录信息，此命令会清除用户登录态，所以屏蔽
        Artisan::command(
            'cache:clear',
            function () {
                print_r('此命令无法执行！' . PHP_EOL);
            }
        );

        $this->load(__DIR__ . '/Commands');

        //添加公共命令
        $this->load(app_path('Common/Console/Commands'));

        require base_path('routes/console.php');
    }
}
