FROM php:7.2-apache

RUN apt-get -y update
RUN apt-get -y install wget nano git unzip

RUN pecl install ast
RUN docker-php-ext-enable ast
RUN docker-php-ext-install pdo_mysql

WORKDIR /
COPY install-composer.sh /
RUN chmod u+x ./install-composer.sh && \
    ./install-composer.sh && \
    rm install-composer.sh && \
    mv composer.phar /usr/bin/composer

# TODO need to restart after?
RUN a2enmod rewrite
COPY 000-default.conf /etc/apache2/sites-available/

WORKDIR /var/www/html
#RUN composer install
