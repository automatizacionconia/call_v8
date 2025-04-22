#!/bin/sh
echo "⚙️ Generando nginx.conf desde plantilla..."
mkdir -p /var/log/nginx
touch /var/log/nginx/error.log
chmod 755 /var/log/nginx

envsubst < /assets/nginx.template.conf > /tmp/nginx.conf
