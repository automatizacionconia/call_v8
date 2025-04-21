import { ErrorService } from "@/services/common/error.service";

const state = {
    entidadLogoT: null,
    entidadLogo: null,
    entidadFondo: null,
    entidadManualUrl: null,
    entidadMasInformacion: null,
    entidadTerminosCondiciones: null,
    entidadMostrarAviso: null,
    entidadAviso: null,
    entidaWebUrl: null,
    entidadNombre: null,
    entidadNotificacionSgd: null,
    entidadNotificacionTc: null,
    entidadMaxFileSizeUpload: null,
};

const getters = {
    getEntidadLogoT: (state) => state.entidadLogoT,
    getEntidadLogo: (state) => state.entidadLogo,
    getEntidadFondo: (state) => state.entidadFondo,
    getEntidadManualUrl: (state) => state.entidadManualUrl,
    getEntidadMasInformacion: (state) => state.entidadMasInformacion,
    getEntidadTerminosCondiciones: (state) => state.entidadTerminosCondiciones,
    getentidadMostrarAviso: (state) => state.entidadMostrarAviso,
    getEntidadAviso: (state) => state.entidadAviso,
    getEntidaWebUrl: (state) => state.entidaWebUrl,
    getEntidadNombre: (state) => state.entidadNombre,
    getEntidadNotificacionSgd: (state) => state.entidadNotificacionSgd,
    getEntidadNotificacionTc: (state) => state.entidadNotificacionTc,
    getEntidadMaxFileSizeUpload: (state) => state.entidadMaxFileSizeUpload,
};

const actions = {
    async getParametrosGeneral({ dispatch, commit, getters, rootGetters }) {
        try {
            commit("setEntidadLogoT", payload.data.elt);
            commit("setEntidadLogo", payload.data.el);
            commit("setEntidadFondo", payload.data.ef);
            commit("setEntidadManualUrl", payload.data.emu);
            commit("setEntidadMasInformacion", payload.data.emi);
            commit("setEntidadTerminosCondiciones", payload.data.etc);
            commit("setentidadMostrarAviso", payload.data.ema);
            commit("setEntidadAviso", payload.data.ea);
            commit("setEntidaWebUrl", payload.data.ewu);
            commit("setEntidadNombre", payload.data.en);
        } catch (error) {
            commit("alert/setErrors", ErrorService.getToArray(error), {
                root: true,
            });
        }
    },
    async getParametrosInterno({ dispatch, commit, getters, rootGetters }) {
        try {
            commit("setEntidadNotificacionSgd", payload.data.nsgd);
            commit("setEntidadNotificacionTc", payload.data.ntc);
            commit("setEntidadMaxFileSizeUpload", payload.data.msfu);
        } catch (error) {
            commit("alert/setErrors", ErrorService.getToArray(error), {
                root: true,
            });
        }
    },
};

const mutations = {
    setEntidadLogoT: (state, payload) => {
        state.entidadLogoT = payload;
    },
    setEntidadLogo: (state, payload) => {
        state.entidadLogo = payload;
    },
    setEntidadFondo: (state, payload) => {
        state.entidadFondo = payload;
    },
    setEntidadManualUrl: (state, payload) => {
        state.entidadManualUrl = payload;
    },
    setEntidadMasInformacion: (state, payload) => {
        state.entidadMasInformacion = payload;
    },
    setEntidadTerminosCondiciones: (state, payload) => {
        state.entidadTerminosCondiciones = payload;
    },
    setentidadMostrarAviso: (state, payload) => {
        state.entidadMostrarAviso = payload;
    },
    setEntidadAviso: (state, payload) => {
        state.entidadAviso = payload;
    },
    setEntidaWebUrl: (state, payload) => {
        state.entidaWebUrl = payload;
    },
    setEntidadNombre: (state, payload) => {
        state.entidadNombre = payload;
    },
    setEntidadNotificacionSgd: (state, payload) => {
        state.entidadNotificacionSgd = payload;
    },
    setEntidadNotificacionTc: (state, payload) => {
        state.entidadNotificacionTc = payload;
    },
    setEntidadMaxFileSizeUpload: (state, payload) => {
        state.entidadMaxFileSizeUpload = payload;
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};
