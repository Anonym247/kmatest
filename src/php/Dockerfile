FROM php:8.0-fpm

COPY composer.json /var/www/

ARG user=www
ARG uid=1000

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    supervisor

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install mysqli pdo_mysql exif pcntl
RUN docker-php-ext-enable mysqli
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd

RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

RUN chown -R $user:$user /var/www

USER $user

CMD ["php-fpm"]

EXPOSE 9000