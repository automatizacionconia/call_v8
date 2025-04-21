import { environment } from "@/environment";

const apiUrl = `${environment.apiUrl}/seguridad/perfil`;

export const RolesService = {
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
  async getAccesosUsuario(perf_codigo) {
    return await axios.get(`${apiUrl}/accesos/${perf_codigo}`);
  },
  async storeAccesos(data) {
    return await axios.post(`${apiUrl}/accesos/store`, data);
  }
};
