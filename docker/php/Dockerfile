FROM php:8.1.1-fpm

RUN apt-get update && apt-get -y install \
  wget \
  cron \
  ssh \
  zlib1g-dev \
  libzip-dev \
  unzip \
  libcurl4-openssl-dev  \
  pkg-config \
  libssl-dev \
  libxml2-dev

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

#Install xdebug
RUN pecl install -o -f xdebug \
    && echo "zend_extension=xdebug.so" >> /usr/local/etc/php/php.ini  \
    && docker-php-ext-enable xdebug

#Install MySQL
RUN docker-php-ext-install pdo_mysql mysqli \
    && echo "extension=pdo_mysql" >> /usr/local/etc/php/php.ini  \
    && docker-php-ext-enable pdo_mysql

#Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet --version=2.2.1
RUN mkdir /tmp/local-php-security-checker-tmp && cd /tmp/local-php-security-checker-tmp \
    && wget https://github.com/fabpot/local-php-security-checker/releases/download/v1.0.0/local-php-security-checker_1.0.0_linux_amd64 \
    && cp local-php-security-checker_1.0.0_linux_amd64 /usr/local/bin/local-php-security-checker && chmod 775 /usr/local/bin/local-php-security-checker \
    && rm -rf /tmp/local-php-security-checker-tmp

#Install pecl modules
RUN docker-php-ext-install zip

USER root

RUN chmod 777 /var && chmod 777 /var/www

RUN usermod -u 1000 www-data

USER www-data

WORKDIR /var/www/php-up

CMD service cron start && php-fpm
