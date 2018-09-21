#!/bin/bash
source /root/env.sh
cd /var/www/html
php artisan queue:work --sleep=3 --tries=3
