FROM dmstr/php-yii2:7.1-fpm-3.2-alpine-nginx

COPY ./image-files /
RUN chmod u+x /usr/local/bin/*

# Install extensions
RUN apk add --no-cache --virtual .phpize-deps $PHPIZE_DEPS \
 && pecl install mailparse \
 && apk del .phpize-deps

# Application packages
WORKDIR /app
COPY ./composer.* /app/
COPY src/composer.phd5.json /app/src/composer.phd5.json
RUN composer install --prefer-dist --optimize-autoloader && \
    composer clear-cache

# Application source-code
COPY yii /app/
COPY ./config /app/config/
COPY ./public /app/public/
COPY ./src /app/src/
RUN cp config/app.env-dist config/app.env

# Permissions
RUN mkdir -p runtime ./public/assets ./public/bundles /mnt/storage && \
    chmod -R 775 runtime ./public/assets ./public/bundles /mnt/storage && \
    chmod -R ugo+r /root/.composer/vendor && \
    chown -R www-data:www-data runtime ./public/assets ./public/bundles /root/.composer/vendor /mnt/storage

# Assets
RUN APP_NAME=build APP_LANGUAGES=en yii asset/compress config/assets.php ./public/bundles/config.php

# Install crontab from application config (
RUN crontab config/crontab

VOLUME /mnt/storage