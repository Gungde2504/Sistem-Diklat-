#!/bin/bash

mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs

# Perbaiki symlink storage setiap container start.
# Symlink public/storage bisa ikut ter-copy dari host (mis. dibuat di Windows/Laragon)
# dengan path yang tidak valid di dalam container Linux, atau storage_data volume
# baru ter-mount setelah image dibuild. Hapus dulu baru buat ulang supaya selalu benar.
rm -f public/storage
php artisan storage:link

chmod -R 775 storage
chown -R www-data:www-data storage

exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf