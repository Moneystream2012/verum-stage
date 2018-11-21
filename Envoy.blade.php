@servers(['web' => ['root@45.55.187.25']])

@task('deploy')
    cd mlmtradecoin
    git pull "https://ridiks10:1x2x3x4x5x6x@bitbucket.org/ridiks10/backoffice.verumtrade.com.git"
    docker exec mlmtradecoin_php_1 php artisan opcache:clear
@endtask

@task('config')
    cd mlmtradecoin
    git pull "https://ridiks10:1x2x3x4x5x6x@bitbucket.org/ridiks10/backoffice.verumtrade.com.git"
    docker exec mlmtradecoin_php_1 php artisan config:cache
    docker exec mlmtradecoin_php_1 php artisan opcache:clear
@endtask

@task('composer:install')
    cd mlmtradecoin
    git pull "https://ridiks10:1x2x3x4x5x6x@bitbucket.org/ridiks10/backoffice.verumtrade.com.git"
    docker exec mlmtradecoin_php_1 composer install
    docker exec mlmtradecoin_php_1 php artisan opcache:clear
@endtask
