const state = {
    loader: false,    
}

const getters = {   
    getLoader: state => state.loader,    
}

const actions = {
    
}

const mutations = {    
    setLoader: (state, payload) => {
        state.loader = payload
    },    
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}