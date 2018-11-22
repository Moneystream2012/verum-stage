#!/bin/bash

#cd /var/www

#chown www-data:www-data ./mlmtradecoin -R
#chmod 0777 ./mlmtradecoin
#usermod -u 1000 www-data

cd /var/www/mlmtradecoin
chmod -R 777 storage
chmod -R 777 bootstrap/cache
composer install
php artisan config:cache
php artisan route:cache
#php artisan opcache:optimize

/usr/bin/nohup php ./artisan queue:work --queue=high,default > ./storage/logs/queue.log 2>&1 &

cron -f &
php-fpm
