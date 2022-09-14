FROM php:8.0-fpm
COPY php.ini /usr/local/etc/php/

# install composer
RUN cd /usr/bin && curl -s http://getcomposer.org/installer | php && ln -s /usr/bin/composer.phar /usr/bin/composer


# install packages
RUN apt-get update
RUN apt-get install -y \
    gcc \
    make \
    libpng-dev \
    git \
    unzip \
    vim \
    libmcrypt-dev \
    mariadb-client \
    curl \
    gnupg \
    openssl \
    zlib1g-dev \ 
    libfreetype6-dev \
    libjpeg62-turbo-dev \     
    supervisor \
    cron \ 
  && docker-php-ext-install pdo_mysql \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install -j$(nproc) gd 
# install stable node and latest npm
RUN curl -sL https://deb.nodesource.com/setup_10.x | bash
RUN apt-get install -y nodejs

#change TIMEZONE
RUN cp /usr/share/zoneinfo/Asia/Tokyo /etc/localtime

WORKDIR /var/www
ADD . /var/www
RUN chown -R www-data:www-data /var/www

#cron setting
ADD ./cron.d /etc/cron.d/
RUN chmod 0644 /etc/cron.d/*
RUN crontab /etc/cron.d/cron.root

#supervisor setting
ADD ./supervisor/supervisor.conf /etc/supervisor/conf.d/supervisor.conf

# must to attach docker-php-entrypoint php-fpm
CMD supervisord -c /etc/supervisor/supervisord.conf 