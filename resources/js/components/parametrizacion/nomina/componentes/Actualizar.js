export class Actualizar {
    
    constructor (parametro) {
        this.parametro = parametro
    }

    registrarAlerta(alerta ={}) {
        this.alerta = alerta
    }

    actualizar(url) {
        this.alerta.fire({
            title: '¿Está seguro?',
            text: "Esta afectará los cálculos al momento de pagar nómina!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, actualizar!',
            cancelButtonText: 'Cancelar'
        }).then (resultado => {
            if (resultado.value) {
                axios.put(url, this.parametro).then(respuesta => {
                    this.alerta.fire('Correcto!',respuesta.data.message,'success')
                })
            }
        })
    }
}