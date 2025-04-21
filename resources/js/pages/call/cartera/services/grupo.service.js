import { environment } from "@/environment";

const apiUrl = `${environment.apiUrl}/call/grupo`;

export const GrupoService = {
    async index(params) {
        return axios.get(`${apiUrl}`, { params: params });
    },
    async store(data) {
        return axios.post(`${apiUrl}/store`, data);
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
};
