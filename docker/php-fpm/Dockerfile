FROM php:8.2-fpm-alpine3.16

# Install tools required for build stage
RUN apk add --update --no-cache \
    bash curl wget rsync ca-certificates openssl openssh git tzdata openntpd \
    libxrender fontconfig libc6-compat \
    mysql-client gnupg binutils-gold autoconf \
    g++ gcc libgcc linux-headers make py-pip

# Use the default (production / development) configuration
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer \
    && chmod 755 /usr/bin/composer

# Install PHPunit
RUN curl -O https://phar.phpunit.de/phpunit-9.5.27.phar \
    && chmod +x phpunit-9.5.27.phar && mv phpunit-9.5.27.phar /usr/bin/phpunit

# Install additional PHP libraries
RUN docker-php-ext-install bcmath pdo_mysql \
    && docker-php-ext-enable pdo_mysql

# Install libraries for compiling GD, then build it
RUN apk add --no-cache freetype libpng libjpeg-turbo libwebp freetype-dev libpng-dev libjpeg-turbo-dev libwebp-dev \
    && docker-php-ext-configure gd \
            --enable-gd \
            --with-freetype=/usr/include/ \
            --with-jpeg=/usr/include/ \
            --with-webp=/usr/include/ \
    && docker-php-ext-install gd \
    && apk del --no-cache freetype-dev libpng-dev libjpeg-turbo-dev libwebp-dev

# Add ZIP archives support
RUN apk add --update --no-cache zlib-dev libzip-dev \
    && docker-php-ext-install zip

# Install xDebug
RUN pecl install xdebug-3.2.0 \
    && docker-php-ext-enable xdebug

# to be able to use "nano" with shell on "docker exec -it [CONTAINER ID] bash"
ENV TERM xterm

WORKDIR /app