const state = {
    filters: {
        page: 1,
        perPage: 10,
        codSistemaSup: null,
    },
    keys: {},
    filtersAplicados: null,
    filtersCustom: {},
    filtersSecundario: {
        page: 1,
        perPage: 10,
        codSistemaSup: null,
    },
    keysSecundario: {},
};

const getters = {
    getFilters: (state) => state.filters,
    getKeys: (state) => state.keys,
    getFiltersSecundario: (state) => state.filtersSecundario,
    getKeysSecundario: (state) => state.keysSecundario,
    getFiltersAplicados: (state) => state.filtersAplicados,
    getFiltersCustom: (state) => state.filtersCustom,
    getFiltersV1: function (state) {
        let filterAll = {
        ...state.filters,
        ...state.keys,
        ...state.filtersAplicados,
        ...state.filtersCustom,
        };
        return filterAll;
    },
};

const actions = {
    clear({ state, commit, dispatch }) {
        dispatch("clearFilters");
        dispatch("clearKeys");
        dispatch("clearFiltersSecundario");
        dispatch("clearKeysSecundario");
        dispatch("clearFiltersAplicados");
        dispatch("clearFiltersCustom");
    },
    clearFilters({ state, commit }) {
        commit("setFilters", { page: 1, perPage: 10, codSistemaSup: null });
    },
    clearKeys({ state, commit }) {
        commit("setKeys", {});
    },
    clearFiltersSecundario({ state, commit }) {
        commit("setFiltersSecundario", {
        page: 1,
        perPage: 10,
        codSistemaSup: null,
        });
    },
    clearKeysSecundario({ state, commit }) {
        commit("setKeysSecundario", {});
    },
    clearFiltersAplicados({ state, commit }) {
        commit("setFiltersAplicados", {});
    },
    clearFiltersCustom({ state, commit }) {
        commit("setFiltersCustom", {});
    },
    clearCodSistemaSup({ state, commit }) {
        commit("setCodSistemaSup", null);
    },
    search({ state, commit }) {
        let params = {
        ...state.filters,
        ...state.keys,
        ...state.filtersAplicados,
        ...state.filtersCustom,
        };

        commit("setFilters", params);
    },
};

const mutations = {
    setFilters(state, payload) {
        state.filters = payload;
    },
    setKeys(state, payload) {
        state.keys = payload;
    },
    setFiltersSecundario(state, payload) {
        state.filtersSecundario = payload;
    },
    setKeysSecundario(state, payload) {
        state.keysSecundario = payload;
    },
    setFiltersAplicados(state, payload) {
        state.filtersAplicados = payload;
    },
    setFiltersCustom(state, payload) {
        state.filtersCustom = payload;
    },
};

export default {
namespaced: true,
state,
getters,
actions,
mutations,
};
