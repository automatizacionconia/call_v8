#!/bin/sh
echo "✔️ Generando /tmp/nginx.conf a partir de nginx.template.conf"
cat > /tmp/nginx.conf << 'EOL'
worker_processes auto;
pid /tmp/nginx.pid;

events {
    worker_connections 1024;
}

http {
    include /etc/nginx/mime.types;
    default_type application/octet-stream;

    access_log /var/log/nginx/access.log;
    error_log /var/log/nginx/error.log;

    sendfile on;
    keepalive_timeout 65;
    
    server {
        listen 80;
        server_name agenteia-cc-agenteia-cc.7znyyo.easypanel.host;

        root /app/public;
        index index.php index.html;

        location / {
            try_files $uri $uri/ /index.php?$query_string;
        }

        location ~ \.php$ {
            # BEGIN reemplazo manual de fastcgi_params
            fastcgi_param QUERY_STRING       $query_string;
            fastcgi_param REQUEST_METHOD     $request_method;
            fastcgi_param CONTENT_TYPE       $content_type;
            fastcgi_param CONTENT_LENGTH     $content_length;

            fastcgi_param SCRIPT_NAME        $fastcgi_script_name;
            fastcgi_param REQUEST_URI        $request_uri;
            fastcgi_param DOCUMENT_URI       $document_uri;
            fastcgi_param DOCUMENT_ROOT      $document_root;
            fastcgi_param SERVER_PROTOCOL    $server_protocol;

            fastcgi_param HTTPS              $https if_not_empty;

            fastcgi_param GATEWAY_INTERFACE  CGI/1.1;
            fastcgi_param SERVER_SOFTWARE    nginx/$nginx_version;

            fastcgi_param REMOTE_ADDR        $remote_addr;
            fastcgi_param REMOTE_PORT        $remote_port;
            fastcgi_param SERVER_ADDR        $server_addr;
            fastcgi_param SERVER_PORT        $server_port;
            fastcgi_param SERVER_NAME        $server_name;

            fastcgi_param SCRIPT_FILENAME    $document_root$fastcgi_script_name;
            fastcgi_param REDIRECT_STATUS    200;
            # END reemplazo manual de fastcgi_params

            fastcgi_pass 127.0.0.1:9000;
            fastcgi_index index.php;
        }

        location ~ /\.ht {
            deny all;
        }
    }
}
EOL

mkdir -p /var/log/nginx
touch /var/log/nginx/error.log
chmod 755 /var/log/nginx

# Crear directorio para logs de PHP-FPM
mkdir -p /var/log/php-fpm
touch /var/log/php-fpm/error.log
chmod 755 /var/log/php-fpm
