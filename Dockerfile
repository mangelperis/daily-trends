FROM alpine:3.9

ADD https://dl.bintray.com/php-alpine/key/php-alpine.rsa.pub /etc/apk/keys/php-alpine.rsa.pub

RUN apk --update add ca-certificates && \
    echo "https://dl.bintray.com/php-alpine/v3.9/php-7.3" >> /etc/apk/repositories

# Install packages
RUN apk --no-cache add php7 php7-fpm php7-session mysql-client php7-pdo php7-pdo_mysql php7-mysqli php7-soap php7-json php7-openssl php7-curl \
  php7-zlib php7-xml php7-phar php7-intl php7-dom php7-xmlreader php7-ctype php7-bcmath php7-sockets \
  php7-mbstring php7-gd php7-opcache php7-zip php7-iconv php7-sodium \
  nginx supervisor wget curl git bash nodejs npm nano openssh-server openssh php7-xdebug make



# Configure nginx
COPY docker/nginx.conf /etc/nginx/nginx.conf

# Configure PHP-FPM
COPY docker/www.conf /etc/php7/php-fpm.d/www.conf
COPY docker/php.ini /etc/php7/conf.d/zzz_custom.ini
COPY docker/opcache.ini /etc/php7/conf.d/opcache.ini

# xDebug
COPY docker/xdebug.ini /etc/php7/conf.d/xdebug.ini

# Configure supervisord
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
RUN mkdir -p /.composer && mkdir -p /.composer/cache && mkdir -p /.npm && mkdir -p /var/www/html

# Make sure files/folders needed by the processes are accessable when they run under the nobody user
RUN chown -R nobody:nobody /run && \
  chown -R nobody:nobody /var/lib/nginx && \
  chown -R nobody:nobody /var/tmp/nginx && \
  chown -R nobody:nobody /var/log/nginx && \
  chown -R nobody:nobody /.npm && \
  chown -R nobody:nobody /.composer

RUN ln -s /usr/bin/php7 /usr/bin/php

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer  --version=1.10.16
# Switch to use a non-root user from here on
USER nobody

# Add application
WORKDIR /var/www/html

COPY --chown=nobody ./ /var/www/html/

# Expose the port nginx is reachable on
EXPOSE 8080

# Let supervisord start nginx & php-fpm
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

# Configure a healthcheck to validate that everything is up&running
HEALTHCHECK --timeout=10s CMD curl --silent --fail http://127.0.0.1:8080/fpm-ping
