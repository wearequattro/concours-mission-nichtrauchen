#!/bin/bash
echo "Creating env var file"
declare -p | grep -Ev 'BASHOPTS|BASH_VERSINFO|EUID|PPID|SHELLOPTS|UID' > /root/env.sh
chmod +x /root/env.sh

echo "Starting cron"
cron

echo "Starting apache"
apache2-foreground & > /dev/null

echo "Tailing logs"
tail -f /var/www/html/storage/logs/laravel.log /var/log/apache2/access.log /var/log/apache2/error.log