<template>
  <form @submit.prevent="validarAntesDeEnviar">
    <input type="hidden" v-model="lista.id">
    <div class="form-group row">
      <label for="nombre" class="custom-label col-form-label col-md-3">Nombre</label>
      <input
        type="text"
        class="form-control custom-control col-md-6"
        name="nombre"
        v-validate="'required|alpha_spaces|min:3'"
        data-vv-as="Nombre"
        placeholder="Ingrese el nombre"
        v-model="lista.nombre"
      >
      <small
        class="invalid col-md-6 offset-3"
        v-if="errors.has('nombre')"
      >{{errors.first('nombre')}}</small>
    </div>
    <div class="form-group row">
      <label for="nit" class="custom-label col-form-label col-md-3">NIT</label>
      <input
        type="text"
        class="form-control custom-control col-md-6"
        name="nit"
        v-validate="'required|numeric|min:8'"
        data-vv-as="NIT"
        placeholder="Ingrese el nit"
        v-model="lista.nit"
      >
      <small class="invalid col-md-7 offset-3" v-if="errors.has('nit')">{{errors.first('nit')}}</small>
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
        this.postCompensacion()
      } else {
        this.putCompensacion()
      }
    },

    postCompensacion() {
      axios
        .post('/api/compensaciones/crear', this.$data.lista)
        .then(respuesta => {
          this.$emit('recargar')
          this.limpiarDatos()
          this.$validator.reset()
          modalEmitter.$emit('cerrar', 'compensacion')
        })
        .catch(error => {
          this.catchErrorServidor(error)
        })
    },

    putCompensacion() {
      axios
        .put(`/api/compensaciones/${this.lista.id}/editar`, this.$data.lista)
        .then(respuesta => {
          this.$emit('recargar')
          this.limpiarDatos()
          this.$validator.reset()
          modalEmitter.$emit('cerrar', 'compensacion')
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

    limpiarDatos() {
      this.lista.id = this.lista.nombre = this.lista.nit = ''
    },
  },
}
</script>
