#!/bin/bash

mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs

chmod -R 775 storage
chown -R www-data:www-data storage

exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf