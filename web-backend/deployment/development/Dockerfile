FROM php:8.0.5-fpm-alpine
WORKDIR /var/www

#RUN docker-php-ext-install mysqli
#RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql

COPY deployment/development/php-fpm.conf /usr/local/etc/php-fpm.conf
COPY deployment/development/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY deployment/development/php.ini /usr/local/etc/php/php.ini

#RUN docker-php-ext-install pdo pdo_mysql mysqli
#RUN apk install mysql-server
RUN apk add bash\ 
    && apk update
# RUN chown -R www-data:www-data /var/www

EXPOSE 9000
# USER root
#ENTRYPOINT ["php-fpm"]
ENV COMPOSER_MEMORY_LIMIT=-1
# CMD ["php-fpm", "-R"]
ENTRYPOINT ["deployment/development/entrypoint.sh"]