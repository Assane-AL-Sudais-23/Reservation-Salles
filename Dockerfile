FROM php:8.2-fpm-alpine

RUN apk add --no-cache nginx supervisor mysql-dev

RUN docker-php-ext-install pdo pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . /var/www/html

COPY nginx.conf /etc/nginx/http.d/default.conf

RUN composer install --no-dev --optimize-autoloader

RUN echo '[supervisord]' > /etc/supervisord.conf && \
    echo 'nodaemon=true' >> /etc/supervisord.conf && \
    echo '[program:php-fpm]' >> /etc/supervisord.conf && \
    echo 'command=php-fpm' >> /etc/supervisord.conf && \
    echo '[program:nginx]' >> /etc/supervisord.conf && \
    echo 'command=nginx -g "daemon off;"' >> /etc/supervisord.conf

EXPOSE 10000

CMD ["sh", "-c", "php /var/www/html/bin/assane assane:execute && php /var/www/html/bin/assane assane:seed && exec /usr/bin/supervisord -c /etc/supervisord.conf"]