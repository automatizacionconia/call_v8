import Ls from "@/services/ls";
import { environment } from "@/environment";
import store from "@/store";
const apiUrl = `${environment.apiUrl}`;

export const UserService = {
  async login(data) {
    return await axios.post(`${apiUrl}/seguridad/login`, data);
  },

  async menu() {
    return await axios.get(`${apiUrl}/menu`);
  },

  async logout() {
    return await axios.post(`${apiUrl}/seguridad/logout`);
  },

  async changePassword(data) {
    return await axios.post(`${apiUrl}/seguridad/change-password`, data);
  },

  async entidades(data) {
    return await axios.post(`${apiUrl}/entidades`, data);
  },

  async changePhoto(data) {
    return await axios.post(`${apiUrl}/changePhoto`, data);
  },

  async notificacion(data) {
    return await axios.post(`${environment.apiUrl}/notificacion`, data);
  },

  async clearAccesos() {
    await store.dispatch('login/logout');
    await store.commit("user/setProfile", null);
    await store.commit("nabvar/setSelectSistema", null);
    await store.commit("nabvar/setArrayPermisos", null);
    await store.commit("nabvar/setArraySubSistema", null);
    await Ls.set("accessToken", null);
  },
  async actualizarDatos(data){
    return await axios.post(`${apiUrl}/actualizar`, data);
  },
  async actualizarNotificarme(data){
    return await axios.post(`${apiUrl}/notificarme`, data);
  },
  async solicitarCodigo(data){
    return await axios.post(`${apiUrl}/solicitar-codigo`, data);
  },
  async validarCodigo(data){
    return await axios.post(`${apiUrl}/validar-codigo`, data);
  },
  async resetPassword(model){    
    return await axios.post(`${apiUrl}/seguridad/reset-password`,model);          
},
};
