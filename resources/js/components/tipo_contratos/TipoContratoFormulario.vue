<template>
  <form @submit.prevent="validarAntesDeEnviar">
    <input type="hidden" v-model="lista.id">
    <div class="form-group row">
      <label for="nombre" class="custom-label col-form-label col-md-4">Tipo de contrato</label>
      <input
        type="text"
        class="form-control custom-control col-md-6"
        name="nombre"
        v-validate="'required|min:3'"
        placeholder="Nombre"
        v-model="lista.nombre"
      >
      <small
        class="invalid col-md-6 offset-4"
        v-if="errors.has('nombre')"
      >{{errors.first('nombre')}}</small>
    </div>
    <div class="form-group text-right">
      <button type="submit" class="btn btn-secondary raised">Guardar</button>
    </div>
  </form>
</template>

<script>
export default {
  data() {
    return {
      lista: {
        id: '',
        nombre: '',
        editable: true,
      },
    }
  },
  methods: {
    async validarAntesDeEnviar() {
      let validado = await this.$validator.validateAll()
      if (validado) {
        this.makeRequest()
        return
      }
      this.$swal.fire(
        'Oops!',
        'Debe corregir los errores antes de enviar',
        'error'
      )
    },
    makeRequest() {
      if (!this.lista.id) {
        this.postContrato()
      } else {
        this.putContrato()
      }
    },
    postContrato() {
      axios
        .post(`/api/${localStorage.getItem('tenant')}/contratos/crear`, this.$data.lista)
        .then(respuesta => {
          this.$emit('recargar')
          this.limpiarFormulario()
          this.$validator.reset()
          modalEmitter.$emit('cerrar', 'tipoContrato')
        })
        .catch(error => {
          this.catchErrorServidor(error)
        })
    },

    putContrato() {
      axios
        .put(`/api/${localStorage.getItem('tenant')}/contratos/${this.lista.id}/editar`, this.$data.lista)
        .then(respuesta => {
          this.$emit('recargar')
          this.limpiarFormulario()
          this.$validator.reset()
          modalEmitter.$emit('cerrar', 'tipoContrato')
        })
        .catch(error => {
          this.catchErrorServidor(error)
        })
    },

    catchErrorServidor(error) {
      if (error.response) {
        this.$swal.fire(
          'Oops!',
          'Han ocurrido errores, por favor intente más tarde',
          'error'
        )
      }
    },
    limpiarFormulario() {
      this.lista.id = this.lista.nombre = ''
    },
  },
}
</script>
