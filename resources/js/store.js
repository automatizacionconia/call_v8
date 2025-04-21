import Vue from "vue";
import Vuex from "vuex";
import createPersistedState from "vuex-persistedstate";
Vue.use(Vuex);

import util from "./store/modules/util";
import user from "./store/modules/user";
import navbar from "./store/modules/navbar";
import header from "./store/modules/header";

import app from "./store/modules/app";
import alert from "./store/modules/alert";
import loader from "./store/modules/loader";
import snackbar from "./store/modules/snackbar";
import color from "./store/modules/color";
import filter from "./store/modules/filter";
import parametro from "./store/modules/parametro";
import websocket from "./store/modules/websocket";

export default new Vuex.Store({
  modules: {
    util,
    user,
    navbar,
    header,

    app,
    alert,
    loader,
    snackbar,
    color,
    filter,
    parametro,
    websocket,
  },
  plugins: [
    createPersistedState({
      /* Check All Options You Can Pass At this Link */
      /* https://github.com/robinvdvleuten/vuex-persistedstate#createpersistedstateoptions */
      key: "vuex",
      // Declare All The State We Want to Persist (use dot anotation for object.key)
      paths: ["color", "navbar", "user", "header"],
    }),
  ],
});
