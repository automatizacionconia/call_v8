import { environment } from "@/environment";

const apiUrl = `${environment.apiUrl}/shared/ubigeo`;

export const UbigeoService = {
  async index(params) {
    return await axios.get(`${apiUrl}`, { params: params });
  },
  async show(id) {
    return await axios.get(`${apiUrl}/${id}`);
  },
};
