import { $ } from "zx";

// Crea carpetas necesarias
await $`mkdir -p /app/storage/logs`;
await $`mkdir -p /app/bootstrap/cache`;

// Asigna permisos para escritura
await $`chmod -R 775 /app/storage`;
await $`chmod -R 775 /app/bootstrap/cache`;

// Asegura permisos de ejecución para prestart.sh
await $`chmod +x /assets/prestart.sh`;

console.log("✅ Directorios creados, permisos aplicados y script listo para ejecutarse");
