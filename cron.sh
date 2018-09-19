#!/bin/bash
source /root/env.sh
printenv
cd /var/www/html
php artisan schedule:run