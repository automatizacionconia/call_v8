const state = {
  drawer: true,
  innerDrawerVisible: true,
  modoOscuro: JSON.parse(localStorage.getItem("modoOscuro")) || false,
};
// this.$vuetify.theme.dark = !this.$vuetify.theme.dark;
const getters = {
  getDrawer: (state) => state.drawer,
  getInnerDrawerVisible: (state) => state.innerDrawerVisible,
  getModoOscuro: (state) => state.modoOscuro,
};

const actions = {};

const mutations = {
  setDrawer: (state, payload) => {
    if (state.drawer !== payload) {
        state.drawer = payload;
    }
  },
  setInnerDrawerVisible: (state, payload) => {
    state.innerDrawerVisible = payload;
  },
  setModoOscuro: (state, payload) => {
    state.modoOscuro = payload;
    localStorage.setItem("modoOscuro", JSON.stringify(payload));
  },
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
};
