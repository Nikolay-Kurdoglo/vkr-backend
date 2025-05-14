FROM php:8.4-fpm-alpine

ARG PROJECT_DIR=/srv
ARG ENVIRONMENT=dev

WORKDIR $PROJECT_DIR

COPY composer.json "${PROJECT_DIR}/composer.json"
COPY composer.lock "${PROJECT_DIR}/composer.lock"

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN if [ "$ENVIRONMENT" = "dev" ]; then \
        composer install -o --no-interaction; \
    elif [ "$ENVIRONMENT" = "prod" ]; then \
        composer install -o --no-dev --no-interaction; \
    fi;

RUN set -ex \
    && apk --no-cache add postgresql-dev \
    && docker-php-ext-install pdo_pgsql;

# Seprarate each folter to different image layers to increase build speed
COPY bin bin
COPY config config
COPY migrations migrations
COPY src src
COPY public public
COPY var var
COPY .env .env
