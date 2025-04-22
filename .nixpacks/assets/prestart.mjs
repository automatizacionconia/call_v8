import { $ } from "zx";

// Carpetas Laravel
await $`mkdir -p /app/storage/logs`;
await $`mkdir -p /app/bootstrap/cache`;
await $`touch /app/storage/logs/laravel.log`;

// ⚠️ Permisos máximos (solo temporalmente, para validar que Laravel puede escribir)
await $`chmod -R 777 /app/storage`;
await $`chmod -R 777 /app/bootstrap/cache`;

console.log("✔️ Laravel storage y cache creados con permisos 777");

// NGINX logs
await $`mkdir -p /var/log/nginx`;
await $`touch /var/log/nginx/error.log`;
await $`chmod -R 755 /var/log/nginx`;



console.log("✔️ Nginx logs OK");
