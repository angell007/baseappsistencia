<template>
  <div class="container">
    <!-- Información empresa - inicio  -->

    <fieldset>
      <div class="separator mb-5"></div>
      <legend class="text-right">Información de empresa</legend>

      <div class="form-row mt-4">
        <div class="col-md-5 offset-1">
          <div class="form-group row">
            <label
              for="centro_costo_id"
              class="col-md-4 col-form-label custom-label text-right"
            >Centro de costos</label>
            <multiselect
              :max-height="200"
              name="centro_costo_id"
              placeholder="Seleccione una opción"
              selectLabel="Enter para seleccionar"
              deselectLabel="Enter para remover"
              v-validate="'required'"
              data-vv-as="Centro de costos"
              v-model="multiSelect.centro_costo_id"
              :options="centrosCostosDatos"
              class="col-md-7 font-weight-bold"
              label="nombre"
              track-by="id"
              @input="getDependencias(multiSelect.centro_costo_id)"
            >
              <template slot="noOptions">La lista está vacía</template>
              <template slot="noResult">No existen resultados!</template>
            </multiselect>
            <div class="col-md-7 offset-4" v-if="errors.has('centro_costo_id')">
              <small class="invalid">{{errors.first('centro_costo_id')}}</small>
            </div>
          </div>

          <div class="form-group row">
            <label
              for="dependencia_id"
              class="col-md-4 col-form-label custom-label text-right"
            >Dependencia</label>
            <multiselect
              :max-height="200"
              name="dependencia_id"
              placeholder="Seleccione una opción"
              selectLabel="Enter para seleccionar"
              deselectLabel="Enter para remover"
              v-validate="'required'"
              data-vv-as="Dependencia"
              v-model="multiSelect.dependencia_id"
              :options="dependenciasDatos"
              class="col-md-7 font-weight-bold"
              label="nombre"
              track-by="id"
              :disabled="!multiSelect.centro_costo_id"
              @input="getCargos(multiSelect.dependencia_id)"
            >
              <template slot="noOptions">La lista está vacía</template>
              <template slot="noResult">No existen resultados!</template>
            </multiselect>
            <small
              class="invalid col-md-7 offset-4"
              v-if="errors.has('dependencia_id')"
            >{{errors.first('dependencia_id')}}</small>
          </div>

          <div class="form-group row">
            <label for="cargo_id" class="col-md-4 col-form-label custom-label text-right">Cargo</label>
            <multiselect
              :max-height="200"
              name="cargo_id"
              placeholder="Seleccione una opción"
              selectLabel="Enter para seleccionar"
              deselectLabel="Enter para remover"
              v-validate="'required'"
              data-vv-as="Cargo"
              v-model="multiSelect.cargo_id"
              :options="cargosDatos"
              class="col-md-7 font-weight-bold"
              label="nombre"
              track-by="id"
              :disabled="!multiSelect.dependencia_id"
            >
              <template slot="noOptions">La lista está vacía</template>
              <template slot="noResult">No existen resultados!</template>
            </multiselect>
            <div class="col-md-12 text-center" v-if="errors.has('cargo_id')">
              <small class="invalid">{{errors.first('cargo_id')}}</small>
            </div>
          </div>

          <div class="form-group row">
            <label for="salario" class="col-md-4 col-form-label custom-label text-right">Salario</label>
            <input
              type="text"
              name="salario"
              v-validate="'required|numeric|min_value:0'"
              data-vv-as="Salario"
              class="form-control custom-control col-md-7"
              v-model="informacionEmpresa.salario"
            >
            <div class="col-md-7 offset-4" v-if="errors.has('salario')">
              <small class="invalid">{{errors.first('salario')}}</small>
            </div>
          </div>
        </div>

        <div class="col-md-5">
          <div class="form-group row">
            <label
              for="fecha_ingreso"
              class="col-md-4 col-form-label custom-label text-right"
            >Fecha de Ingreso</label>

            <calendario ref="fechaIngreso" customWidth="280" class="col-md-6 pl-0"></calendario>
          </div>

          <div class="form-group row">
            <label
              for="tipo_contrato_id"
              class="col-md-4 col-form-label custom-label text-right"
            >Tipo de Contrato</label>
            <multiselect
              :max-height="200"
              name="tipo_contrato_id"
              placeholder="Seleccione una opción"
              selectLabel="Enter para seleccionar"
              deselectLabel="Enter para remover"
              v-validate="'required'"
              data-vv-as="Tipo de contrato"
              v-model="multiSelect.tipo_contrato_id"
              :options="contratosDatos"
              class="col-md-7 font-weight-bold"
              label="nombre"
              track-by="id"
              @input="toggleFechaRetiro(multiSelect.tipo_contrato_id)"
            >
              <template slot="noOptions">La lista está vacía</template>
              <template slot="noResult">No existen resultados!</template>
            </multiselect>
            <small
              class="invalid col-md-7 offset-4"
              v-if="errors.has('tipo_contrato_id')"
            >{{errors.first('tipo_contrato_id')}}</small>
          </div>

          <div class="form-group row" v-show="showFechaRetiro">
            <label
              for="fecha_retiro"
              class="col-md-4 col-form-label custom-label text-right"
            >Fecha de retiro</label>

            <calendario ref="fechaRetiro" customWidth="280" class="col-md-6 pl-0"></calendario>
          </div>

          <div class="form-group row">
            <label
              for="tipo_turno"
              class="col-md-4 col-form-label custom-label text-right"
            >Tipo de Turno</label>
            <select
              name="tipo_turno"
              v-model="informacionEmpresa.tipo_turno"
              class="form-control custom-control col-md-7"
              @change="toggleTurnosFijos(informacionEmpresa.tipo_turno)"
            >
              <option
                v-for="(tipo,index) in turnosDatos"
                :key="index"
                :value="tipo.valor"
              >{{tipo.clave}}</option>
            </select>
            <small
              class="invalid col-md-7 offset-4"
              v-if="errors.has('tipo_turno')"
            >{{errors.first('tipo_turno')}}</small>
          </div>

          <div class="form-group row" v-show="showTurnosFijos">
            <label
              for="turno_fijo_id"
              class="col-md-4 col-form-label custom-label text-right"
            >Turno Asignado</label>
            <select
              name="turno_fijo_id"
              v-model="informacionEmpresa.turno_fijo_id"
              class="form-control custom-control col-md-7"

            >
              <option
                v-for="(tipo,index) in turnosFijosDatos"
                :key="index"
                :value="tipo.id"
              >{{tipo.nombre}}</option>
            </select>
            <small
              class="invalid col-md-7 offset-4"
              v-if="errors.has('tipo_turno')"
            >{{errors.first('tipo_turno')}}</small>
          </div>


          <div class="form-group row">
            <label for="jefe" class="col-md-4 col-form-label custom-label text-right">Jefe Directo</label>
            <multiselect
              :max-height="200"
              name="jefe_id"
              placeholder="Seleccione una opción"
              selectLabel="Enter para seleccionar"
              deselectLabel="Enter para remover"
              v-validate="'required'"
              data-vv-as="Jefe directo"
              v-model="multiSelect.jefe_id"
              :options="jefesDatos"
              class="col-md-7 font-weight-bold"
              label="nombre"
              track-by="id"
              :disabled="noExistenJefes"
            >
              <template slot="noOptions">La lista está vacía</template>
              <template slot="noResult">No existen resultados!</template>
            </multiselect>
            <small
              v-if="noExistenJefes"
              class="col-md-7 offset-4 font-weight-bold"
            >No existen jefes actualmente</small>
            <div class="col-md-12 text-center" v-if="errors.has('jefe')">
              <small class="invalid">{{errors.first('jefe')}}</small>
            </div>
          </div>
        </div>
      </div>
    </fieldset>
    <!-- Información empresa - fin  -->
  </div>
