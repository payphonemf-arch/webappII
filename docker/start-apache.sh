#!/bin/sh
set -eu

PORT="${PORT:-10000}"
# Railway injects PORT at runtime. Keep Apache's configuration in sync with it.
sed -i "s/^Listen .*/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s#<VirtualHost \*:.*>#<VirtualHost *:${PORT}>#" /etc/apache2/sites-available/000-default.conf

# Ensure only mpm_prefork is loaded to avoid "More than one MPM loaded" crash
a2dismod -f mpm_event mpm_worker 2>/dev/null || true
a2enmod mpm_prefork 2>/dev/null || true

exec apache2-foreground

