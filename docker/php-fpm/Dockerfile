FROM phpdockerio/php72-fpm:latest
WORKDIR "/var/www"

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y --no-install-recommends install  php7.2-pgsql php-xdebug \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

COPY .bash_aliases /root/.bash_aliases
