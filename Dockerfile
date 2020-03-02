FROM php:7.2-apache

ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html
COPY . /var/www/html
COPY .env.example /var/www/html/.env

RUN a2enmod rewrite

RUN apt-get update && apt-get install -y libmagickwand-dev cron supervisor mariadb-client-10.3
RUN docker-php-ext-install mbstring pdo_mysql gd zip mysqli

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php -r "if (hash_file('sha384', 'composer-setup.php') === 'e0012edf3e80b6978849f5eff0d4b4e4c79ff1609dd1e613307e16318854d24ae64f26d17af3ef0bf7cfb710ca74755a') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');"

RUN php composer.phar install
RUN touch storage/logs/laravel.log

RUN chown -R www-data:www-data \
        /var/www/html/storage \
        /var/www/html/bootstrap/cache

RUN php artisan storage:link

RUN echo "* * * * * root cd /var/www/html/ && php artisan schedule:run" >> /etc/crontab

RUN mkdir -p /usr/local/etc/php/conf.d
RUN echo "upload_max_filesize = 50M\npost_max_size = 51M" > /usr/local/etc/php/conf.d/00-upload-size.ini

COPY laravel-worker.conf /etc/supervisor/conf.d
COPY start.sh /root/start.sh

CMD bash -x /root/start.sh
