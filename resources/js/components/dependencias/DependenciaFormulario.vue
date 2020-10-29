<template>
  <form @submit.prevent="validarAntesDeEnviar">
    <input type="hidden" v-model="lista.id">
    <div class="form-group">
      <label class="custom-label" for="nombre">Nombre de la dependencia</label>
      <input
        type="text"
        name="nombre"
        v-validate="'required|alpha_spaces|min:3'"
        class="form-control custom-control col-md-7"
        placeholder="Nombre"
        v-model="lista.nombre"
      >
      <small class="invalid col-md-7" v-if="errors.has('nombre')">{{errors.first('nombre')}}</small>
    </div>
    <div class="form-group">
      <label class="custom-label" for="centro_costo_id">Centro de costos</label>
      <multiselect
        :max-height="200"
        name="centro_costo_id"
        placeholder="Seleccione una opción"
        selectLabel="Enter para seleccionar"
        deselectLabel="Enter para remover"
        v-validate="'required'"
        data-vv-as="Centro de costos"
        v-model="centroCostosObjeto"
        :options="centrosCostosDatos"
        class="col-md-7 font-weight-bold"
        label="nombre"
        track-by="id"
      >
        <template slot="noOptions">La lista está vacía</template>
        <template slot="noResult">No existen resultados!</template>
      </multiselect>
      <small
        class="invalid col-md-7"
        v-if="errors.has('centro_costo_id')"
      >{{errors.first('centro_costo_id')}}</small>
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
        centro_costo_id: '',
      },
      centrosCostosDatos: [],
      centroCostosObjeto: '',
    }
  },

  created() {
    this.cargarCentrosCostos()
  },

  methods: {
    async validarAntesDeEnviar() {
      let validado = await this.$validator.validateAll()
      if (validado) {
        this.guardarDependencia()
        return
      }
      this.$swal.fire(
        'Oops!',
        'Debe corregir los errores antes de enviar',
        'error'
      )
    },
    guardarDependencia() {
      this.lista.centro_costo_id = this.centroCostosObjeto.id
      if (!this.lista.id) {
        axios
          .post(`/api/${localStorage.getItem('tenant')}/dependencias/crear`, this.$data.lista)
          .then(respuesta => {
            this.$emit('recargar')
            this.limpiarFormulario()
            this.centroCostosObjeto = null
            this.$validator.reset()
            modalEmitter.$emit('cerrar', 'dependencia')
          })
          .catch(error => {
            this.$swal.fire(
              'Oops!',
              'Han ocurrido errores, por favor intente más tarde',
              'error'
            )
          })
      } else {
        axios
          .put(`/api/${localStorage.getItem('tenant')}/dependencias/${this.lista.id}/editar`, this.$data.lista)
          .then(respuesta => {
            this.$emit('recargar')
            this.limpiarFormulario()
            this.centroCostosObjeto = null
            this.$validator.reset()
            modalEmitter.$emit('cerrar', 'dependencia')
          })
          .catch(error => {
            this.$swal.fire(
              'Oops!',
              'Han ocurrido errores, por favor intente más tarde',
              'error'
            )
          })
      }
    },
    cargarCentrosCostos() {
      axios.get(`/api/${localStorage.getItem('tenant')}/centros_costos/datos`).then(datos => {
        this.centrosCostosDatos = datos.data
      })
    },

    asignarCentroCostos(id) {
      this.centroCostosObjeto = this.centrosCostosDatos.find(centro => {
        return centro.id === id
      })
    },

    limpiarFormulario() {
      this.lista.id = this.lista.nombre = this.lista.centro_costo_id = ''
    },
  },
}
</script>

<style>
</style>
