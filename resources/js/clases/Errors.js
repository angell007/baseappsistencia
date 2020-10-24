/** Clase para hacer el la validación de los errores - Inglés - Si se prefiere se puede traducir */
export default class Errors {

    constructor() {
        this.errors = {}
    }

    hasError(property) {
        return this.errors.hasOwnProperty(property)
    }

    getError (property) {
        if (this.errors[property]) {

            return this.errors[property][0]
        }
    }

    any() {
        let size = 0, key;
        for (key in this.errors) {
            if (this.errors.hasOwnProperty(key)) size++;
        }
        return size > 0;
    }

    add(errors) {
        this.errors = errors
    }

    cleanErrors(property) {
        if (this.errors[property]) {
            delete this.errors[property][0]
        }
    }

    cleanAllErrors() {
        this.errors = {}
    }
}