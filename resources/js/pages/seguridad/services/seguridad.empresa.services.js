export const SeguridadEmpresaService =  {

    async sistemaEmpresa(cod_emp){    
        return await axios.get(`/api/seguridad/sistema-empresa/${cod_emp}`);               
    },

    async sistemaMenuEmpresa(param){    
        return await axios.post(`/api/seguridad/sistema-menu-empresa`,param);            
    },

    async storeSistemaEmpresa(param){
        return await axios.post(`/api/seguridad/store-sistema-empresa`,param);            
    },
    async storeSistemaMenuEmpresa(param){
        return await axios.post(`/api/seguridad/store-sistema-menu-empresa`,param);            
    },

    async destroySistemaEmpresa(param){
        return await axios.post(`/api/seguridad/destroy-sistema-empresa`,param);            
    },
    async destroySistemaMenuEmpresa(param){
        return await axios.post(`/api/seguridad/destroy-sistema-menu-empresa`,param);            
    },

}