const state = {
  breadcrumbs: [],
  error: {
    status: false,
    errors: null,
  },
  loader: false,
  snackbar: {
    status: false,
    color: null,
    text: null,
  },
  alert: {
    status: false,
    color: null,
    text: null,
    type: null,
    redirect: null,
  },
};

const getters = {
  getBreadcrumbs: (state) => state.breadcrumbs,
  getError: (state) => state.error,
  getLoader: (state) => state.loader,
  getSnackbar: (state) => state.snackbar,
  getAlert: (state) => state.alert,
};

const actions = {
  hideError({ commit }) {
    commit("hideError");
  },
  showLoader({ commit }) {
    commit("showLoader");
  },
  hideLoader({ commit }) {
    commit("hideLoader");
  },
  hideSnackbar({ commit }) {
    commit("hideSnackbar");
  },
  hideAlert({ commit }) {
    commit("hideAlert");
  },
};

const mutations = {
  setBreadcrumbs(state, items) {
    items.unshift({ label: "Inicio", name: "/app/home" });
    state.breadcrumbs = items;
  },
  showError(state, payload) {
    state.error.errors = payload;
    state.error.status = true;
  },
  hideError(state) {
    state.error.errors = null;
    state.error.status = false;
  },
  showLoader: (state) => (state.loader = true),
  hideLoader: (state) => (state.loader = false),

  showSnackbar(state, payload) {
    state.snackbar.status = true;
    state.snackbar.color = payload.color;
    state.snackbar.text = payload.text;
  },

  hideSnackbar(state) {
    state.snackbar.status = false;
    state.snackbar.color = null;
    state.snackbar.text = null;
  },

  showAlert(state, payload) {
    state.alert.status = true;
    state.alert.color = payload.color;
    state.alert.text = payload.text;
    state.alert.type = payload.type;
    state.alert.redirect = payload.redirect;
  },

  hideAlert(state) {
    state.alert.status = false;
    state.alert.color = null;
    state.alert.text = null;
    state.alert.type = null;
    state.alert.redirect = null;
  },
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
};
