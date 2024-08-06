FROM php:8.2-apache

# Install deps de base pour pouvoir dl guzzle
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

# Installer PHPUnit en global via Composer
RUN composer global require phpunit/phpunit --prefer-dist

ENV PATH="/root/.composer/vendor/bin:${PATH}"

COPY apache2.conf /etc/apache2/sites-available/000-default.conf

COPY composer.json composer.lock /var/www/html/
COPY . /var/www/html/

WORKDIR /var/www/html
