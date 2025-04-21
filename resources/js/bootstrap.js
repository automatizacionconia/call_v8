window._ = require("lodash");
window.axios = require("axios");
window.moment = require("moment");
window.echarts = require("echarts");
import Ls from "./services/ls";
window.baseURL = document.getElementById("baseURL").value;
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
  window._token = token.content;
  window.axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
  window.axios.defaults.baseURL = document.getElementById("baseURL").value;
} else {
  console.error(
    "CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token"
  );
}

window.axios.interceptors.request.use(
  (config) => {
    let AUTH_TOKEN = Ls.get("access_token");
    
    let AUTH_CLAIMS = Ls.get("claims");
    config.headers["X-claims"] = `${AUTH_CLAIMS}`;

    if (AUTH_TOKEN) {
      config.headers["Authorization"] = `Bearer ${AUTH_TOKEN}`;
    }

    //console.log('interceptors.request success')

    return config;
  },

  (error) => {
    //console.log('interceptors.request error')
    return Promise.reject(error);
  }
);

window.axios.interceptors.response.use(
  (response) => {
    //console.log('interceptors.response sueccess')
    //phpdebugbar.ajaxHandler.handle(response.request);
    return response;
  },
  (error) => {
    if (error.response.status === 401 || error.response.status === 403) {
      Ls.clear();
      alert("Tu sesión ha expirado. Volviendo a pantalla de inicio de sesión");
      window.location.href = document.getElementById("baseURL").value;
      return;
    }

    return Promise.reject(error);
  }
);

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from "laravel-echo";

// window.Pusher = require("pusher-js");

// window.Echo = new Echo({
//     broadcaster: "pusher",
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
// });
