import { environment } from "@/environment";

const apiUrl = `${environment.apiUrl}/call/cartera`;

export const CarteraService = {
  async clientes(params) {
    return await axios.get(`${apiUrl}/clientes`, {
      params: params,
    });
  },
  async agentes(params) {
    return await axios.get(`${apiUrl}/agentes`, {
      params: params,
    });
  },
  async asignados(params) {
    return await axios.get(`${apiUrl}/asignados`, {
      params: params,
    });
  },
  async llamadasTelefono(params) {
    return await axios.get(`${apiUrl}/llamadas-telefono/x`, {
      params: params,
    });
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
