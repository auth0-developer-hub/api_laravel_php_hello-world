FROM composer:2.2.4@sha256:0367c4a421bd048cdfa337ae6d50557d410dc0e8f66e4624797c034892925bba as composer_cache
WORKDIR /app
COPY composer.* ./
RUN composer install --no-dev --no-autoloader --no-scripts

FROM php:7.4-apache-bullseye@sha256:1b444f64bfc83ad8da56ee37b5e1b1c6af955fffb949ab6c166a19da1a1b4aad
EXPOSE 6060
ARG AUTH0_DOMAIN
WORKDIR /app
COPY app app
COPY bootstrap bootstrap
COPY config config
COPY public public
COPY resources resources
COPY routes routes
COPY storage storage
COPY artisan artisan
COPY server.php server.php
COPY --from=composer_cache /usr/bin/composer /usr/bin/composer
COPY --from=composer_cache /app /app
COPY ./docker/apache2/vhost.conf /etc/apache2/sites-available/api.conf
RUN sed -ri -e 's!/var/www/html!/app/public!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!/app/public!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf \
    && sed -ri -e 's!ServerTokens OS!ServerTokens Prod!g' /etc/apache2/conf-available/security.conf \
    && sed -ri -e 's!ServerSignature On!ServerSignature Off!g' /etc/apache2/conf-available/security.conf \
    && echo 'Listen ${SERVER_PORT}' > /etc/apache2/ports.conf \
    && a2enmod rewrite \
    && a2dissite 000-default \
    && a2ensite api \
    && chown -R www-data:www-data /app
USER www-data
RUN AUTH0_DOMAIN="${AUTH0_DOMAIN}" VALIDATE_ENV=0 composer install --prefer-dist --no-dev --optimize-autoloader
