<template>
  <form @submit.prevent="validarAntesDeEnviar">
    <input type="hidden" v-model="lista.id">
    <div class="form-group">
      <label for="nombre" class="custom-label">Nombre</label>
      <input
        type="text"
        class="form-control custom-control col-md-8"
        name="nombre"
        v-validate="'required|alpha_spaces|min:3'"
        data-vv-as="Nombre"
        placeholder="Nombre"
        v-model="lista.nombre"
      >
      <small class="invalid" v-if="errors.has('nombre')">{{errors.first('nombre')}}</small>
    </div>
    <div class="form-group">
      <label for="prefijo_cuenta_contable" class="custom-label">Código</label>
      <input
        type="text"
        class="form-control custom-control col-md-8"
        name="codigo"
        v-validate="'required|alpha_num|min:2'"
        data-vv-as="Código"
        placeholder="Código"
        v-model="lista.codigo"
      >
      <small class="invalid" v-if="errors.has('codigo')">{{errors.first('codigo')}}</small>
    </div>

    <div class="form-group">
      <label for="prefijo_cuenta_contable" class="custom-label">Prefijo cuenta contable</label>
      <input
        type="text"
        class="form-control custom-control col-md-8"
        name="prefijo_cuenta_contable"
        v-validate="'required|min:2'"
        data-vv-as="Prefijo"
        placeholder="Prefijo cuenta"
        v-model="lista.prefijo_cuenta_contable"
      >
      <small
        class="invalid"
        v-if="errors.has('prefijo_cuenta_contable')"
      >{{errors.first('prefijo_cuenta_contable')}}</small>
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
  data() {
    return {
      lista: {
        id: '',
        nombre: '',
        codigo: '',
        prefijo_cuenta_contable: '',
      },
    }
  },

  methods: {
    async validarAntesDeEnviar() {
      let validado = await this.$validator.validateAll()
      if (validado) {
        this.guardarCentroCostos()
        return
      }
      this.$swal.fire(
        'Oops!',
        'Debe corregir los errores antes de enviar!',
        'error'
      )
    },
    guardarCentroCostos() {
      if (!this.lista.id) {
        axios
          .post(`/api/${localStorage.getItem('tenant')}/centros_costos/crear`, this.$data.lista)
          .then(respuesta => {
            this.$emit('recargar')
            this.limpiarFormulario()
            this.$validator.reset()
            modalEmitter.$emit('cerrar', 'centroCostos')
          })
          .catch(error => {
            this.$swal.fire(
              'Oops!',
              'Ha ocurrido un error, por favor intente más tarde',
              'error'
            )
          })
      } else {
        axios
          .put(`/api/${localStorage.getItem('tenant')}/centros_costos/${this.lista.id}/editar`, this.$data.lista)
          .then(respuesta => {
            this.$emit('recargar')
            this.limpiarFormulario()
            this.$validator.reset()
            modalEmitter.$emit('cerrar', 'centroCostos')
          })
          .catch(error => {
            this.$swal.fire(
              'Oops!',
              'Ha ocurrido un error, por favor intente más tarde',
              'error'
            )
          })
      }
    },

    limpiarFormulario() {
      for (let propiedad in this.lista) {
        this.lista[propiedad] = ''
      }
    },
  },
}
</script>

<style scoped>
</style>
