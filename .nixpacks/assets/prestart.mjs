import { $ } from "zx";

// Crear carpeta y archivo para los logs de Nginx
await $`mkdir -p /var/log/nginx`;
await $`touch /var/log/nginx/error.log`;
await $`chmod -R 755 /var/log/nginx`;
console.log("✔️ Nginx log folder and file created");

// Crear carpetas necesarias para Laravel
await $`mkdir -p storage/logs`;
await $`mkdir -p bootstrap/cache`;
await $`touch storage/logs/laravel.log`;
await $`chmod -R 775 storage`;
await $`chmod -R 775 bootstrap/cache`;
console.log("✔️ Laravel folders created and permissions set");
