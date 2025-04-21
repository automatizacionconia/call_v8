export const FuncionesService = {
    
    axiosPost(url, data = [], resultado) {
        axios
          .post(url, data)
          .then((response) => {
            resultado(response.data);
          })
          .catch((error) => {
            console.log(error);
          });
      },
};