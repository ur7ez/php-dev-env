FROM php:8.2.0-apache

# Install tools required for build stage
RUN apt-get update && apt-get install -fyqq \
    bash curl wget rsync ca-certificates openssl ssh git tzdata openntpd \
    libxrender1 fontconfig libc6 \
    mariadb-client gnupg binutils-gold autoconf nano \
    g++ gcc gnupg libgcc1 linux-headers-amd64 make python3

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
RUN apt-get install -fyqq \
    libfreetype6 libfreetype6-dev libpng16-16 libpng-dev libjpeg62-turbo libjpeg62-turbo-dev libwebp6 libwebp-dev \
    && docker-php-ext-configure gd \
            --enable-gd \
            --with-freetype=/usr/include/ \
            --with-jpeg=/usr/include/ \
            --with-webp=/usr/include/ \
    && docker-php-ext-install gd \
    && apt-get remove -fyqq libfreetype6-dev libpng-dev libjpeg62-turbo-dev libwebp-dev

# Add ZIP archives support
RUN apt-get install -fyqq zip libzip-dev \
    && docker-php-ext-install zip \
    && apt-get remove -fyqq libzip-dev

# Install xDebug
RUN pecl install xdebug-3.2.0 \
    && docker-php-ext-enable xdebug

# to be able to use "nano" with shell on "docker exec -it [CONTAINER ID] bash"
ENV TERM xterm

# Apache conf
# allow .htaccess with RewriteEngine
RUN a2enmod rewrite
# to see live logs: docker logs -f [CONTAINER ID]
# without the following line we get "AH00558: apache2: Could not reliably determine the server's fully qualified domain name"
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

WORKDIR /app