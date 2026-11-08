FROM php:8.3-apache

RUN a2dismod -f mpm_event mpm_worker || true \
    && a2enmod mpm_prefork rewrite headers \
    && docker-php-ext-install pdo_mysql

WORKDIR /var/www/html
COPY . /var/www/html/
COPY docker/start-apache.sh /usr/local/bin/start-apache.sh

RUN chmod +x /usr/local/bin/start-apache.sh \
    && chown -R www-data:www-data /var/www/html

EXPOSE 10000
CMD ["/usr/local/bin/start-apache.sh"]
