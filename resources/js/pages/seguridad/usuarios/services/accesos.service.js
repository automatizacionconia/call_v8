import { environment } from "@/environment";

const apiUrl = `${environment.apiUrl}/seguridad/accesos`;

export const AccesosService = {
    async index(params) {
        return await axios.get(`${apiUrl}`, {
        params: params,
        });
    },
    async store(data) {
        return axios.post(`${apiUrl}`, data);
    },
    async show(params) {
        return axios.get(`${apiUrl}/x`, { params: params });
    },
    async update(data) {
        return await axios.put(`${apiUrl}/x`, data);
    },
    async destroy(id) {
        return await axios.delete(`${apiUrl}/${id}`);
    },
    async getAccesosUsuario(usua_codigo) {
        return await axios.get(`${environment.apiUrl}/seguridad/usuarios/accesos/${usua_codigo}`);
    },
};
