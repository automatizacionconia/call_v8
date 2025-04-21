const state = {
  profile: {},
  menus: [],
  entidades: [],
  colorSeleccionado: null,
  color: null,
  notificacion: null,
  AvisoLeido: false,
  Notificarme: false,
};

const getters = {
  getProfile: (state) => state.profile,
  getMenus: (state) => state.menus,
  getEntidades: (state) => state.entidades,
  getColorSeleccionado: (state) => state.colorSeleccionado,
  getColor: (state) => state.color,
  getNotificacion: (state) => state.notificacion,
  getAvisoLeido: (state) => state.AvisoLeido,
  getNotificarme: (state) => state.Notificarme,
};

const actions = {
  clear({ state, commit }) {
    commit("setProfile", {});
    commit("setMenus", []);
    commit("setEntidades", []);
    commit("setNotificacion", null);
    commit("setAvisoLeido", false);
  },
};

const mutations = {
  setProfile: (state, payload) => {
    state.profile = payload;
  },
  setMenus(state, payload) {
    state.menus = payload;
  },
  setEntidades(state, payload) {
    state.entidades = payload;
  },
  setColorSeleccionado(state, payload) {
    state.colorSeleccionado = payload;
  },
  setColor(state, payload) {
    state.color = payload;
  },
  setNotificacion(state, payload) {
    state.notificacion = payload;
  },
  setAvisoLeido(state, payload) {
    state.AvisoLeido = payload;
  },
  setNotificarme: (state, payload) => {
    state.profile.notificarme = payload;
  },
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
};
