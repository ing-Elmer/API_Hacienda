FROM php:7.4-apache-bullseye
LABEL version="1.1"
RUN apt-get update && apt-get -y install libpng-dev curl libcurl4-openssl-dev openssl netcat-openbsd
RUN docker-php-ext-install pdo pdo_mysql mysqli gd curl
RUN a2dismod mpm_event mpm_worker mpm_prefork 2>/dev/null; a2enmod mpm_prefork
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
RUN ln -s /usr/local/bin/docker-entrypoint.sh /docker-entrypoint.sh
ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"]