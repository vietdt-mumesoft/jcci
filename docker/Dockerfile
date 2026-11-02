FROM amazonlinux:2023

ENV TZ=Asia/Ho_Chi_Minh

# 1. Install core utilities, Apache 2.4 (httpd + mod_ssl), MariaDB 10.5 Server, and PHP 8.2.35 + extensions
RUN dnf update -y && dnf install -y --allowerasing \
    curl wget tar gzip unzip zip findutils procps-ng iproute openssl shadow-utils \
    httpd mod_ssl \
    mariadb105-server \
    php8.2 php8.2-cli php8.2-common php8.2-fpm \
    php8.2-bcmath php8.2-gd php8.2-intl php8.2-mbstring \
    php8.2-mysqlnd php8.2-opcache php8.2-pdo php8.2-soap \
    php8.2-sodium php8.2-xml php8.2-zip \
    && dnf clean all

# 2. Configure timezone
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# 3. Prepare runtime directories
RUN mkdir -p /run/php-fpm /var/run/mariadb /var/log/mariadb /etc/pki/tls/certs/jcci /var/www/jcci \
    && chown -R mysql:mysql /var/run/mariadb /var/log/mariadb /var/lib/mysql

COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN sed -i 's/\r$//' /usr/local/bin/entrypoint.sh && chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80 443
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
