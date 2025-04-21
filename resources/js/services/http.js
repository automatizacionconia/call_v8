import store from '../store';

export default {
    post(uri, form) {
        return this.sendForm('post', uri, form)
    },
    get(uri, form = null) {
        return this.sendForm('get', uri, form)
    },
    put(uri, form) {
        return this.sendForm('put', uri, form)
    },
    delete(uri, form = null) {
        return this.sendForm('delete', uri, form)
    },
    sendForm(method, uri, form) {
        return new Promise((resolve, reject) => {

            store.dispatch('loading/showLoader', null, { root: true })

            window.axios[method](uri, JSON.parse(JSON.stringify(form)))
                .then(response => {

                    store.dispatch('loading/hideLoader', null, { root: true })

                    resolve(response.data)
                })
                .catch(errors => {
                    store.dispatch('loading/hideLoader', null, { root: true })

                    if (errors.response.status != 401) {
                        store.dispatch('alert/showErrors', errors.response.data, { root: true })
                    }
                    reject(errors.response.data)
                })
        })
    }

}