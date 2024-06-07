ARG VERSION_PHP=php:7.2-fpm


FROM $VERSION_PHP

RUN apt-get -y update --fix-missing

RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y ca-certificates ffmpeg libwebp-dev

RUN apt-get install -y libicu-dev \
                       libzip-dev \
                       zlib1g-dev \
                       libxslt-dev \
                       libpng-dev \
                       libpq-dev \
                       libfreetype6-dev \
                       libjpeg62-turbo-dev \
                       mc \
                       gettext-base \
                       openssh-client \
                       git \
                       cron

RUN docker-php-ext-configure intl


RUN docker-php-ext-configure gd --with-freetype --with-jpeg


RUN docker-php-ext-install intl \
                           pdo_mysql \
                           gd \
                           zip \
                           xsl \
                           sockets \
                           soap \
                           iconv \
                           bcmath \
                           pdo_pgsql \
                           pgsql

RUN pecl install pcov && docker-php-ext-enable pcov

RUN pecl install xdebug && docker-php-ext-enable xdebug

RUN pecl install redis && rm -rf /tmp/pear && docker-php-ext-enable redis

RUN apt-get update && apt-get install -y libmagickwand-dev --no-install-recommends && rm -rf /var/lib/apt/lists/*
RUN printf "\n" | pecl install imagick
RUN docker-php-ext-enable imagick

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=1.10.25

RUN composer self-update --2

RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash
RUN apt install -y symfony-cli

RUN apt-get install -y libz-dev  \
                       libmemcached-dev \
                       zlib1g-dev \
                       libssl-dev \
                       memcached  \
                       libmemcached-tools


RUN pecl install memcached && docker-php-ext-enable memcached

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && sync && install-php-extensions amqp

#pcntl ext. required to laravel/pail
RUN docker-php-ext-configure pcntl --enable-pcntl && docker-php-ext-install pcntl;

#NVM to install Node 20
RUN curl -o- 'https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.7/install.sh' | bash
RUN cd ~/../root/.nvm/ && bash nvm.sh && bash -l -c "nvm install 20"

RUN apt-get update && apt-get install -y libtidy-dev && \
    docker-php-ext-install tidy