import store from "../store";

export const UtilService = {
  showErrors: function (error) {
    store.commit("util/showError", error.response.data, {
      root: true,
    });
  },
  showLoader: function () {
    store.commit("util/showLoader", null, {
      root: true,
    });
  },
  hideLoader: function () {
    store.commit("util/hideLoader", null, {
      root: true,
    });
  },
  showSnackbar: function () {
    store.commit(
      "util/showSnackbar",
      {},
      {
        root: true,
      }
    );
  },
  showAlert: function (payload) {
    store.commit("util/showAlert", payload, {
      root: true,
    });
  },
  /* Recibe objeto para validar sus nulos, 
  segundo parametro opcional, arreglo de atributos a omitir en validacion*/
  notNullsInObject: function (obj, arrAttributeOmitted = []) {
    for (const key in obj) {
      if (arrAttributeOmitted.length > 0 && arrAttributeOmitted.includes(key)) {
        continue;
      }
      if (obj[key] === null) {
        return false; // Al menos un atributo es null
      }
    }
    return true; // Ningún atributo es null
  },
};