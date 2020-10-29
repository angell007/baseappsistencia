<template>
  <form @submit.prevent="validarAntesDeEnviar">
    <div class="form-group row">
      <label class="custom-label col-form-label col-md-4" for="eps_id">EPS</label>
      <multiselect
        :max-height="200"
        name="eps_id"
        placeholder="Seleccione una opción"
        selectLabel="Enter para seleccionar"
        deselectLabel="Enter para remover"
        v-validate="'required'"
        data-vv-as="EPS"
        v-model="epsActual"
        :options="epsDatos"
        class="col-md-7 font-weight-bold"
        label="nombre"
        track-by="id"
      >
        <template slot="noOptions">La lista está vacía</template>
        <template slot="noResult">No existen resultados!</template>
      </multiselect>
      <small
        class="invalid col-md-7 offset-4"
        v-if="errors.has('eps_id')"
      >{{errors.first('eps_id')}}</small>
    </div>
    <div class="form-group row">
      <label class="custom-label col-form-label col-md-4" for="pensiones_id">Fondo de Pensiones</label>
      <multiselect
        :max-height="200"
        name="pensiones_id"
        placeholder="Seleccione una opción"
        selectLabel="Enter para seleccionar"
        deselectLabel="Enter para remover"
        v-validate="'required'"
        data-vv-as="Fondo de pensiones"
        v-model="pensionesActual"
        :options="pensionesDatos"
        class="col-md-7 font-weight-bold"
        label="nombre"
        track-by="id"
      >
        <template slot="noOptions">La lista está vacía</template>
        <template slot="noResult">No existen resultados!</template>
      </multiselect>
      <small
        class="invalid col-md-7 offset-4"
        v-if="errors.has('pensiones_id')"
      >{{errors.first('pensiones_id')}}</small>
    </div>

    <div class="form-group row">
      <label class="custom-label col-form-label col-md-4" for="cesantias_id">Fondo de Cesantías</label>
      <multiselect
        :max-height="200"
        name="cesantias_id"
        placeholder="Seleccione una opción"
        selectLabel="Enter para seleccionar"
        deselectLabel="Enter para remover"
        v-validate="'required'"
        data-vv-as="Fondo de cesantías"
        v-model="cesantiasActual"
        :options="cesantiasDatos"
        class="col-md-7 font-weight-bold"
        label="nombre"
        track-by="id"
      >
        <template slot="noOptions">La lista está vacía</template>
        <template slot="noResult">No existen resultados!</template>
      </multiselect>
      <small
        class="invalid col-md-7 offset-4"
        v-if="errors.has('cesantias_id')"
      >{{errors.first('cesantias_id')}}</small>
    </div>
    <div class="form-group row">
      <label class="custom-label col-form-label col-md-4" for="caja_compensacion_id">C. Compensación</label>
      <multiselect
        :max-height="200"
        name="caja_compensacion_id"
        placeholder="Seleccione una opción"
        selectLabel="Enter para seleccionar"
        deselectLabel="Enter para remover"
        v-validate="'required'"
        data-vv-as="Caja de compensación"
        v-model="compensacionActual"
        :options="compensacionesDatos"
        class="col-md-7 font-weight-bold"
        label="nombre"
        track-by="id"
      >
        <template slot="noOptions">La lista está vacía</template>
        <template slot="noResult">No existen resultados!</template>
      </multiselect>
      <small
        class="invalid col-md-7 offset-4"
        v-if="errors.has('caja_compensacion_id')"
      >{{errors.first('caja_compensacion_id')}}</small>
    </div>

    <div class="form-group text-right">
      <button type="submit" class="btn btn-secondary raised">Actualizar</button>
    </div>
  </form>
</template>

<script>
export default {
  props: {
    funcionarioEditar: Object,
  },
  data() {
    return {
      mostrarModal: false,
      epsDatos: [],
      cesantiasDatos: [],
      pensionesDatos: [],
      compensacionesDatos: [],
      epsActual: '',
      cesantiasActual: '',
      pensionesActual: '',
      compensacionActual: '',
    }
  },

  created() {
    this.cargarEps()
    this.cargarCesantias()
    this.cargarPensiones()
    this.cargarCompensaciones()
  },

  methods: {
    async validarAntesDeEnviar() {
      let validado = await this.$validator.validateAll()
      if (validado) {
        this.actualizarAfiliaciones()
        return
      }
      this.$swal.fire(
        'Oops!',
        'Debe corregir los errores antes de enviar',
        'error'
      )
    },
    actualizarAfiliaciones() {
      this.funcionarioEditar.eps_id = this.epsActual.id
      this.funcionarioEditar.cesantias_id = this.cesantiasActual.id
      this.funcionarioEditar.pensiones_id = this.pensionesActual.id
      this.funcionarioEditar.caja_compensacion_id = this.compensacionActual.id
      this.funcionarioEditar.image='';
      delete this.funcionarioEditar["image"];
      axios
        .post(
          `/api/${localStorage.getItem('tenant')}/funcionarios/${this.funcionarioEditar.id}/editar`,
          this.funcionarioEditar
        )
        .then(respuesta => {
          this.$emit('notificar', respuesta.data.message)
          this.funcionarioEditar.eps.nombre = this.epsActual.nombre
          this.funcionarioEditar.cesantias.nombre = this.cesantiasActual.nombre
          this.funcionarioEditar.pensiones.nombre = this.pensionesActual.nombre
          this.funcionarioEditar.caja_compensacion.nombre = this.compensacionActual.nombre
          modalEmitter.$emit('cerrar', 'datosAfiliaciones')
        })
        .catch(error => {
          this.$swal.fire(
            'Oops!',
            'Han ocurrido errores, por favor intentar más tarde',
            'error'
          )
        })
    },

    cargarCesantias() {
      axios.get(`/api/${localStorage.getItem('tenant')}/cesantias/datos`).then(datos => {
        this.cesantiasDatos = datos.data
        this.cesantiasActual = this.getDatoActual(
          this.cesantiasDatos,
          'cesantias_id'
        )
      })
    },

    cargarEps() {
      axios.get(`/api/${localStorage.getItem('tenant')}/eps/datos`).then(datos => {
        this.epsDatos = datos.data
        this.epsActual = this.getDatoActual(this.epsDatos, 'eps_id')
      })
    },
    cargarPensiones() {
      axios.get(`/api/${localStorage.getItem('tenant')}/pensiones/datos`).then(datos => {
        this.pensionesDatos = datos.data
        this.pensionesActual = this.getDatoActual(
          this.pensionesDatos,
          'pensiones_id'
        )
      })
    },
    cargarCompensaciones() {
      axios.get(`/api/${localStorage.getItem('tenant')}/compensaciones/datos`).then(datos => {
        this.compensacionesDatos = datos.data
        this.compensacionActual = this.getDatoActual(
          this.compensacionesDatos,
          'caja_compensacion_id'
        )
      })
    },
    getDatoActual(arrayDatos, datoComparacion) {
      return arrayDatos.find(dato => {
        return dato.id === this.funcionarioEditar[datoComparacion]
      })
    },
  },
}
</script>

<style>
</style>
