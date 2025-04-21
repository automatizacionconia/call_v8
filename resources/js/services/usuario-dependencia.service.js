export const UsuarioDependenciaService = {
  async sedesBySistemaSuperior(codSistemaSup) {
    return await axios.get(
      `/api/seguridad/usuario-dependencia-search/${codSistemaSup}/sede`
    );
  },
};
