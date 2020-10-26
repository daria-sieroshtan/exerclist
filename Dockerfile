FROM ubuntu:20.04

RUN apt-get update
RUN DEBIAN_FRONTEND=noninteractive apt install -yq --no-install-recommends php php-json php-curl php-ctype php-iconv php-pdo php-mysql php-dom php-zip composer apache2 libapache2-mod-php mysql-client sudo curl wget php-intl php-mbstring

RUN wget https://get.symfony.com/cli/installer -O - | bash
RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony

COPY . /var/www/exerclist

WORKDIR /var/www/exerclist

EXPOSE 8000

RUN composer install

CMD symfony server:start
