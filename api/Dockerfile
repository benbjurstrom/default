# Stage 1 - Create cached vendor file.
FROM astrify/php-queue:latest as api-cache

WORKDIR /cache/
COPY composer.json .
RUN composer install --no-dev --no-autoloader --no-scripts

# Stage 2 - Build container
FROM astrify/php-queue:latest
WORKDIR /var/www/app

COPY . .
COPY --from=api-cache /cache/ .

COPY start.sh /usr/local/bin/start
COPY .env.build .env

RUN chmod +x artisan
RUN chmod +x /usr/local/bin/start

RUN composer install --no-dev
RUN composer dump-autoload -a -o

EXPOSE 8000
CMD ["/usr/local/bin/start"]