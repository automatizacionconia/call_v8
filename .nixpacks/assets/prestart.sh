#!/bin/sh

echo "➤ Creando archivo de log para Nginx..."
mkdir -p /var/log/nginx
touch /var/log/nginx/error.log
chmod 755 /var/log/nginx
