import { environment } from "@/environment";

const apiUrl = `${environment.apiUrl}/seguridad/usuarios`;

export const UsuariosService = {

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
  async activar(id) {
    return await axios.put(`${apiUrl}/${id}/activar`);
  }
};
