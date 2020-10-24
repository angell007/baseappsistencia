<template>
  <form @submit.prevent="validarAntesDeEnviar">
    <input type="hidden" v-model="lista.id">
    <div class="form-group">
      <label class="custom-label" for="nombre">Nombre</label>
      <input
        type="text"
        class="form-control custom-control col-md-7"
        name="nombre"
        v-validate="'required|min:3|alpha_spaces'"
        data-vv-as="nombre"
        placeholder="Nombre"
        v-model="lista.nombre"
      >
      <small class="invalid col-md-7" v-if="errors.has('nombre')">{{errors.first('nombre')}}</small>
    </div>
    <div class="form-group">
      <label class="custom-label" for="dependencia_id">Dependencia</label>
      <multiselect
        :max-height="200"
        name="dependencia_id"
        placeholder="Seleccione una opción"
        selectLabel="Enter para seleccionar"
        deselectLabel="Enter para remover"
        v-validate="'required'"
        data-vv-as="Dependencia"
        v-model="dependenciaObjeto"
        :options="dependenciasDatos"
        class="col-md-7 font-weight-bold"
        label="nombre"
        track-by="id"
      >
        <template slot="noOptions">La lista está vacía</template>
        <template slot="noResult">No existen resultados!</template>
      </multiselect>
      <small
        class="invalid col-md-7"
        v-if="errors.has('dependencia_id')"
      >{{errors.first('dependencia_id')}}</small>
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
      mostrarModal: false,
      lista: {
        id: '',
        nombre: '',
        dependencia_id: '',
      },
      dependenciasDatos: [],
      dependenciaObjeto: '',
    }
  },

  created() {
    this.cargarDependencias()
  },

  methods: {
    async validarAntesDeEnviar() {
      let validado = await this.$validator.validateAll()
      if (validado) {
        this.guardarCargo()
        return
      }
      this.$swal.fire(
        'Oops!',
        'Debe corregir los errores antes de enviar',
        'error'
      )
    },
    guardarCargo() {
      this.lista.dependencia_id = this.dependenciaObjeto.id
      if (!this.lista.id) {
        axios
          .post('/api/cargos/crear', this.$data.lista)
          .then(respuesta => {
            this.finalizar()
          })
          .catch(error => {
            this.$swal.fire(
              'Oops!',
              'Han ocurrido errores, por favor intentar más tarde',
              'error'
            )
          })
      } else {
        axios
          .put(`/api/cargos/${this.lista.id}/editar`, this.$data.lista)
          .then(respuesta => {
            this.finalizar()
          })
          .catch(error => {
            this.$swal.fire(
              'Oops!',
              'Han ocurrido errores, por favor intentar más tarde',
              'error'
            )
          })
      }
    },
    cargarDependencias() {
      axios.get('/api/dependencias/datos').then(datos => {
        this.dependenciasDatos = datos.data
      })
    },
    asignarDependencia(id) {
      this.dependenciaObjeto = this.dependenciasDatos.find(dependencia => {
        return dependencia.id === id
      })
    },
    limpiarFormulario() {
      this.lista.id = this.lista.nombre = this.lista.dependencia_id = ''
    },
    finalizar() {
      this.$emit('recargar')
      this.limpiarFormulario()
      this.$validator.reset()
      modalEmitter.$emit('cerrar', 'cargo')
    },
  },
}
</script>

<style>
</style>
