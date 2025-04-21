import { $ } from "zx";

await $`mkdir -p /var/log/nginx`;
await $`touch /var/log/nginx/error.log`;
await $`chmod 755 /var/log/nginx`;

console.log("✔️ Nginx log file created (or already exists)");
