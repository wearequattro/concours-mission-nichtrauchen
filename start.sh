#!/bin/bash
echo "Starting cron"
cron

echo "Starting queue worker"
touch /var/run/supervisor.sock
chmod 700 /var/run/supervisor.sock
supervisord -c /etc/supervisor/supervisord.conf
supervisorctl reread
supervisorctl update
supervisorctl start all

# volume mounting occurs after setting permissions, therefore do it again
chown -R www-data:www-data /var/www/html/storage

echo "Starting apache"
apache2-foreground
