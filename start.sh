#!/bin/bash
echo "Creating env var file"
declare -p | grep -Ev 'BASHOPTS|BASH_VERSINFO|EUID|PPID|SHELLOPTS|UID' > /root/env.sh
chmod +x /root/env.sh

echo "Starting cron"
cron

echo "Starting queue worker"
touch /var/run/supervisor.sock
chmod 777 /var/run/supervisor.sock
service supervisor start
supervisorctl reread
supervisorctl update
supervisorctl start all

# volume mounting occurs after setting permissions, therefore do it again
chown -R www-data:www-data /var/www/html/storage

echo "Starting apache"
apache2-foreground