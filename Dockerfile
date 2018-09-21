FROM php:7.1-apache

ENV APACHE_DOCUMENT_ROOT /var/www/html/public
# ENV APP_ENV production
# ENV APP_DEBUG false

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html
COPY . /var/www/html
COPY .env.example /var/www/html/.env

RUN a2enmod rewrite

RUN apt-get update && apt-get install -y libmcrypt-dev libmagickwand-dev cron supervisor
RUN docker-php-ext-install mcrypt pdo_mysql gd zip mysqli

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');"

RUN php composer.phar update
RUN touch storage/logs/laravel.log

RUN chown -R www-data:www-data \
        /var/www/html/storage \
        /var/www/html/bootstrap/cache

RUN php artisan storage:link
RUN php artisan key:generate

COPY cron.sh /root/cron.sh
RUN echo "* * * * * root bash -x /root/cron.sh >> /root/cron.log 2>&1" >> /etc/crontab

COPY laravel-worker.conf /etc/supervisor/conf.d
COPY start.sh /root/start.sh

CMD bash -x /root/start.sh
