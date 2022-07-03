FROM katyusha-dev/centos:latest

# Basic
RUN dnf -y install dnf-utils yum-utils
RUN yum -y groupinstall 'Development Tools'
RUN dnf -y install zip unzip nano wget curl git tar gnupg2 wget gcc-c++ make bzip2 make java-1.8.0-openjdk curl curl-devel zlib-devel pcre-devel gcc-c++ make make
RUN dnf -y install https://dl.fedoraproject.org/pub/epel/epel-release-latest-8.noarch.rpm
RUN dnf -y install https://rpms.remirepo.net/enterprise/remi-release-8.rpm
RUN dnf -y install epel-release
RUN dnf -y install https://rpms.remirepo.net/enterprise/remi-release-8.rpm


# EPEL Release/PHP-FPM
RUN dnf -y install https://dl.fedoraproject.org/pub/epel/epel-release-latest-8.noarch.rpm
RUN dnf -y install https://rpms.remirepo.net/enterprise/remi-release-8.rpm
RUN dnf module reset php -y
RUN dnf module enable php:remi-8.1 -y
RUN dnf -y install php php-cli php-common php-fpm php-devel
RUN dnf -y install php-pear php-devel php-pecl-swoole4 php-cli php-json php-xml php-zip


# Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Node.js
RUN curl -fsSL https://rpm.nodesource.com/setup_14.x | bash -
RUN dnf -y install nodejs
RUN curl -sL https://dl.yarnpkg.com/rpm/yarn.repo | tee /etc/yum.repos.d/yarn.repo
RUN dnf -y install yarn
RUN npm -g install nodemon chokidar pm2 @vue/cli nodemon typescript ts ts-node

# Python
RUN dnf -y install python3 python3-devel python2 python2-devel


# Helpers
RUN dnf -y install epel-release

# Ports and volumes
EXPOSE 7777
VOLUME /srv
WORKDIR /srv


# Entrypoint
RUN chmod +x docker-entrypoint.sh
ENTRYPOINT ["docker-entrypoint.sh"]