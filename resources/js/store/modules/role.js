import Http from "../../forms/http";
const state = {
    items: [],
    model: {},
    modelName: "api/role",
};
const getters = {
    getItems: (state) => state.items,
    getModel: (state) => state.model,
};

const actions = {
    async index({ state, commit }) {
        try {
            const payload = await Http.get(state.modelName);
            commit("setitems", payload);
        } catch (e) {
            commit("util/showError", e, { root: true });
        }
    },

    async store({ state, commit }, form) {
        try {
            const payload = await Http.post(state.modelName, form);
            commit("setModel", payload);
        } catch (e) {
            commit("util/showError", e, { root: true });
        }
    },

    async edit({ state, commit }, form) {
        try {
            const payload = await Http.get(
                `${state.modelName}/${form.id}/edit`
            );
            commit("setModel", payload);
        } catch (e) {
            commit("util/showError", e, { root: true });
        }
    },

    async update({ state, commit }, form) {
        try {
            const payload = await Http.put(
                `${state.modelName}/${form.id}`,
                form
            );
            commit("setModel", payload);
        } catch (e) {
            commit("util/showError", e, { root: true });
        }
    },

    async destroy({ state, commit }, form) {
        try {
            const payload = await Http.delete(`${state.modelName}/${form.id}`);
            commit("setModel", {});
        } catch (e) {
            commit("util/showError", e, { root: true });
        }
    },
};

const mutations = {
    setitems(state, payload) {
        state.items = payload;
    },
    setModel(state, payload) {
        state.model = payload;
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};
