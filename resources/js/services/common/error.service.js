export const ErrorService = {

    getToArray(error) {
        var errors = Object.values(error.response.data.errors);
        errors = errors.flat();                                              
        return errors;
    },

    getCode(error) {
        return error.response.data.code
    },
}