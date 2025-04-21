const  state = {
    arrayPermisos: [],
    arraySubSistema: [],
    selectSistema: 0,
};

const actions = {
    clearData({ commit }) {
        commit('setArrayPermisos', [])
        commit('setArraySubSistema', [])
        commit('setSelectSistema', 0)
    },
};

const getters = {
    getArrayPermisos: state => {
        return state.arrayPermisos
    },
    getArraySubSistema: state => {
        return state.arraySubSistema
    },
    getSelectSistema: state => {
        return state.selectSistema
    },


};

const mutations =  {
    setArrayPermisos(state, arrayPermisos) {
        state.arrayPermisos = arrayPermisos
    },
    setArraySubSistema(state, arraySubSistema) {
        state.arraySubSistema = arraySubSistema
    },
    setSelectSistema(state, selectSistema) {
        state.selectSistema = selectSistema
    },
};
export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};  