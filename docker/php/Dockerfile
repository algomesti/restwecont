FROM ubuntu:20.04
ARG DEBIAN_FRONTEND=newt

RUN apt-get -y update
RUN apt-get -y install git
RUN apt-get -y install apache2
RUN apt-get -y install php7.4
RUN apt-get -y install zip unzip php-zip
RUN apt-get -y install libapache2-mod-php7.4
RUN apt-get -y install php7.4-xml
RUN apt-get -y install php-mbstring
RUN apt-get -y install mcrypt nano wget
RUN apt-get -y install locales
RUN apt-get -y install redis-server
RUN apt-get -y install php-curl
RUN apt-get -y install php-mysql
RUN apt-get -y update
RUN apt-get -y install mysql-client


RUN sed -i -e 's/^error_reporting\s*=.*/error_reporting = E_ALL/' /etc/php/7.4/apache2/php.ini
RUN sed -i -e 's/^display_errors\s*=.*/display_errors = On/' /etc/php/7.4/apache2/php.ini
RUN sed -i -e 's/^zlib.output_compression\s*=.*/zlib.output_compression = Off/' /etc/php/7.4/apache2/php.ini

ENV TERM xterm

RUN a2enmod rewrite
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf
RUN chgrp -R www-data /var/www
RUN find /var/www -type d -exec chmod 775 {} +
RUN find /var/www -type f -exec chmod 664 {} +

COPY ./composer_download.sh /usr/local/bin
COPY ./php.ini /etc/php/7.4/apache2
RUN composer_download.sh
EXPOSE 80

CMD ["/usr/sbin/apache2ctl","-DFOREGROUND"]
