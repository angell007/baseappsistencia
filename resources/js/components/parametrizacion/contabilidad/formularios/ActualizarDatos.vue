<template>
  <form @submit.prevent="validarAntesDeEnviar">
    <div class="form-group" v-if="mostrarCampoConcepto">
      <label for="concepto" class="custom-label">Concepto</label>
      <input
        type="text"
        class="form-control custom-control col-md-8"
        name="concepto"
        v-validate="'required|alpha_spaces|min:3'"
        data-vv-as="Concepto"
        placeholder="Concepto"
        v-model="datos.concepto"
      >
      <small class="invalid" v-if="errors.has('concepto')">{{errors.first('concepto')}}</small>
    </div>
    <div class="form-group">
      <label for="cuenta_contable" class="custom-label">Cuenta contable</label>
      <input
        type="text"
        class="form-control custom-control col-md-8"
        name="cuenta_contable"
        v-validate="'required|numeric|min:2'"
        data-vv-as="Cuenta contable"
        placeholder="Ingrese el número de cuenta contable"
        v-model="datos.cuenta_contable"
      >
      <small
        class="invalid"
        v-if="errors.has('cuenta_contable')"
      >{{errors.first('cuenta_contable')}}</small>
    </div>

    <div class="form-group" v-if="contrapartida">
      <label for="contrapartida" class="custom-label">Contrapartida</label>
      <input
        type="text"
        class="form-control custom-control col-md-8"
        name="contrapartida"
        v-validate="'required|numeric|min:2'"
        data-vv-as="Contrapartida"
        placeholder="Ingrese el número de contrapartida"
        v-model="datos.contrapartida"
      >
      <small class="invalid" v-if="errors.has('contrapartida')">{{errors.first('contrapartida')}}</small>
    </div>

    <div class="form-group text-right">
      <button type="submit" class="btn btn-secondary raised">
        <i class="simple-icon-check"></i> Actualizar
      </button>
    </div>
  </form>
</template>

<script>
export default {
  props: {
    tablaAsociada: String,
    segmentoUrl: String,
    contrapartida: Boolean,
  },
  data() {
    return {
      datos: {
        id: '',
        concepto: '',
        cuenta_contable: '',
        contrapartida: '',
        estado: true,
      },
      baseUrl: `/api/${localStorage.getItem('tenant')}/parametrizacion/`,
      mostrarCampoConcepto: false,
    }
  },

  created() {
    if (!this.contrapartida) {
      delete this.datos.contrapartida
    }
  },

  methods: {
    async validarAntesDeEnviar() {
      let validado = await this.$validator.validateAll()
      if (validado) {
        this.actualizarDatos()
        return
      }
      this.$swal.fire(
        'Oops!',
        'Debe corregir los errores antes de enviar el formulario',
        'error'
      )
    },
    actualizarDatos() {
      const url = `${this.baseUrl}${this.segmentoUrl}/${this.datos.id}/editar`
      axios
        .put(url, this.datos)
        .then(respuesta => {
          this.finalizarGuardadoDatos(respuesta)
        })
        .catch(error => {
          this.notificarErrorServidor(error)
        })
    },
    finalizarGuardadoDatos(respuesta) {
      const evento = `actualizarTabla${this.tablaAsociada}`
      eventEmitter.$emit(evento, this.datos)
      modalEmitter.$emit('cerrar', this.$parent.id)
      this.$emit('notificar', respuesta.data.message)
    },
    notificarErrorServidor(error) {
      if (error.response) {
        this.$swal.fire(
          'Error!',
          'Ha ocurrido un error, por favor intente más tarde',
          'error'
        )
      }
    },
    limpiarDatosFormulario() {
      for (let propiedad in this.datos) {
        if (propiedad !== 'estado') {
          this.datos[propiedad] = ''
        }
      }
    },
  },
}
</script>