#!/bin/sh

# installs dependencies if composer.lock changed
# sha1sum -c composer.lock.sha1 || composer install && sha1sum composer.lock > composer.lock.sha1
composer install
php artisan migrate
# (TELESCOPE_ENABLED=false php artisan wait:db && php artisan migrate && php artisan permission:generate permissions) &
php-fpm -R
