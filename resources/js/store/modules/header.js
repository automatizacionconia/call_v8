const state = {
    selectSistema: 0,
};
const actions = {
    setSelectSistema({ commit }, selectSistema) {
        commit('setSelectSistema', selectSistema)
    }
};
const getters = {
    getSelectSistema: (state) => state.selectSistema
};
const mutations = {
    setSelectSistema(state, selectSistema) {
        state.selectSistema = selectSistema
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};