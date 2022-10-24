cd /var/www/laravel/wit/ && \
chmod -R 777 public/ && \
cd public && \
rm -r userImages && \
cd /var/www/laravel/wit/ && \
php artisan storage:link && \
php artisan config:clear && \