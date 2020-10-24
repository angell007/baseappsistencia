<template>
  <form @submit.prevent="validarAntesDeEnviar">
    <input type="hidden" v-model="lista.id">
    <div class="form-group row">
      <label for="nombre" class="custom-label col-form-label col-md-4">Nombre</label>
      <input
        type="text"
        class="form-control col-md-6 custom-control"
        name="nombre"
        v-validate="'required|alpha_spaces'"
        placeholder="Eps"
        v-model="lista.nombre"
      >
      <small
        class="invalid col-md-6 offset-4"
        v-if="errors.has('nombre')"
      >{{errors.first('nombre')}}</small>
    </div>
    <div class="form-group row">
      <label for="nit" class="custom-label col-form-label col-md-4">Nit</label>
      <input
        type="text"
        class="form-control col-md-6 custom-control"
        name="nit"
        v-validate="'required|numeric|min:8'"
        placeholder="NIT"
        v-model="lista.nit"
      >
      <small class="invalid col-md-6 offset-4" v-if="errors.has('nit')">{{errors.first('nit')}}</small>
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
        nit: '',
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
        this.postEps()
      } else {
        this.putEps()
      }
    },
    postEps() {
      axios
        .post('/api/eps/crear', this.$data.lista)
        .then(respuesta => {
          this.$emit('recargar')
          this.limpiarFormulario()
          this.$validator.reset()
          modalEmitter.$emit('cerrar', 'eps')
        })
        .catch(error => {
          this.catchErrorServidor(error)
        })
    },

    putEps() {
      axios
        .put(`/api/eps/${this.lista.id}/editar`, this.$data.lista)
        .then(respuesta => {
          this.$emit('recargar')
          this.limpiarFormulario()
          this.$validator.reset()
          modalEmitter.$emit('cerrar', 'eps')
        })
        .catch(error => {
          this.catchErrorServidor(error)
        })
    },

    catchErrorServidor(error) {
      if (error.response) {
        this.$swal.fire(
          'Error!',
          'Han ocurrido errores, por favor intente más tarde',
          'error'
        )
      }
    },

    limpiarFormulario() {
      this.lista.id = this.lista.nombre = this.lista.nit = ''
    },
  },
}
</script>
