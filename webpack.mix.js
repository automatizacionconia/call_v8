const mix = require("laravel-mix");
const path = require("path");

mix
  .js("resources/js/app.js", "public/js/app.js")
  .vue()  // Agregar esta línea para habilitar Vue
  .sass("resources/sass/app.scss", "public/css/app.css")
  .extract([
    "vue",
    "vuex",
    "vue-router",
    "axios",
    "lodash",
    "vuetify",
    "moment",
    "laravel-echo",
    "pusher-js",
  ])
  .options({
    processCssUrls: false,
  })
  .webpackConfig({
    resolve: {
      alias: {
        '@': path.resolve(__dirname, 'resources/js'),
      },
      extensions: ['.js', '.vue', '.json'],  // Asegúrate de agregar '.vue'
    },
  });

if (mix.inProduction()) {
  mix.version();
}
