FROM php:8.1-fpm

RUN apt-get update && apt-get upgrade -y \
    && apt-get install apt-utils -y \
    && docker-php-ext-install pdo pdo_mysql

RUN apt-get install unzip -y
RUN apt-get install zip -y
RUN apt-get install git -y

RUN curl -fsSL https://deb.nodesource.com/setup_lts.x | bash -
RUN apt-get install nodejs
RUN npm install -g npm@8.18.0

ADD https://getcomposer.org/download/latest-2.x/composer.phar /usr/local/bin/composer
RUN chmod +x /usr/local/bin/composer

WORKDIR /var/www
COPY . /var/www
