cd /var/www/laravel/wit/ && \
chmod -R 777 public/ && \
cd public && \
rm -r userImages && \
cd /var/www/laravel/wit/ && \
npm install &&\
npm run dev && \
php artisan storage:link && \
php artisan config:clear 
