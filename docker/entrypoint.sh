#!/usr/bin/env bash
set -euo pipefail

echo "============================================================"
echo "[Entrypoint] Starting JCCI Amazon Linux 2023 initialization"
echo "============================================================"

# ------------------------------------------------------------------
# 1. Configure Apache 2.4, SSL Certificates & PHP 8.2.35 INI
# ------------------------------------------------------------------
echo "[1/4] Configuring Apache 2.4, SSL certificates, and PHP 8.2.35..."
mkdir -p /etc/pki/tls/certs/jcci
cp -f /backups/configs/ssl/* /etc/pki/tls/certs/jcci/
sed -i '1s/^\xEF\xBB\xBF//; s/\r$//' /etc/pki/tls/certs/jcci/*
chmod 600 /etc/pki/tls/certs/jcci/star_jcci_vn.key

# Strip default <VirtualHost _default_:443> block from ssl.conf while keeping Listen 443 & global SSL settings
if [ -f /etc/httpd/conf.d/ssl.conf ]; then
    sed -i '/<VirtualHost _default_:443>/,/<\/VirtualHost>/d' /etc/httpd/conf.d/ssl.conf
fi
rm -f /etc/httpd/conf.d/welcome.conf

cp -f /backups/configs/apache/jcci.conf /etc/httpd/conf.d/jcci.conf
sed -i '1s/^\xEF\xBB\xBF//; s/\r$//' /etc/httpd/conf.d/jcci.conf
echo "ServerName jcci.test" > /etc/httpd/conf.d/servername.conf

# Apply Laragon-identical PHP 8.2.35 settings
cp -f /backups/configs/php/99-jcci.ini /etc/php.d/99-jcci.ini
sed -i '1s/^\xEF\xBB\xBF//; s/\r$//' /etc/php.d/99-jcci.ini

# Configure PHP-FPM socket permissions for Apache and allow WP_DEBUG_LOG to write to wp-content/debug.log
mkdir -p /run/php-fpm
if [ -f /etc/php-fpm.d/www.conf ]; then
    sed -i 's/^;*listen.owner\s*=.*/listen.owner = apache/' /etc/php-fpm.d/www.conf
    sed -i 's/^;*listen.group\s*=.*/listen.group = apache/' /etc/php-fpm.d/www.conf
    sed -i 's/^;*listen.mode\s*=.*/listen.mode = 0660/' /etc/php-fpm.d/www.conf
    sed -i 's|^php_admin_value\[error_log\].*|php_value[error_log] = /var/www/jcci/wp-content/debug.log|' /etc/php-fpm.d/www.conf
fi

# ------------------------------------------------------------------
# 2. Verify / Extract WordPress 6.5.5 Source Code & Permissions
# ------------------------------------------------------------------
mkdir -p /var/www/jcci
if [ ! -f /var/www/jcci/wp-config.php ] && [ -f /backups/web/jcci_files.tar.gz ]; then
    echo "[2/4] Extracting /backups/web/jcci_files.tar.gz to /var/www/jcci..."
    tar -xzf /backups/web/jcci_files.tar.gz -C /var/www/jcci
else
    echo "[2/4] WordPress 6.5.5 source code present in /var/www/jcci."
fi

if [ -f /backups/configs/apache/wordpress.htaccess ]; then
    cp -f /backups/configs/apache/wordpress.htaccess /var/www/jcci/.htaccess
    sed -i '1s/^\xEF\xBB\xBF//; s/\r$//' /var/www/jcci/.htaccess
fi

mkdir -p /var/www/jcci/wp-content/cache
touch /var/www/jcci/wp-content/debug.log
chown -R apache:apache /var/www/jcci/wp-content/cache /var/www/jcci/wp-content/debug.log || true
chmod 666 /var/www/jcci/wp-content/debug.log || true
chmod -R 777 /var/www/jcci/wp-content/cache || true

# ------------------------------------------------------------------
# 3. Start MariaDB/MySQL & Import Master Database (jcci)
# ------------------------------------------------------------------
echo "[3/4] Starting database server & configuring database jcci..."
mkdir -p /var/run/mariadb /var/log/mariadb /var/lib/mysql
chown -R mysql:mysql /var/run/mariadb /var/log/mariadb /var/lib/mysql

if [ ! -d /var/lib/mysql/mysql ]; then
    echo "[3/4] Initializing MariaDB data directory..."
    mysql_install_db --user=mysql --datadir=/var/lib/mysql >/dev/null
fi

if ! pgrep -x mariadbd >/dev/null 2>&1 && ! pgrep -x mysqld >/dev/null 2>&1; then
    /usr/libexec/mariadbd --user=mysql --datadir=/var/lib/mysql --socket=/var/lib/mysql/mysql.sock &
fi

for i in $(seq 1 30); do
    if mysqladmin ping --silent >/dev/null 2>&1; then
        break
    fi
    sleep 1
done

mysql -u root <<EOF
CREATE DATABASE IF NOT EXISTS \`jcci\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER USER 'root'@'localhost' IDENTIFIED VIA mysql_native_password USING PASSWORD('');
CREATE USER IF NOT EXISTS 'root'@'127.0.0.1' IDENTIFIED BY '';
GRANT ALL PRIVILEGES ON *.* TO 'root'@'localhost' WITH GRANT OPTION;
GRANT ALL PRIVILEGES ON *.* TO 'root'@'127.0.0.1' WITH GRANT OPTION;
FLUSH PRIVILEGES;
EOF

TABLE_COUNT=$(mysql -u root -N -s -e "SELECT COUNT(*) FROM information_schema.TABLES WHERE table_schema='jcci';")
if [ "${TABLE_COUNT}" -eq 0 ]; then
    if [ -f /backups/db/jcci_master.sql ]; then
        echo "[3/4] Importing /backups/db/jcci_master.sql into database jcci..."
        mysql -u root --default-character-set=utf8mb4 jcci < /backups/db/jcci_master.sql
        echo "[3/4] Database import complete."
    elif [ -f /backups/db/jcci_master.sql.gz ]; then
        echo "[3/4] Importing /backups/db/jcci_master.sql.gz into database jcci..."
        zcat /backups/db/jcci_master.sql.gz | mysql -u root --default-character-set=utf8mb4 jcci
        echo "[3/4] Database import complete."
    fi
else
    echo "[3/4] Database jcci already populated (${TABLE_COUNT} tables)."
fi

# ------------------------------------------------------------------
# 4. Start PHP-FPM & Apache 2.4 in Foreground
# ------------------------------------------------------------------
echo "[4/4] Starting PHP-FPM 8.2.35 and Apache 2.4 in foreground..."
rm -f /run/php-fpm/php-fpm.pid
/usr/sbin/php-fpm --daemonize
exec /usr/sbin/httpd -D FOREGROUND
