FROM php:apache
 
RUN apt-get update \
&& apt-get install -y libonig-dev libzip-dev unzip\
&& docker-php-ext-install pdo_mysql mbstring zip bcmath\
&& pecl install xdebug\
&& docker-php-ext-enable xdebug
 
RUN echo "ServerName localhost" | tee /etc/apache2/conf-available/fqdn.conf
RUN a2enconf fqdn

COPY --from=composer /usr/bin/composer /usr/bin/composer
