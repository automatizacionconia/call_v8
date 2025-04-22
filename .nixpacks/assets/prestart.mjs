import { $ } from "zx";

await $`mkdir -p storage/logs`;
await $`mkdir -p bootstrap/cache`;
await $`touch storage/logs/laravel.log`;
await $`chmod -R 775 storage`;
await $`chmod -R 775 bootstrap/cache`;

console.log("✔️ storage/logs y bootstrap/cache preparados con permisos correctos");
