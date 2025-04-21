export const SeguridadService =  {

    async listarEmpresa(cod_usuario){    
        return await axios.get(`/api/seguridad/usuarioempresa/${cod_usuario}`);               
    },

    async usuarioSistema(param){    
        return await axios.post(`/api/seguridad/usuariosistema`,param);            
    },

    async menuusuario(param){    
        return await axios.post(`/api/seguridad/menuusuario`,param);            
    },
    async storeEmpresa(param){
        return await axios.post(`/api/seguridad/store-empresa`,param);            
    },
    async storeUsuarioSistema(param){
        return await axios.post(`/api/seguridad/store-usuariosistema`,param);            
    },
    async storeMenuUsuario(param){
        return await axios.post(`/api/seguridad/store-menuusuario`,param);            
    },
    async destroyEmpresa(param){
        return await axios.post(`/api/seguridad/destroy-empresa`,param);            
    },
    async destroyUsuarioSistema(param){
        return await axios.post(`/api/seguridad/destroy-usuariosistema`,param);            
    },
    async destroyMenuUsuario(param){
        return await axios.post(`/api/seguridad/destroy-menuusuario`,param);            
    },
}