</template>

<script>
import atributos from './datos/atributosFuncionario'
import Calendario from '../../../utiles/Calendario'
export default {
  components: { Calendario },
  data() {
    return {
      centrosCostosDatos: [],
      dependenciasDatos: [],
      cargosDatos: [],
      turnosDatos: [],
      turnosFijosDatos:[],
      jefesDatos: [],
      contratosDatos: [],
      noExistenJefes: '',
      multiSelect: '',
      informacionEmpresa: '',
      showFechaRetiro: false,
      showTurnosFijos:true
    }
  },
  created() {
    this.informacionEmpresa = atributos.funcionario.informacionEmpresa
    this.turnosDatos = atributos.datos.tipoTurno
    this.multiSelect = atributos.multiSelect.informacionEmpresa
    this.getCentrosCostos()
    this.getJefes()
    this.getContratos()
    this.getTurnosFijos();
  },

  methods: {
    async validarAntesDeEnviar() {
      
      let validado = await this.$validator.validateAll()
      console.log(validado);

      if (!validado) {
        this.$swal.fire('Oops!', 'Corrige los errores antes de enviar', 'error')
        return false
      }
      return true
    },
    async guardarInformacionEmpresa() {
      let pasoValidacion = await this.validarAntesDeEnviar()

      if (pasoValidacion && this.verificarFechasContrato()) {
        this.informacionEmpresa.fecha_ingreso = this.$refs.fechaIngreso.formatearFecha()

        this.informacionEmpresa.fecha_retiro = this.isContratoConFechaRetiro()
          ? this.$refs.fechaRetiro.formatearFecha()
          : ''

        this.actualizarPropiedades()
        return true
      }
    },
    getJefes() {
      axios.get(`/api/${localStorage.getItem('tenant')}/jefes`).then(datos => {
        this.jefesDatos = datos.data
        this.existenJefes()
      })
    },
    existenJefes() {
      this.noExistenJefes = this.jefesDatos.length === 0 ? true : false
    },
    getCentrosCostos() {
      axios.get(`/api/${localStorage.getItem('tenant')}/centros_costos/dependencias/datos`).then(datos => {
        this.centrosCostosDatos = datos.data
      })
    },
    getTurnosFijos(){
       axios.get(`/api/${localStorage.getItem('tenant')}/turnos/fijos/datos`).then(datos => {
        this.turnosFijosDatos = datos.data
      })
    },
    getDependencias(idCentroCostos) {
      if (idCentroCostos === null) {
        return false
      }
      let centroSeleccionado = this.centrosCostosDatos.find(centroCostos => {
        return centroCostos.id === idCentroCostos.id
      })
      this.dependenciasDatos = centroSeleccionado.dependencias
    },

    getCargos(idDependencia) {
      if (idDependencia === null) {
        return false
      }
      let dependenciaSeleccionada = this.dependenciasDatos.find(dependencia => {
        return dependencia.id === idDependencia.id
      })
      this.cargosDatos = dependenciaSeleccionada.cargos
    },

    getContratos() {
      axios.get(`/api/${localStorage.getItem('tenant')}/contratos/datos`).then(datos => {
        this.contratosDatos = datos.data
      })
    },
    actualizarPropiedades() {
      for (let propiedad in this.multiSelect) {
        if (this.multiSelect[propiedad] instanceof Object) {
          this.informacionEmpresa[propiedad] = this.multiSelect[propiedad].id
        }
      }
    },
    toggleFechaRetiro(contrato) {
      if (contrato) {
        this.showFechaRetiro = this.isContratoConFechaRetiro()
      }
    },

    toggleTurnosFijos(tipo_turno) {
      if (tipo_turno=="Rotativo") {
        this.showTurnosFijos=false;
      }else{
          this.showTurnosFijos=true;
      }
    },
    verificarFechasContrato() {
      if (this.isContratoConFechaRetiro()) {
        if (
          this.$refs.fechaIngreso.formatearFecha() >
          this.$refs.fechaRetiro.formatearFecha()
        ) {
          this.$swal.fire(
            'Error de Fechas!',
            'La fecha de ingreso no puede ser mayor que la de retiro',
            'error'
          )
          return false
        }
      }
      return true
    },

    isContratoConFechaRetiro() {
      return (
        this.multiSelect.tipo_contrato_id.id !== 2 &&
        this.multiSelect.tipo_contrato_id.id !== 5
      )
    },

    limpiarDatos() {
      for (let propiedad in this.informacionEmpresa) {
        if (propiedad === 'tipo_turno') {
          continue
        }
        this.informacionEmpresa[propiedad] = ''
      }
      for (let propiedad in this.multiSelect) {
        this.multiSelect[propiedad] = ''
      }
    },
  },
}
</script>
