FROM php:7.4-apache-bullseye
LABEL version="1.2"
RUN apt-get update && apt-get -y install libpng-dev curl libcurl4-openssl-dev openssl netcat-openbsd
RUN docker-php-ext-install pdo pdo_mysql mysqli gd curl
RUN rm -f /etc/apache2/mods-enabled/mpm_event.conf \
          /etc/apache2/mods-enabled/mpm_event.load \
          /etc/apache2/mods-enabled/mpm_worker.conf \
          /etc/apache2/mods-enabled/mpm_worker.load \
    && ln -sf /etc/apache2/mods-available/mpm_prefork.conf /etc/apache2/mods-enabled/mpm_prefork.conf \
    && ln -sf /etc/apache2/mods-available/mpm_prefork.load /etc/apache2/mods-enabled/mpm_prefork.load
RUN a2enmod rewrite
COPY ./docker-php-apache/docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh
COPY ./www/ /var/www/html
COPY ./api/ /var/www/api
RUN mkdir -p /var/www/api/errors
RUN mkdir -p /var/www/api/logs
RUN mkdir -p /var/www/api/files
RUN chmod -R 755 /var/www/
RUN chmod -R 777 /var/www/api/errors
RUN chmod -R 777 /var/www/api/logs
RUN chmod -R 777 /var/www/api/files
RUN echo 'Listen ${PORT}' > /etc/apache2/ports.conf && \
    sed -i 's/VirtualHost \*:80/VirtualHost *:${PORT}/' /etc/apache2/sites-enabled/000-default.conf
RUN ln -s /usr/local/bin/docker-entrypoint.sh /docker-entrypoint.sh
ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"]