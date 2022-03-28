#!/bin/bash

workdir=$1
cd $workdir;
./composer.phar install-dependencies
# ./composer.phar dump-autoload -o
./composer.phar post-deploy $2


# 终止队列任务
php artisan horizon:terminate

if [ "$2" != "production" ]
then
    sleep 5
    echo '启动 horizon'
    php artisan horizon >/dev/null 2>&1 &
fi
