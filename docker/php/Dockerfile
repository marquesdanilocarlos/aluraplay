ARG PHP_VERSION=""
FROM php:${PHP_VERSION:+${PHP_VERSION}-}fpm-alpine
RUN apk update; \
    apk upgrade;
    
RUN apk add --update \
		$PHPIZE_DEPS \
		freetype-dev \
		libjpeg-turbo-dev \
		libpng-dev \
		libxml2-dev \
		libzip-dev \
		openssh-client \
		imagemagick \
		imagemagick-libs \
		imagemagick-dev \
		sqlite-dev \
		sqlite \
		icu-dev \ 
		openssl-dev \
		icu-libs;
RUN docker-php-ext-install bcmath gd pcntl pdo pdo_mysql pdo_sqlite intl zip
RUN apk add --update linux-headers
COPY 90-xdebug.ini "${PHP_INI_DIR}/conf.d"
RUN pecl install xdebug
RUN pecl install ds
RUN docker-php-ext-enable xdebug ds opcache
RUN docker-php-ext-configure gd --with-jpeg --with-freetype

RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini
RUN sed -i 's/;opcache.validate_timestamps=1/;opcache.validate_timestamps=0/g' /usr/local/etc/php/php.ini
RUN sed -i 's/;extension=gd/extension=gd/g' /usr/local/etc/php/php.ini
RUN apk add --update nodejs npm
RUN chown -R www-data:82 /var/www
