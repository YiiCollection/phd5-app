FROM dmstr/php-yii2:7.1-fpm-3.1-rc1-alpine-nginx

COPY ./image-files /
RUN chmod u+x /usr/local/bin/*

# TODO: Remove when Patched plugin with skip-update
RUN rm -rf ~/.composer/vendor && composer global install

# Application packages
WORKDIR /app
ENV COMPOSER=composer/composer.json
COPY composer/composer.* /app/composer/
COPY src/composer.phd5.json /app/src/composer.phd5.json
RUN composer install --no-dev --prefer-dist --optimize-autoloader && \
    composer clear-cache

# Application source-code
COPY yii /app/
COPY ./web /app/web/
COPY ./src /app/src/
RUN cp src/app.env-dist src/app.env

# Permissions
RUN mkdir -p runtime web/assets web/bundles /mnt/storage && \
    chmod -R 775 runtime web/assets web/bundles /mnt/storage && \
    chmod -R ugo+r /root/.composer/vendor && \
    chown -R www-data:www-data runtime web/assets web/bundles /root/.composer/vendor /mnt/storage

# Assets
RUN APP_NAME=build APP_LANGUAGES=en yii asset/compress src/config/assets.php web/bundles/config.php

# Install crontab from application config (
RUN crontab src/config/crontab

VOLUME /mnt/storage