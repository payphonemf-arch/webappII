#!/bin/sh
set -eu

PORT="${PORT:-10000}"
# Railway injects PORT at runtime. Keep Apache's configuration in sync with it.
sed -i "s/^Listen .*/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s#<VirtualHost \*:.*>#<VirtualHost *:${PORT}>#" /etc/apache2/sites-available/000-default.conf

# Ensure CGIPassAuth, AllowOverride All, and Authorization header passing are configured
cat <<'EOF' > /etc/apache2/conf-available/railway-app.conf
<Directory /var/www/html>
    Options -Indexes +FollowSymLinks
    AllowOverride All
    Require all granted
    CGIPassAuth On
</Directory>
SetEnvIfNoCase ^Authorization$ "(.+)" HTTP_AUTHORIZATION=$1
EOF

a2enconf railway-app 2>/dev/null || true

# Ensure only mpm_prefork is loaded to avoid "More than one MPM loaded" crash
a2dismod -f mpm_event mpm_worker 2>/dev/null || true
a2enmod mpm_prefork rewrite headers 2>/dev/null || true

exec apache2-foreground
