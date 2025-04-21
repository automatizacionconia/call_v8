const state = {
    alert: false,
    errors: []

}

const getters = {   
    getAlert: state => state.alert,
    getErrors: state => state.errors,
}

const actions = {
    
}

const mutations = {    
    setAlert: (state, payload) => {
        state.alert = payload
    }, 
    setErrors: (state, payload) => {
        state.errors = payload
        state.alert = true;
    },
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}