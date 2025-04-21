import moment from "moment";

export const ValidacionService = {
    // ruleRequerido: (v) => !!v || "Campo requerido.",
    ruleRequerido: function (v) {
        return !!v || "Campo requerido.";
    },
    ruleOtro: function (v) {
        return !!v || "Campo requerido.";
    },
    ruleFormatoFecha(fecha, formato = null) {
        if (fecha) {
            const formatoFecha = formato ? formato : "DD/MM/YYYY";
            if (moment(fecha, formatoFecha, true).isValid()) {
                return true;
            }
            return "Formato de fecha inválido.";
        }
        return true;
    },
    ruleLongitud(v, min) {
        if (v) {
            return (v && v.length >= min) || `Mínimo ${min} caracteres`;
        }
        return true;
    },
    ruleValueIntMaximo(v, max) {
        return parseInt(v) < max || `Valor máximo ${max}`;
    },
    ruleNumerico(v) {
        if (v) {
            // Expresión regular para números
            return !isNaN(v) || "Solo números";
        }
        return true;
    },
    ruleEmail(v) {
        if (v) {
            return /.+@.+\..+/.test(v) || "Correo electrónico inválido";
        }
        return true;
    },
    ruleDateMinToday(value) {
        const selectedDate = new Date(value);
        const today = new Date();

        if (selectedDate < today) {
            return "La fecha debe ser igual o posterior a hoy.";
        }

        return true; // La validación es exitosa
    },
    rulePositiveNumber(v, withEmptyString = false) {
        if (withEmptyString) {
            return (
                v == "" ||
                v == null ||
                /^[0-9]+(\.[0-9]+)?$/.test(v) ||
                "Ingrese un número positivo"
            );
        } else {
            return (
                /^[0-9]+(\.[0-9]+)?$/.test(v) || "Ingrese un número positivo"
            );
        }
    },
    ruleTimeMinForValue(value, minTime) {
        const selectedTime = new Date(`1970-01-01T${value}`);
        const minTimeValue = new Date(`1970-01-01T${minTime}`);

        if (selectedTime < minTimeValue) {
            return "La hora debe ser igual o posterior a " + minTime;
        }

        return true; // La validación es exitosa
    },
    ruleTimeMaxForValue(value, minTime) {
        const selectedTime = new Date(`1970-01-01T${value}`);
        const minTimeValue = new Date(`1970-01-01T${minTime}`);

        if (selectedTime > minTimeValue) {
            return "La hora debe ser igual o menor a " + minTime;
        }

        return true; // La validación es exitosa
    },
    ruleDateMinForValue(value, minDate) {
        const selectedDate = new Date(value);
        const minValue = new Date(minDate);

        if (selectedDate < minValue) {
            return "La fecha debe ser igual o posterior a " + minDate;
        }

        return true; // La validación es exitosa
    },
    ruleDateMaxForValue(value, maxDate) {
        const selectedDate = new Date(value);
        const maxValue = new Date(maxDate);

        if (selectedDate > maxValue) {
            return "La fecha debe ser menor a " + maxDate;
        }

        return true; // La validación es exitosa
    },
    rulePositiveNumber(v, withEmptyString = false) {
        if (withEmptyString) {
            return (
                v == "" ||
                v == null ||
                /^[0-9]+(\.[0-9]+)?$/.test(v) ||
                "Ingrese un número positivo"
            );
        } else {
            return (
                /^[0-9]+(\.[0-9]+)?$/.test(v) || "Ingrese un número positivo"
            );
        }
    },
};
