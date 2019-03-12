FROM php:7-fpm-alpine

RUN apk update && apk add curl && \
  curl -sS https://getcomposer.org/installer | php \
  && chmod +x composer.phar && mv composer.phar /usr/local/bin/composer

RUN apk add --no-cache \
        freetype-dev \
        libjpeg-turbo-dev \
        libpng-dev \
        libzip-dev \
        postgresql-dev \
        git

RUN docker-php-ext-configure opcache --enable-opcache

RUN docker-php-ext-install \
  bcmath \
  mbstring \
  opcache \
  pdo \
  pdo_pgsql \
  zip

# https://github.com/docker-library/php/issues/225#issuecomment-226870896
RUN docker-php-ext-configure gd \
  --with-gd \
  --with-freetype-dir=/usr/include/ \
  --with-png-dir=/usr/include/ \
  --with-jpeg-dir=/usr/include/ && \
NPROC=$(grep -c ^processor /proc/cpuinfo 2>/dev/null || 1) && \
docker-php-ext-install -j${NPROC} gd

COPY php.ini /usr/local/etc/php/
COPY .bash_aliases /root/.bash_aliases
