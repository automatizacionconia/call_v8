const state = {
    snackbar: false,    
}

const getters = {   
    getSnackbar: state => state.snackbar,    
}

const actions = {
    
}

const mutations = {    
    setSnackbar: (state, payload) => {
        state.snackbar = payload
    },    
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}