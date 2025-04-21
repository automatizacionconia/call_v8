export const PideService = {
    async consultaReniec(params) {
        return await axios.get(`/api/virtual/pide/reniec`, { params: params });
    },
    
};
