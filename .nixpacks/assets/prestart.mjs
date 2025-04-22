import { $ } from "zx";

// Crear carpetas de logs y cache de Laravel
await $`mkdir -p /app/storage/logs`;
await $`mkdir -p /app/bootstrap/cache`;

// Crear archivo de log si no existe
await $`touch /app/storage/logs/laravel.log`;

// Establecer permisos correctos
await $`chmod -R 775 /app/storage`;
await $`chmod -R 775 /app/bootstrap/cache`;

console.log("✔️ Laravel storage y cache preparados");

// Opcional: para que Nginx no falle
await $`mkdir -p /var/log/nginx`;
await $`touch /var/log/nginx/error.log`;
await $`chmod -R 755 /var/log/nginx`;

console.log("✔️ Nginx log preparado");
