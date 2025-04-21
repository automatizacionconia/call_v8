import store from "../store";
import { ErrorService } from "@/services/error.service";
export const UtilService = {
  showErrors: function (error) {
    let errores = ErrorService.getToArray(error);
    store.commit("alert/setErrors", errores, {
      root: true,
    });
  },
  showLoader: function () {
    store.commit("loader/setLoader", true, {
      root: true,
    });
  },
  hideLoader: function () {
    store.commit("loader/setLoader", false, {
      root: true,
    });
  },
  showSnackbar: function () {
    store.commit("snackbar/setSnackbar", true, {
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
