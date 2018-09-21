#!/bin/bash
echo "Creating env var file"
declare -p | grep -Ev 'BASHOPTS|BASH_VERSINFO|EUID|PPID|SHELLOPTS|UID' > /root/env.sh
chmod +x /root/env.sh

echo "Starting cron"
cron

echo "Starting queue worker"
nohup php artisan queue:work &

echo "Starting apache"
apache2-foreground