import { environment } from "@/environment";

const apiUrl = `${environment.apiUrl}/call/cliente`;

export const CargaMasivaService = {
  async index(params) {
    return await axios.get(`${apiUrl}`, {
      params: params,
    });
  },
  async store(data) {
    return axios.post(`${apiUrl}/cargar-masiva`, data);
  },
  async getFileTemplate() {
    return axios.get(`${apiUrl}/download-template`, { responseType: "blob" });
  }
};
