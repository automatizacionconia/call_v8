// import Http from "../../forms/http";
// import Ls from "../../services/ls";
// import { UtilService } from "@/services/util.service.js";

const state = {
  // me: null,
  access_token: null,
  refresh_token: null,
  expires_in: null,
  permisos: [],
  rutas: [],
  entidades: [],
  validUsuario: false,
  tipoDocumento: [],
  nombreUsuario: null,
  colorSeleccionado: '#2f4daa',
  Notificacion: [],
};

const getters = {
  getAuth: (state) => !!state.access_token,
  getToken: (state) => state.access_token,
  getMe: (state) => state.me,
  getPermisos: (state) => state.permisos,
  getRutas: (state) => state.rutas,
  getEntidades: (state) => state.entidades,
  getValidUsuario: (state) => state.validUsuario,
  getTipoDocumento: (state) => state.tipoDocumento,
  getNombreUsuario: (state) => state.nombreUsuario,
  getColorSeleccionado: (state) => state.colorSeleccionado,
  getNotificacion: (state) => state.Notificacion,
};

const actions = {
  async login({ state, commit, dispatch }, form) {
    try {
      commit("util/showLoader", null, { root: true });
      const payload = await Http.post("api/seguridad/auth/login", form);
      commit("setToken", payload.access_token);
      Ls.set("access_token", payload.access_token);
      await dispatch("fetchMe");
      await dispatch("fetchNotificacion");
      vm.$router.push({ path: "/app/home" });
      commit("util/hideLoader", null, { root: true });
    } catch (e) {
      alert(e.error.error);
      commit("util/hideLoader", null, { root: true });
      // commit('util/showError', e.response, { root: true })
    }
  },
  async logout({ commit }) {
    try {
      const payload = await Http.sendForm(
        "post",
        "api/seguridad/auth/logout",
        null
      );
      Ls.clear();
  
      commit("setMe", null);
      commit("setToken", null);
      commit("setPermisos", []);
      commit("setNombreUsuario", null);
      vm.$router.push({ path: "/" });
    } catch (e) {
      commit("util/showError", e, { root: true });
    }
  },
  async fetchMe({ commit }) {
    try {
      const payload = await axios.post("api/seguridad/auth/me");
      commit("setMe", payload.data.user);
      commit("setPermisos", payload.data.permisos);
      // commit('setRutas', payload.data.rutas)
    } catch (e) {
      console.log(e);
    }
  },
  async fetchNotificacion({ commit }) {
    try {
      const payload = await axios.post("api/notificacion/listar");
      commit("setNotificacion", payload.data.data);
    } catch (e) {
      console.log(e);
    }
  },
  async changePassword({ commit }, form) {
    try {
      commit("util/showLoader", null, { root: true });

      const payload = await Http.sendForm(
        "post",
        "api/seguridad/auth/changePassword",
        form
      );

      commit("util/showSnackbar", {}, { root: true });

      Ls.clear();
      commit("setMe", null);
      commit("setToken", null);
      commit("setPermisos", []);
      commit("setRutas", []);
      commit("util/hideLoader", null, { root: true });
      vm.$router.push({ path: "/" });
    } catch (e) {
      commit("util/hideLoader", null, { root: true });
      console.log(e);
    }
  },
  async authEntidades({ commit }, form) {
    try {
      commit("setEntidades", []);
      const payload = await axios.post("api/seguridad/auth/entidades", form);
      commit("setEntidades", payload.data.data);
    } catch (e) {
      console.log(e);
      UtilService.showErrors(e);
    }
  },

  async validUsuario({ commit }, form) {
    try {
      commit("setValidUsuario", false);
      const payload = await axios.post("api/seguridad/auth/validUsuario", form);
      commit("setValidUsuario", payload.data);
      commit("setNombreUsuario", payload.data.nombreusuario);
    } catch (e) {
      console.log(e);
      UtilService.showErrors(e);
    }
  },
  async fetchTipoDocumento({ commit }) {
    commit("setNombreUsuario", null);
    try {
      const payload = await axios.post("api/seguridad/auth/tipoDocumento");
      commit("setTipoDocumento", payload.data.data);
    } catch (e) {
      console.log(e);
      UtilService.showErrors(e);
    }
  },
  // async login({ state, commit, dispatch }, form) {
  //   try {
  //     commit("util/showLoader", null, { root: true });
  //     const payload = await Http.post("api/seguridad/auth/login", form);
  //     commit("setToken", payload.access_token);
  //     Ls.set("access_token", payload.access_token);
  //     await dispatch("fetchMe");
  //     vm.$router.push({ path: "/app/home" });
  //     commit("util/hideLoader", null, { root: true });
  //   } catch (e) {
  //     alert(e.error.error);
  //     commit("util/hideLoader", null, { root: true });
  //     // commit('util/showError', e.response, { root: true })
  //   }
  // },
  // async logout({ commit }) {
  //   try {
  //     const payload = await Http.sendForm(
  //       "post",
  //       "api/seguridad/auth/logout",
  //       null
  //     );
  //     Ls.clear();
  //     commit("setMe", null);
  //     commit("setToken", null);
  //     commit("setPermisos", []);
  //     commit("setNombreUsuario", null);
  //     vm.$router.push({ path: "/" });
  //   } catch (e) {
  //     commit("util/showError", e, { root: true });
  //   }
  // },
  // async fetchMe({ commit }) {
  //   try {
  //     const payload = await axios.post("api/seguridad/auth/me");
  //     commit("setMe", payload.data.user);
  //     commit("setPermisos", payload.data.permisos);
  //     // commit('setRutas', payload.data.rutas)
  //   } catch (e) {
  //     console.log(e);
  //   }
  // },
  // async changePassword({ commit }, form) {
  //   try {
  //     commit("util/showLoader", null, { root: true });
  //     const payload = await Http.sendForm(
  //       "post",
  //       "api/seguridad/auth/changePassword",
  //       form
  //     );
  //     commit("util/showSnackbar", {}, { root: true });
  //     Ls.clear();
  //     commit("setMe", null);
  //     commit("setToken", null);
  //     commit("setPermisos", []);
  //     commit("setRutas", []);
  //     commit("util/hideLoader", null, { root: true });
  //     vm.$router.push({ path: "/" });
  //   } catch (e) {
  //     commit("util/hideLoader", null, { root: true });
  //     console.log(e);
  //   }
  // },
  // async authEntidades({ commit }, form) {
  //   try {
  //     commit("setEntidades", []);
  //     const payload = await axios.post("api/seguridad/auth/entidades", form);
  //     commit("setEntidades", payload.data.data);
  //   } catch (e) {
  //     console.log(e);
  //     UtilService.showErrors(e);
  //   }
  // },
  // async validUsuario({ commit }, form) {
  //   try {
  //     commit("setValidUsuario", false);
  //     const payload = await axios.post("api/seguridad/auth/validUsuario", form);
  //     commit("setValidUsuario", payload.data);
  //     commit("setNombreUsuario", payload.data.nombreusuario);
  //   } catch (e) {
  //     console.log(e);
  //     UtilService.showErrors(e);
  //   }
  // },
  // async fetchTipoDocumento({ commit }) {
  //   commit("setNombreUsuario", null);
  //   try {
  //     const payload = await axios.post("api/seguridad/auth/tipoDocumento");
  //     commit("setTipoDocumento", payload.data.data);
  //   } catch (e) {
  //     console.log(e);
  //     UtilService.showErrors(e);
  //   }
  // },
};

const mutations = {
  setToken: (state, payload) => {
    state.access_token = payload;
  },
  setRefreshToken: (state, payload) => {
    state.refresh_token = payload;
  },
  setExpiration: (state, payload) => {
    state.expires_in = payload;
  },
  // setMe: (state, payload) => {
  //   state.me = payload;
  // },
  // setPermisos(state, payload) {
  //   state.permisos = payload;
  // },
  // setRutas(state, payload) {
  //   state.rutas = payload;
  // },
  // setEntidades(state, payload) {
  //   state.entidades = payload;
  // },
  // setValidUsuario(state, payload) {
  //   state.validUsuario = payload;
  // },
  // setTipoDocumento(state, payload) {
  //   state.tipoDocumento = payload;
  // },
  // setNombreUsuario(state, payload) {
  //   state.nombreUsuario = payload;
  // },
  // setColorSeleccionado(state, payload) {
  //   state.colorSeleccionado = payload;
  // },
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
};
