FROM php:5.5
MAINTAINER Filipe Silva <silvam.filipe@gmail.com>

COPY bin/* /usr/local/bin/

ENV USE_XDEBUG no
ENV XDEBUG_VERSION 2.4.0

RUN docker-php-pecl-install xdebug-$XDEBUG_VERSION && \
    echo "xdebug.remote_enable=on\nxdebug.remote_connect_back=on" > /usr/local/etc/php/conf.d/xdebug.ini && \
    mkdir -p /usr/local/etc/php/xdebug.d && \
    mv /usr/local/etc/php/conf.d/*xdebug.ini /usr/local/etc/php/xdebug.d/

# Grab gosu for easy step-down from root
ENV GOSU_VERSION 1.7
RUN set -x \
    && curl -sSLo /usr/local/bin/gosu "https://github.com/tianon/gosu/releases/download/$GOSU_VERSION/gosu-$(dpkg --print-architecture)" \
    && curl -sSLo /usr/local/bin/gosu.asc "https://github.com/tianon/gosu/releases/download/$GOSU_VERSION/gosu-$(dpkg --print-architecture).asc" \
    && export GNUPGHOME="$(mktemp -d)" \
    && gpg --keyserver ha.pool.sks-keyservers.net --recv-keys B42F6819007F00F88E364FD4036A9C25BF357DD4 \
    && gpg --batch --verify /usr/local/bin/gosu.asc /usr/local/bin/gosu \
    && rm -r "$GNUPGHOME" /usr/local/bin/gosu.asc \
    && chmod +x /usr/local/bin/gosu \
    && gosu nobody true

ENV COMPOSER_HOME /var/www/.composer
ENV COMPOSER_VERSION 1.0.0
ENV PATH vendor/bin:$COMPOSER_HOME/vendor/bin:$PATH
RUN curl -sS https://getcomposer.org/installer | php -- \
      --install-dir=/usr/local/bin \
      --filename=composer \
      --version=${COMPOSER_VERSION}
RUN mkdir -p $COMPOSER_HOME/cache && \
    chown -R www-data:www-data /var/www && \
    echo "phar.readonly = off" > /usr/local/etc/php/conf.d/phar.ini
VOLUME $COMPOSER_HOME/cache

# Needed for composer
RUN apt-install git rsync zlib1g-dev && \
    docker-php-ext-install zip

WORKDIR /var/www/html

# Add configs
COPY etc/*.ini /usr/local/etc/php/

RUN cd /usr/local/etc/php && cp prod.ini conf.d/environment.ini

# Add entrypoint
COPY init.d /docker-entrypoint-init.d/
COPY docker-entrypoint.sh /
ENTRYPOINT ["/docker-entrypoint.sh"]