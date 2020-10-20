FROM php:7.4-fpm-alpine

RUN apk add --no-cache \
    git \
    icu-dev \
    libzip-dev \
    postgresql-dev \
    zip

RUN docker-php-ext-install \
    intl \
    opcache \
    pdo \
    pdo_pgsql \
    zip

COPY --from=composer /usr/bin/composer /usr/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_MEMORY_LIMIT -1
RUN composer global require hirak/prestissimo --no-plugins --no-scripts

ARG HOST_UID

RUN if [ ! -z "${HOST_UID}" ]; then \
        deluser www-data \
        && addgroup www-data \
        && adduser -u "${HOST_UID}" -G www-data -H -s /bin/sh -D www-data; \
    fi

ENV WWW_DATA_UID ${HOST_UID}

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
RUN apk --no-cache add pcre-dev ${PHPIZE_DEPS} && pecl install redis && docker-php-ext-enable redis
RUN apk add --update --no-cache --virtual .build-dependencies $PHPIZE_DEPS \
        && pecl install apcu \
        && docker-php-ext-enable apcu \
        && pecl clear-cache \
        && apk del .build-dependencies

COPY ./config/docker/dev/symfony.pool.conf /usr/local/etc/php-fpm.d/