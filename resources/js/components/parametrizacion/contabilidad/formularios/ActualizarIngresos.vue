<template>
  <form @submit.prevent="validarAntesDeEnviar">
    <input type="hidden" v-model="datos.id">
    <div class="form-group" v-if="mostrarConcepto">
      <label for="concepto" class="custom-label">Concepto</label>
      <input
        type="text"
        class="form-control col-md-8 custom-control"
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
        class="form-control col-md-8 custom-control"
        name="cuenta_contable"
        v-validate="'required|numeric|min:2'"
        data-vv-as="Cuenta contable"
        placeholder="Número de cuenta contable"
        v-model="datos.cuenta_contable"
      >
      <small
        class="invalid"
        v-if="errors.has('cuenta_contable')"
      >{{errors.first('cuenta_contable')}}</small>
    </div>

    <div class="form-group text-right">
      <button type="submit" class="btn btn-secondary raised">
        <i class="simple-icon-check"></i> Guardar
      </button>
    </div>
  </form>
</template>

<script>
export default {
  props: { tablaAsociadaConst: String, tablaAsociadaNoConst: String },
  data() {
    return {
      datos: {
        id: '',
        concepto: '',
        tipo: '',
        cuenta_contable: '',
        estado: '',
      },
      tablaAsociada: '',
      mostrarConcepto: false,
    }
  },

  methods: {
    async validarAntesDeEnviar() {
      let validado = await this.$validator.validateAll()
      if (validado) {
        this.guardarIngreso()
        return
      }
      this.$swal.fire(
        'Oops!',
        'Debe corregir los errores antes de enviar el formulario',
        'error'
      )
    },
    guardarIngreso() {
      axios
        .put(
          `/api/${localStorage.getItem('tenant')}/parametrizacion/ingresos/${this.datos.id}/editar`,
          this.datos
        )
        .then(respuesta => {
          this.finalizarGuardadoDatos(respuesta)
        })
        .catch(error => {
          this.notificarErrorServidor(error)
        })
    },

    finalizarGuardadoDatos(respuesta) {
      this.cambiarTablaAsociada()
      const evento = `actualizarTabla${this.tablaAsociada}`
      eventEmitter.$emit(evento, this.datos)
      modalEmitter.$emit('cerrar', 'ingresos')
      this.$emit('notificar', respuesta.data.message)
    },

    notificarErrorServidor(error) {
      if (error.response) {
        this.$swal.fire(
          'Error!',
          'Han ocurrido errores, por favor intente más tarde',
          'error'
        )
      }
    },
    cambiarTablaAsociada() {
      this.datos.tipo == 'Constitutivo'
        ? (this.tablaAsociada = this.tablaAsociadaConst)
        : (this.tablaAsociada = this.tablaAsociadaNoConst)
    },
    limpiarDatosFormulario() {
      for (let propiedad in this.datos) {
        if (propiedad !== 'estado' && propiedad !== 'tipo') {
          this.datos[propiedad] = ''
        }
      }
    },
  },
}
</script>