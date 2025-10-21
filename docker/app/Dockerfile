FROM php:8-apache

WORKDIR /var/www/html

# PHP で必要なライブラリをインストール
RUN apt-get update \
    && apt-get install -y libonig-dev libzip-dev unzip \
    && docker-php-ext-install mbstring zip bcmath \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# composer のインストール
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER 1

# ファイルのコピー
COPY ./src /var/www/html
COPY ./docker/app/php.ini /usr/local/etc/php/php.ini
COPY ./docker/app/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# vimのインストール
RUN apt-get update && apt-get install -y vim \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/*

# gitのインストール
RUN apt-get update && \
  apt-get install -y --no-install-recommends \
  git \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/*
RUN git config --global --add safe.directory /var/www/html

# openssh-clientのインストール(SSHの公開秘密鍵)
RUN apt-get update && apt-get install -y openssh-client \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/*

# xclipのインストール(クリップボード)
RUN apt-get update && apt-get install -y xclip \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/*

# MailHog のインストール
# sendmail_path をMailHogに向ける設定
RUN apt-get update && apt-get install -y msmtp \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/*
RUN echo "sendmail_path = /usr/bin/msmtp -t" >> /usr/local/etc/php/conf.d/mailhog.ini

# MailHogをSMTPサーバとして認識させる
RUN echo "defaults" > /etc/msmtprc \
 && echo "account default" >> /etc/msmtprc \
 && echo "host mailhog" >> /etc/msmtprc \
 && echo "port 1025" >> /etc/msmtprc \
 && echo "auto_from on" >> /etc/msmtprc \
 && echo "tls off" >> /etc/msmtprc
 
# Apache の DocumentRoot を app/public に変更
RUN sed -i 's|/var/www/html|/var/www/html/app/public|g' /etc/apache2/sites-available/000-default.conf \
 && sed -i 's|/var/www/html|/var/www/html/app/public|g' /etc/apache2/apache2.conf

