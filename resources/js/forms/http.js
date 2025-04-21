
import store from '../store'

export default {

    post(uri,form){
        return this.sendForm('post',uri,form)
    },
    get(uri,form=null){
        return this.sendForm('get',uri,form)
    },
    put(uri,form){
        return this.sendForm('put',uri,form)
    },
    delete(uri,form=null){
        return this.sendForm('delete',uri,form)
    },
    sendForm (method, uri, form) {
        return new Promise((resolve, reject) => {
            //store.commit('util/showLoader')

            window.axios[method](uri, JSON.parse(JSON.stringify(form)))
                .then(response => {
                    //store.commit('util/hideLoader')
                    //console.log('form http success')
                    resolve(response.data)
                })
                .catch(errors => {
                    //store.commit('util/hideLoader')
                    //console.log('form http error')
                    reject(errors.response.data)
                })
        })
    }

}