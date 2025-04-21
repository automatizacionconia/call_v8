import { environment } from "@/environment";

const apiUrl = `${environment.apiUrl}/seguridad/opciones`;

export const OpcionesService = {
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
  async getMenus(params) {
    return await axios.get(`${apiUrl}/getmenus`, { params: params });
  },
};
