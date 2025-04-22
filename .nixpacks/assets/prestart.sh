#!/bin/sh
echo "✔️ Copiando nginx.template.conf a /tmp/nginx.conf directamente (sin envsubst)"
cp /assets/nginx.template.conf /tmp/nginx.conf
mkdir -p /var/log/nginx
touch /var/log/nginx/error.log
chmod 755 /var/log/nginx




