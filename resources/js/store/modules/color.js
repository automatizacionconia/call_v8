const state = {
  color: {
    alpha: 1,
    hex: "#114479",
    hexa: "#114479FF",
    hsla: {
      h: 230.84745762711864,
      s: 0.48360655737704916,
      l: 0.47843137254901963,
      a: 1,
    },
    hsva: {
      h: 230.84745762711864,
      s: 0.6519337016574586,
      v: 0.7098039215686275,
      a: 1,
    },
    hue: 230.84745762711864,
    rgba: { r: 63, g: 81, b: 181, a: 1 },
  },
  colorEntidad: "#114479",
  colorMain: null,
  colorCard: null,
};

const getters = {
  getColor: (state) => state.color,
  getColorEntidad: (state) => state.colorEntidad,
  getColorMain: (state) => state.colorMain,
  getColorCard: (state) => state.colorCard,
};

const actions = {
  clear({ state, commit, dispatch }) {},
  changeColor({ state, commit, dispatch }, payload) {
    commit("setColor", payload);
    commit("setColorEntidad", state.color.hex);
    dispatch("loadColor");
  },
  loadColor({ state, commit }) {
    const color = state.colorEntidad;
    const colorMain = `rgba(${parseInt(color.substring(1, 3), 16)},${parseInt(
      color.substring(3, 5),
      16
    )},${parseInt(color.substring(5, 7), 16)}, 0.03)`;

    commit("setColorMain", colorMain);

    const colorCard = `rgba(${parseInt(color.substring(1, 3), 16)},${parseInt(
      color.substring(3, 5),
      16
    )},${parseInt(color.substring(5, 7), 16)}, 0.2)`;
    commit("setColorCard", colorCard);
  },
  resetColor({ commit }) {
    const defaultColor = {
      alpha: 1,
      hex: "#0A4B82",
      hexa: "#0A4B82FF",
      hsla: {
        h: 210,
        s: 1,
        l: 0.5,
        a: 1,
      },
      hsva: {
        h: 210,
        s: 1,
        v: 0.5,
        a: 1,
      },
      hue: 210,
      rgba: { r: 10, g: 75, b: 130, a: 1 },
    };

    commit("setColor", defaultColor);
    commit("setColorEntidad", defaultColor.hex);
    commit("setColorMain", `rgba(10, 75, 130, 0.03)`);
    commit("setColorCard", `rgba(10, 75, 130, 0.2)`);
  },
};

const mutations = {
  setColor(state, payload) {
    state.color = payload;
  },
  setColorEntidad(state, payload) {
    state.colorEntidad = payload;
  },
  setColorMain(state, payload) {
    state.colorMain = payload;
  },
  setColorCard(state, payload) {
    state.colorCard = payload;
  },
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
};