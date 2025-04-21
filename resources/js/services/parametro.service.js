export const ParametroService = {
    async general() {
        return await axios.post(`/api/virtual/parametro/general`);
    },
    async interno() {
        return await axios.post(`/api/virtual/parametro/interno`);
    },
};
