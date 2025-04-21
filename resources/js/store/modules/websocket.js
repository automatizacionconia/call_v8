// store/websocket.js

const state = {
socket: null,
message: null
};

const mutations = {
SET_SOCKET(state, socket) {
    state.socket = socket;
},
SET_MESSAGE(state, message) {
    state.message = message;
}
};

const actions = {
initializeSocket({ commit }) {
    let url = 'wss://ws.regioncallao.gob.pe:3500/';
    const socket = new WebSocket(url);

    socket.onopen = () => {
        console.log('Socket connected');
    }
    socket.onmessage = (event) => {
        const message = JSON.parse(event.data);

        commit('SET_MESSAGE', message);
    };
    commit('SET_SOCKET', socket);
}
};

export default {
    namespaced: true,
    state,
    mutations,
    actions
};
