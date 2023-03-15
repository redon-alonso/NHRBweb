# FROM php:7.4-apache
FROM php:8-apache

# Con postgresql y pdo_pgsql
# RUN apt-get -y update && apg-get install -y libpq-dev \
#   && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
#   && docker-php-ext-install pdo pdo_pgsql pgsql

# Con mysqli y pdo mysql
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Con los dos
# RUN apt-get -y update && apt-get install -y libpq-dev \
#   && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
#   && docker-php-ext-install pdo pdo_pgsql pdo_mysql pgsql mysqli

RUN a2enmod rewrite

COPY . /var/www/html
