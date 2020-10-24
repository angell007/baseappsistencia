<template>
  <div class="container">
    <!-- Prestaciones sociales - inicio -->
    <fieldset>
      <legend class="text-right">Prestaciones sociales</legend>
      <div class="separator mb-5"></div>

      <div class="form-row">
        <div class="col-md-5 offset-1">
          <div class="form-group row mt-4">
            <label for="eps_id" class="col-md-4 col-form-label custom-label text-right">EPS</label>
            <multiselect
              :max-height="200"
              name="eps_id"
              placeholder="Seleccione una opción"
              selectLabel="Enter para seleccionar"
              deselectLabel="Enter para remover"
              v-validate="'required'"
              data-vv-as="EPS"
              v-model="multiSelect.eps_id"
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
            <label
              for="caja_compensacion_id"
              class="col-md-4 col-form-label custom-label text-right"
            >C Compensación</label>
            <multiselect
              :max-height="200"
              name="caja_compensacion_id"
              placeholder="Seleccione una opción"
              selectLabel="Enter para seleccionar"
              deselectLabel="Enter para remover"
              v-validate="'required'"
              data-vv-as="Caja de compensación"
              v-model="multiSelect.caja_compensacion_id"
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
        </div>

        <div class="col-md-5">
          <div class="form-group row mt-4">
            <label
              for="cesantias_id"
              class="col-md-4 col-form-label custom-label text-right"
            >Fondo Cesantías</label>
            <multiselect
              :max-height="200"
              name="cesantias_id"
              placeholder="Seleccione una opción"
              selectLabel="Enter para seleccionar"
              deselectLabel="Enter para remover"
              v-validate="'required'"
              data-vv-as="Fondo de cesantías"
              v-model="multiSelect.cesantias_id"
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
            <label
              for="pensiones_id"
              class="col-md-4 col-form-label custom-label text-right"
            >Fondo Pensiones</label>
            <multiselect
              :max-height="200"
              name="pensiones_id"
              placeholder="Seleccione una opción"
              selectLabel="Enter para seleccionar"
              deselectLabel="Enter para remover"
              v-validate="'required'"
              data-vv-as="Fondo de pensiones"
              v-model="multiSelect.pensiones_id"
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
        </div>
      </div>
    </fieldset>
    <!-- Prestaciones sociales - fin -->
  </div>
</template>

<script>
import atributos from './datos/atributosFuncionario'
import Calendario from '../../../utiles/Calendario'
export default {
  data() {
    return {
      epsDatos: [],
      cesantiasDatos: [],
      pensionesDatos: [],
      compensacionesDatos: [],
      prestaciones: '',
      multiSelect: '',
    }
  },
  created() {
    this.prestaciones = atributos.funcionario.prestaciones
    this.multiSelect = atributos.multiSelect.prestaciones
    this.getEps()
    this.getCesantias()
    this.getPensiones()
    this.getCompensaciones()
  },
  methods: {
    async validarAntesDeEnviar() {
      let validado = await this.$validator.validateAll()
      if (!validado) {
        this.$swal.fire('Oops!', 'Corrige los errores antes de enviar', 'error')
        return false
      }
      return true
    },
    async guardarPrestaciones() {
      let pasoValidacion = await this.validarAntesDeEnviar()

      if (pasoValidacion) {
        this.actualizarPropiedades()
        return true
      }
    },
    getEps() {
      axios.get('/api/eps/datos').then(datos => {
        this.epsDatos = datos.data
      })
    },
    getCesantias() {
      axios.get('/api/cesantias/datos').then(datos => {
        this.cesantiasDatos = datos.data
      })
    },
    getPensiones() {
      axios.get('/api/pensiones/datos').then(datos => {
        this.pensionesDatos = datos.data
      })
    },
    getCompensaciones() {
      axios.get('/api/compensaciones/datos').then(datos => {
        this.compensacionesDatos = datos.data
      })
    },
    actualizarPropiedades() {
      for (let propiedad in this.multiSelect) {
        if (this.multiSelect[propiedad] instanceof Object) {
          this.prestaciones[propiedad] = this.multiSelect[propiedad].id
        }
      }
    },
    limpiarDatos() {
      for (let propiedad in this.prestaciones) {
        this.prestaciones[propiedad] = ''
      }
      for (let propiedad in this.multiSelect) {
        this.multiSelect[propiedad] = ''
      }
    },
  },
}
</script>