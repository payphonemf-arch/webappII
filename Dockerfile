FROM php:8.3-apache

RUN docker-php-ext-install pdo_mysql \
    && a2enmod rewrite

WORKDIR /var/www/html
COPY . /var/www/html/
COPY docker/start-apache.sh /usr/local/bin/start-apache.sh

RUN chmod +x /usr/local/bin/start-apache.sh \
    && chown -R www-data:www-data /var/www/html

EXPOSE 10000
CMD ["/usr/local/bin/start-apache.sh"]
