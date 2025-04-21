export const AdministradoRemitoService = {
    async index(params) {
        return await axios.get(`/administrado/remito`, { params: params });
    },

    async edit(id) {
        return await axios.get(`/administrado/remito/${id}/edit`);
    },

    async store(model) {
        return await axios.post(`/administrado/remito`, model);
    },

    async update(model) {
        return await axios.put(`/administrado/remito/${model.id}`, model);
    },

    async storeOrUpdateLink(model) {
        return await axios.post(
            `/administrado/remito/${model.id}/store_update_link`,
            model
        );
    },

    async confirmar(id) {
        return await axios.post(`/administrado/remito/${id}/confirmar`);
    },

    async subsanar(id) {
        return await axios.post(`/administrado/remito/${id}/subsanar`);
    },

    async estadosRemito() {
        return await axios.get(`/administrado/remito/estado`);
    },

    async eliminar(id) {
        return await axios.delete(`/administrado/remito/${id}`);
    },

    async solicitarCodigo(model) {
        return await axios.post(
            `/administrado/remito/${model.id}/solicitarCodigo`,
            model
        );
    },

    async verificarCodigo(model) {
        return await axios.post(
            `/administrado/remito/${model.id}/verificarCodigo`,
            model
        );
    },

    async noNotificar(model) {
        return await axios.post(
            `/administrado/remito/${model.id}/noNotificar`,
            model
        );
    },
};