FROM php:7.1-fpm

RUN DEBIAN_FRONTEND=noninteractive

# Install dotdeb repo
RUN apt-get update && apt-get install -my wget gnupg
RUN sh -c "echo 'deb http://packages.dotdeb.org jessie all' >> /etc/apt/sources.list"
RUN sh -c "echo 'deb-src http://packages.dotdeb.org jessie all' >> /etc/apt/sources.list"
RUN wget https://www.dotdeb.org/dotdeb.gpg -O - | apt-key add -
RUN wget https://nginx.org/keys/nginx_signing.key -O - | apt-key add -

 # Install required libs
 RUN apt-get update && \
    apt-get install -y \
        sudo \
        git \
        libcurl4-openssl-dev \
        libedit-dev \
        libssl-dev \
        libxml2-dev \
        libsqlite3-dev \
        sqlite3 \
        libz-dev \
        libpq-dev \
        libjpeg-dev \
        libpng-dev \
        libfreetype6-dev \
        libssl-dev \
        libmcrypt-dev \
        libjudydebian1 \
        libjudy-dev \
        cron \
        zlib1g-dev \
    && apt-get clean

#
# Configure
#
RUN docker-php-ext-configure gd \
        --enable-gd-native-ttf \
        --with-jpeg-dir=/usr/lib \
        --with-freetype-dir=/usr/include/freetype2

#
# Install extensions
#
RUN docker-php-ext-install \
        mcrypt \
        pdo_pgsql \
        pdo_sqlite \
        pcntl \
        sockets \
        bcmath \
        opcache \
        gd \
        zip

#
# Install non standard extensions
#
RUN pecl install ev
RUN pecl install -o -f redis

#
# Export configs
#
COPY ./opcache.ini /usr/local/etc/php/conf.d/opcache.ini

#
# Enable non standard extensions
#
RUN docker-php-ext-enable \
    opcache \
    redis \
    ev

#
#--------------------------------------------------------------------------
# Final Touch
#--------------------------------------------------------------------------
#

ADD ./laravel.ini /usr/local/etc/php/conf.d
ADD ./laravel.pool.conf /usr/local/etc/php-fpm.d/

RUN rm -r /var/lib/apt/lists/*
RUN rm -rf /tmp/pear


#####################################
# Crontab
#####################################
COPY ./crontab/root /var/spool/cron/crontabs/root
RUN crontab /var/spool/cron/crontabs/root

#####################################
# Composer:
#####################################

# Install composer and add its bin to the PATH.
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN echo "" >> ~/.bashrc && \
    echo 'export PATH="/var/www/mlmtradecoin/vendor/bin:$PATH"' >> ~/.bashrc

ADD ./start.sh /start.sh
RUN chmod 0755 /start.sh

WORKDIR /var/www/mlmtradecoin

RUN usermod -u 1000 www-data
#USER www-data

CMD ["/start.sh"]
EXPOSE 9000
